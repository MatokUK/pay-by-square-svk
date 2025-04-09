<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Tests;

use Matok\PayBySquare\PaymentGenerator\Generator as PaymentGenerator;
use Matok\PayBySquare\Value\DueDate;
use Matok\PayBySquare\Value\Iban;
use Matok\PayBySquare\Value\Message;
use Matok\PayBySquare\Value\PriceEur;
use Matok\PayBySquare\Value\VariableSymbol;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class GeneratorTest extends TestCase
{
    private PaymentGenerator $generator;
    
    protected function setUp(): void
    {
        $this->generator = new PaymentGenerator(getenv('XY_PATH'));
    }

    #[DataProvider('paymentDataProvider')]
    public function testGeneratePaymentAsString(
        string $expected,
        Iban $iban, 
        PriceEur $price, 
        VariableSymbol $variableSymbol, 
        Message $message,
        DueDate $dueDate
    ): void {
        $paymentString = $this->generator->generatePayment(
            $iban,
            $price,
            $variableSymbol,
            $message,
            $dueDate
        );

        $this->assertSame($expected, $paymentString->toString());
    }

    #[DataProvider('paymentDataProvider')]
    public function testGeneratePaymentAsQrCode(
        string $expected,
        Iban $iban, 
        PriceEur $price, 
        VariableSymbol $variableSymbol, 
        Message $message,
        DueDate $dueDate
    ): void {
        $paymentString = $this->generator->generatePayment(
            $iban,
            $price,
            $variableSymbol,
            $message,
            $dueDate
        );

        $png = $paymentString->toQrCode()->toPng();

        $this->assertStringStartsWith("\x89PNG\r\n\x1a\n", $png);
    }

    public static function paymentDataProvider()
    {
        yield [
            '0004M0001SOBVMEUP31371LT9HL3ML72SBMJKP3R8S6C9OCTF22JEUIU4UM416P250CNO0QLE9TAVOBRPFJFUN3GVS6P9DI0DGK512O76BICOG555EJP80VVN0BA000',
            new Iban('SK9355774354974758315796'),          
            new PriceEur('5.50'),
            new VariableSymbol('2025'),
            new Message('php-unit'),
            new DueDate('20250404'),
        ];

        yield [
            '0004O000C8TCKJVG9BRQ70AD2QOIDTPBAUU626OS2BNQ67L09ELU17B07UILI3P5PKH2JD2VON5221N496988TA96OKEAF94HCMHC89JLG91020B8VIHILAPT1VFMIIH00',
            new Iban('SK2343292736317665286393'),
            new PriceEur('2.99'),
            new VariableSymbol('123'),
            new Message('php-unit 2'),
            new DueDate('20261231'),
        ];
    }
}