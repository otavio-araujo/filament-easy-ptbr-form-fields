<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Http;
use Livewire\Component as Livewire;

class CepField extends TextInput
{
    private string $actionPosition = 'suffix';

    private string $actionLabel = 'Buscar CEP';

    private bool $actionLabelHidden = false;

    private string $streetField = 'street';

    private string $neighborhoodField = 'neighborhood';

    private string $cityField = 'city';

    private string $stateField = 'state';

    private string $stateCodeField = 'state_code';

    private string $ibgeCodeField = 'ibge_code';

    private string $countryField = 'country';

    private string $countryCodeField = 'country_code';

    protected function setUp(): void
    {
        parent::setUp();
        $this
            ->mask('99999-999')
            ->minLength(9)
            ->afterStateUpdated(function ($state, Livewire $livewire, Set $set, Component $component) {
                $this->getCep($state, $set);
            })
            ->suffixAction(function () {
                if ($this->actionPosition === 'suffix') {
                    return Action::make('search-action-' . $this->getKey())
                        ->label($this->actionLabel)
                        ->hiddenLabel($this->actionLabelHidden)
                        ->icon('heroicon-o-magnifying-glass')
                        ->action(function ($state, Livewire $livewire, Set $set, Component $component) {
                            $this->getCep($state, $set);
                        });
                    //                        ->cancelParentActions();
                }

                return null;
            });
    }

    public function actionPosition($position): static
    {
        $this->actionPosition = $position;

        return $this;
    }

    public function setStreetField(string $name): static
    {
        $this->streetField = $name;

        return $this;
    }

    public function setNeighborhoodField(string $name): static
    {
        $this->neighborhoodField = $name;

        return $this;
    }

    public function setCityField(string $name): static
    {
        $this->cityField = $name;

        return $this;
    }

    public function setStateField(string $name): static
    {
        $this->stateField = $name;

        return $this;
    }

    public function setStateCodeField(string $name): static
    {
        $this->stateCodeField = $name;

        return $this;
    }

    public function setIbgeCodeField(string $name): static
    {
        $this->ibgeCodeField = $name;

        return $this;
    }

    public function setCountryField(string $name): static
    {
        $this->countryField = $name;

        return $this;
    }

    public function setCountryCodeField(string $name): static
    {
        $this->countryCodeField = $name;

        return $this;
    }

    private function getCep($state, $set): void
    {
        $response = Http::get('https://viacep.com.br/ws/' . $state . '/json/')->json();
        $set($this->streetField, $response['logradouro']);
        $set($this->neighborhoodField, $response['bairro']);
        $set($this->cityField, $response['localidade']);
        $set($this->stateField, $response['estado']);
        $set($this->stateCodeField, $response['uf']);
        $set($this->ibgeCodeField, $response['ibge']);
        $set($this->countryField, 'Brasil');
        $set($this->countryCodeField, 'BR');
        Notification::make()
            ->success()
            ->title('CEP Encontrado')
            ->body('CEP: ' . $state)
            ->send();
    }
}
