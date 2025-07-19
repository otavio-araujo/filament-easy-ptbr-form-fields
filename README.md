# Filament Easy pt_BR Form Fields

[![Latest Version on Packagist](https://img.shields.io/packagist/v/otavio-araujo/filament-easy-ptbr-form-fields.svg?style=flat-square)](https://packagist.org/packages/otavio-araujo/filament-easy-ptbr-form-fields)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/otavio-araujo/filament-easy-ptbr-form-fields/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/otavio-araujo/filament-easy-ptbr-form-fields/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/otavio-araujo/filament-easy-ptbr-form-fields/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/otavio-araujo/filament-easy-ptbr-form-fields/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/otavio-araujo/filament-easy-ptbr-form-fields.svg?style=flat-square)](https://packagist.org/packages/otavio-araujo/filament-easy-ptbr-form-fields)



This package provides a custom CEP form field commonly used in Brazilian's web applications integrated with
ViaCep, BrasilAPI and AwesomeAPI web services.

## Filament Compatibility

Compatible with Filament v4 and above.

## Installation

You can install the package via composer:

```bash
composer require otavio-araujo/filament-easy-ptbr-form-fields
```

## Usage

### Basic Usage
The custom field searches for CEP and fills up the form fields with the data returned by the web service.

**By default, the fields that will be filled up are:**
- street;
- neighborhood;
- city;
- state;
- state_code;
- ibge_code;
- and country.
```php
...
 
CepField::make('postal_code'),

TextInput::make('street'),
TextInput::make('neighborhood'),
TextInput::make('city'),
TextInput::make('state'),
TextInput::make('state_code'),
TextInput::make('ibge_code'),
TextInput::make('country'),
TextInput::make('country_code'),
TextInput::make('number'),

...
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Otávio Araújo](https://github.com/otavio-araujo)
- [All Contributors](.github/CONTRIBUTING.md)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
