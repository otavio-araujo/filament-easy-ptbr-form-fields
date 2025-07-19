<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields\Forms\Components;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;
use Livewire\Component as Livewire;
use OtavioAraujo\FilamentEasyPtbrFormFields\Services\CepService;

class CepField extends TextInput
{
    private string $actionPosition = 'suffix';

    private string | BackedEnum $actionIcon = 'heroicon-o-magnifying-glass';

    private string $streetField = 'street';

    private string $neighborhoodField = 'neighborhood';

    private string $cityField = 'city';

    private string $stateField = 'state';

    private string $stateCodeField = 'state_code';

    private string $ibgeCodeField = 'ibge_code';

    private string $countryField = 'country';

    private string $countryCodeField = 'country_code';

    private ?string $nextFocusTarget = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this
            ->mask('99999-999')
            ->minLength(9)
            ->afterStateUpdated(function ($state, Livewire $livewire, Set $set, Component $component) {
                $this->getCep($state, $set, $livewire, $component);
            })
            ->suffixAction(fn () => $this->getActionByPosition('suffix'))
            ->prefixAction(fn () => $this->getActionByPosition('prefix'));
    }

    public function getActionByPosition(string $actionPositionType): ?Action
    {
        if (($this->actionPosition === 'suffix' && $actionPositionType === 'suffix')
            || ($this->actionPosition === 'prefix' && $actionPositionType === 'prefix')) {

            return Action::make('search-action-' . $this->getKey())
                ->icon($this->actionIcon)
                ->action(function ($state, Livewire $livewire, Set $set, Component $component) {
                    $this->getCep($state, $set, $livewire, $component);
                })
                ->cancelParentActions();

        }

        return null;
    }

    public function nextFocusTarget(string $target): static
    {
        $this->nextFocusTarget = $target;

        return $this;
    }

    public function actionIcon(string | BackedEnum $icon): static
    {
        $this->actionIcon = $icon;

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

        $livewire->js("document.getElementById('form.{$this->nextFocusTarget}').focus()");

    }
}
