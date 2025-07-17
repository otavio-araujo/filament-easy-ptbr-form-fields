<?php

namespace OtavioAraujo\FilamentEasyPtbrFormFields;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
