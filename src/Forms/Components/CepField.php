<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;
use Livewire\Component as Livewire;
use OtavioAraujo\FilamentEasyPtbrFormFields\Services\CepService;

class CepField extends TextInput
{
    private string $actionPosition = 'suffix';

    private string $actionLabel = 'Buscar CEP';

    private bool $actionLabelHidden = true;

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

                $this->getCep($state, $set, $livewire, $component);

                $livewire->dispatch('cep-filled');

            })
            ->suffixAction(function () {
                if ($this->actionPosition === 'suffix') {

                    return Action::make('search-action-' . $this->getKey())
                        ->label($this->actionLabel)
                        ->icon('heroicon-o-magnifying-glass')
                        ->action(function ($state, Livewire $livewire, Set $set, Component $component) {
                            $this->getCep($state, $set, $livewire, $component);
                            $livewire->dispatch('cep-filled');
                        })
                        ->cancelParentActions();

                }

                return null;
            })
            ->prefixAction(function () {
                if ($this->actionPosition === 'prefix') {

                    return Action::make('search-action-' . $this->getKey())
                        ->label($this->actionLabel)
                        ->hiddenLabel($this->actionLabelHidden)
                        ->icon('heroicon-o-magnifying-glass')
                        ->action(function ($state, Livewire $livewire, Set $set, Component $component) {
                            $this->getCep($state, $set, $livewire, $component);
                            $livewire->dispatch('cep-filled');
                        })
                        ->cancelParentActions();

                }

                return null;
            });
    }

    public function actionLabel($label): static
    {
        $this->actionLabel = $label;

        return $this;
    }

    public function hiddenActionLabel(bool $hidden): static
    {
        $this->actionLabelHidden = $hidden;

        return $this;
    }

    public function actionPosition(string $position): static
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

    private function getCep($state, $set, $livewire, $component): void
    {
        $cepResponse = CepService::get($state);

        if (! empty($cepResponse['street'])) {
            $set($this->streetField, $cepResponse['street']);
        }

        if (! empty($cepResponse['neighborhood'])) {
            $set($this->neighborhoodField, $cepResponse['neighborhood']);
        }

        if (! empty($cepResponse['city'])) {
            $set($this->cityField, $cepResponse['city']);
        }

        if (! empty($cepResponse['state'])) {
            $set($this->stateField, $cepResponse['state']);
        }

        if (! empty($cepResponse['state_code'])) {
            $set($this->stateCodeField, $cepResponse['state_code']);
        }

        if (! empty($cepResponse['ibge_code'])) {
            $set($this->ibgeCodeField, $cepResponse['ibge_code']);
        }

        $set($this->countryField, 'Brasil');

        $set($this->countryCodeField, 'BR');

    }
}
