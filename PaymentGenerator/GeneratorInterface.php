<?php

namespace Matok\PayBySquare\PaymentGenerator;

use Matok\PayBySquare\Value\DueDate;
use Matok\PayBySquare\Value\Iban;
use Matok\PayBySquare\Value\Message;
use Matok\PayBySquare\Value\Payment;
use Matok\PayBySquare\Value\Price;
use Matok\PayBySquare\Value\VariableSymbol;

interface GeneratorInterface
{
    public function generatePayment(
        Iban $iban, 
        Price $price, 
        VariableSymbol $varibleSymbol, 
        Message $message,
        DueDate $dueDate,
    ): Payment;
}