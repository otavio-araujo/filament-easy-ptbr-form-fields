<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use OtavioAraujo\FilamentEasyPtbrFormFields\Commands\FilamentEasyPtbrFormFieldsCommand;
use OtavioAraujo\FilamentEasyPtbrFormFields\Testing\TestsFilamentEasyPtbrFormFields;

class FilamentEasyPtbrFormFieldsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-easy-ptbr-form-fields';

    public static string $viewNamespace = 'filament-easy-ptbr-form-fields';

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-easy-ptbr-form-fields');
    }

}
