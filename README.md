# Gerencianet Carnê @alexdeovidal

[![Maintainer](http://img.shields.io/badge/maintainer-@alexdeovidal-blue.svg?style=flat-square)](https://twitter.com/alexdeovidal)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/alexdeovidal/gerencianet-carne.svg?style=flat-square)](https://packagist.org/packages/alexdeovidal/gerencianet-carne)
[![Latest Version](https://img.shields.io/github/release/alexdeovidal/gerencianet-carne.svg?style=flat-square)](https://github.com/alexdeovidal/gerencianet-carne/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/alexdeovidal/gerencianet-carne.svg?style=flat-square)](https://scrutinizer-ci.com/g/alexdeovidal/gerencianet-carne)
[![Total Downloads](https://img.shields.io/packagist/dt/alexdeovidal/gerencianet-carne.svg?style=flat-square)](https://packagist.org/packages/alexdeovidal/gerencianet-carne)

## Installation

gerencianet-carne is available via Composer:

```bash
"alexdeovidal/gerencianet-carne": "dev-master"
```

or run

```bash
composer require alexdeovidal/gerencianet-carne
```

## Documentation
```bash
<?php
require __DIR__ . "/vendor/autoload.php";

$gn = new \Source\Helpers\Gerencianet();
//CRIANDO BOLETO
$product = $gn->product("Mensalidade",1,5000);
$product2 = $gn->product("Mensalidade 2",1,1000);

$gn->find(1, [$product, $product2], "2020-03-10",12);
$gn->save();

//ATUALIZANDO DATA DO BOLETO
if(!$gn->updateParcel("47680", 12,"2022-11-11"))
{
    $gn->error();;
}else{
    echo "data alterada com sucesso";
}
//CANCELA PARCELA DO CARNÊ
if(!$gn->cancelParcel("47680", 12))
{
    $gn->error();;
}else{
    echo "parcela cancelada com sucesso";
}
//CANCELA CARNE
if(!$gn->cancelCarnet("47680"))
{
    $gn->error();;
}else{
    echo "carne cancelado com sucesso";
}
```
## License

The MIT License (MIT). Please see [License File](https://github.com/alexdeovidal/gerencianet-carne/blob/master/LICENSE) for more information.
