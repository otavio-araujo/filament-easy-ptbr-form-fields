<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields\Services;

use Filament\Notifications\Notification;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class CepService
{
    public static function get(string $cep): array
    {
        $response = [];

        $cep = self::sanitizeCep($cep);

        try {
            $response = Http::get('https://viacep.com.br/ws/' . $cep . '/json/')->json();

            if (Arr::has($response, 'erro')) {
                Notification::make()
                    ->warning()
                    ->title('CEP inválido')
                    ->body('O CEP informado é inválido.')
                    ->send();

                return [];
            }

            return self::formatResponseData($response, 'viacep');

        } catch (ConnectionException $ignored) {
            Notification::make()
                ->warning()
                ->title('Viacep indisponível')
                ->body('Tentaremos agora pelo BrasilAPI.')
                ->send();
        }

        try {
            $response = Http::get("https://brasilapi.com.br/api/cep/v1/{$cep}")->json();

            if (Arr::has($response, 'errors')) {
                Notification::make()
                    ->warning()
                    ->title('CEP inválido')
                    ->body('O CEP informado é inválido.')
                    ->send();

                return [];
            }

            return self::formatResponseData($response, 'brasilapi');

        } catch (ConnectionException $ignored) {
            Notification::make()
                ->warning()
                ->title('BrasilAPI indisponível')
                ->body('Tentaremos agora pelo BrasilAPI.')
                ->send();
        }

        try {
            $response = Http::get("https://cep.awesomeapi.com.br/json/{$cep}")->json();

            if (in_array('not_found', $response, true)) {
                Notification::make()
                    ->warning()
                    ->title('CEP inválido')
                    ->body('O CEP informado é inválido.')
                    ->send();

                return [];
            }

            return self::formatResponseData($response, 'awesomeapi');

        } catch (ConnectionException $ignored) {
            Notification::make()
                ->warning()
                ->title('API\'S para Busca de CEP indisponíveis')
                ->body('Tente novamente mais tarde.')
                ->send();
        }

        return $response;
    }

    private static function formatResponseData(array $responseData, string $serviceName): array
    {
        if ($serviceName === 'viacep') {
            return [
                'street' => Arr::get($responseData, 'logradouro'),
                'neighborhood' => Arr::get($responseData, 'bairro'),
                'city' => Arr::get($responseData, 'localidade'),
                'state' => Arr::get($responseData, 'estado'),
                'state_code' => Arr::get($responseData, 'uf'),
                'ibge_code' => Arr::get($responseData, 'ibge'),
            ];
        }

        if ($serviceName === 'brasilapi') {
            return [
                'street' => Arr::get($responseData, 'street'),
                'neighborhood' => Arr::get($responseData, 'neighborhood'),
                'city' => Arr::get($responseData, 'city'),
                'state' => Arr::get($responseData, 'state') | null,
                'state_code' => Arr::get($responseData, 'uf'),
                'ibge_code' => Arr::get($responseData, 'ibge') | null,
            ];
        }

        if ($serviceName === 'awesomeapi') {
            return [
                'street' => Arr::get($responseData, 'address'),
                'neighborhood' => Arr::get($responseData, 'district'),
                'city' => Arr::get($responseData, 'city'),
                'state' => null,
                'state_code' => Arr::get($responseData, 'state'),
                'ibge_code' => Arr::get($responseData, 'city_ibge'),
            ];
        }

        return [];
    }

    private static function sanitizeCep(string $cep): string
    {
        return preg_replace('/[^0-9]/', '', $cep);
    }
}
