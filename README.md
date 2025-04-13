# Payment Generator Library for Slovak Banks

## Overview
This PHP library hanle generation of QR Code Payment.

## Installation

You can install the library using Composer:

```sh
composer require matok/pay-by-square-svk
```

## Requirements
You need https://en.wikipedia.org/wiki/XZ_Utils in order to generate pyament QR Code. To set this dependecy you have to pass path to this application in constructor.
```php
use Matok\PayBySquare\PaymentGenerator\Generator;
...
$generator = new Generator('/usr/bin/xz');
```

#### How to use
```php
$iban = new Iban('SK39 8360 5207 0042 0320 8125');
$price = new PriceEur('2.50');
$variableSymbol = VariableSymbol(123);
$message = new Message('my payment message');

$payment = $this->generator->generatePayment(
    $iban,
    $price,
    $variableSymbol,
    $message,
    DueDate::today()
);




// you have payment string and this can be displayed by any QR Code library:

showQrCode($payment->toString());

```

You have several possibilities how to display QR Code:

```php
// inline:
echo '<img src="' . $payment->toQrCode()->toPngInline(); .'" alt="qr code">';
```


```php
// generate in controller:
header('Content-Type: image/png');
echo $payment->toQrCode()->toPng();
```

```php
// you can generate QR Code by any library using payment string
showQrCode($payment->toString());
```

## License

This library is released under the MIT License.

