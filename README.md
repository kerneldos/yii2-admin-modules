# yii2-admin-modules

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via [composer](http://getcomposer.org/download/)

``` bash
$ composer require --prefer-dist kerneldos/yii2-admin-modules
```

or add
```
"kerneldos/yii2-admin-modules": "~1.0"
```
to the require section of your `composer.json` file.

####Apply migrations to create required tables
``` bash
yii migrate --migrationPath=@kerneldos/extmodule/migrations --interactive=0
```

## Usage
Add the module to your main config file for manual config, ex: 

``` php
'modules' => [
    'admin' => [
        'class' => 'kerneldos\extmodule\Module',

        'layoutPath' => '@app/views/layouts',
        'layout' => 'main',

        'as Access' => [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ],
    ],
],
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email kerneldos@mail.ru instead of using the issue tracker.

## Credits

- [kerneldos][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/kerneldos/yii2-admin-modules.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/kerneldos/yii2-admin-modules/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/kerneldos/yii2-admin-modules.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/kerneldos/yii2-admin-modules.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/kerneldos/yii2-admin-modules.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/kerneldos/yii2-admin-modules
[link-travis]: https://travis-ci.org/kerneldos/yii2-admin-modules
[link-scrutinizer]: https://scrutinizer-ci.com/g/kerneldos/yii2-admin-modules/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/kerneldos/yii2-admin-modules
[link-downloads]: https://packagist.org/packages/kerneldos/yii2-admin-modules
[link-author]: https://github.com/kerneldos
[link-contributors]: ../../contributors
