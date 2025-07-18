<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;
use Livewire\Component as Livewire;

class CepField extends TextInput
{
    private string $actionPosition = 'suffix';

    private string $actionLabel = 'Buscar CEP';

    private bool $actionLabelHidden = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this
            ->mask('99999-999')
            ->minLength(9)
            ->suffixAction(function () {
                if ($this->actionPosition === 'suffix') {
                    return Action::make('search-action-' . $this->getKey())
                        ->label($this->actionLabel)
                        ->hiddenLabel($this->actionLabelHidden)
                        ->icon('heroicon-o-magnifying-glass')
                        ->action(function ($state, Livewire $livewire, Set $set, Component $component) {
                            $this->getCep($state);
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

    private function getCep($state, $set): void
    {
        $set('street', 'Rua');
    }
}
