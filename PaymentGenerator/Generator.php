<?php

declare(strict_types=1);

namespace Matok\PayBySquare\PaymentGenerator;

use Matok\PayBySquare\Value\ConstantSymbol;
use Matok\PayBySquare\Value\DueDate;
use Matok\PayBySquare\Value\Iban;
use Matok\PayBySquare\Value\Message;
use Matok\PayBySquare\Value\Payment;
use Matok\PayBySquare\Value\Price;
use Matok\PayBySquare\Value\SpecificSymbol;
use Matok\PayBySquare\Value\VariableSymbol;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class Generator implements GeneratorInterface
{
    private const ONE_TIME_PAYMENT = 1;
    private const PAYMENTS_COUNT = 1;
    private const BANK_ACCOUNTS_COUNT = 1;

    public function __construct(private readonly string $xzPath)
    {        
    }

    public function generatePayment(
        Iban $iban, 
        Price $price, 
        VariableSymbol $variableSymbol, 
        Message $message,
        DueDate $dueDate
    ): Payment {
        $d = implode("\t", [
            '',
            self::PAYMENTS_COUNT,
            self::ONE_TIME_PAYMENT,
            $price->amount,
            $price->currency,
            $dueDate->toString(),
            $variableSymbol->toString(),
            ConstantSymbol::empty()->toString(),
            SpecificSymbol::empty()->toString(),
            '',
            $message->toString(), 
            self::BANK_ACCOUNTS_COUNT,
            $iban->toString(),
            '',
            '0',
            '0'
        ]);

        $d = strrev(hash("crc32b", $d, TRUE)) . $d;

        $lzma = $this->lzma($d);    

        $d = bin2hex("\x00\x00" . pack("v", strlen($d)) . $lzma);
        $binary = $this->hex2binary($d);
        
        $binary = $this->zeroPadTo5($binary);
        
        $groups = strlen($binary) / 5;
        $qrString = str_repeat("_", $groups);
        for ($i = 0; $i < $groups; $i += 1) {
            $qrString[$i] = "0123456789ABCDEFGHIJKLMNOPQRSTUV"[bindec(substr($binary, $i * 5, 5))];
        }

        return new Payment($qrString);
    }

    private function lzma(string $input): string
    {
        $process = new Process([
             $this->xzPath,
            '--format=raw', 
            '--lzma1=lc=3,lp=0,pb=2,dict=128KiB', 
            '-c'
        ]);
        $process->setInput($input);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function hex2binary(string $input): string
    {
        $binary = '';

        for ($i = 0; $i < strlen($input); $i++) {
            $binary .= str_pad(base_convert($input[$i], 16, 2), 4, "0", STR_PAD_LEFT);
        }

        return $binary;
    }

    private function zeroPadTo5(string $data): string
    {
        $rest = strlen($data) % 5;

        if ($rest === 0) {
            return $data;
        }

        $p = 5 - $rest;
        $data .= str_repeat("0", $p);

        return $data;
    }
}