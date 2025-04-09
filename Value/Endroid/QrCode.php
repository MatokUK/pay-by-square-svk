<?php

declare(strict_types=1);

namespace Matok\PayBySquare\Value\Endroid;

use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Matok\PayBySquare\Value\Payment;
use Matok\PayBySquare\Value\QrCode as QrCodeInterface;

final class QrCode implements QrCodeInterface
{
    private EndroidQrCode $qrCode;
    private PngWriter $writer;

    public function __construct(Payment $payment, int $size, int $margin)
    {
        $this->writer = new PngWriter();
        $this->qrCode = new EndroidQrCode($payment->toString(), size: $size, margin: $margin);
    }

    public function toPng(): string
    {
        return $this->writer->write($this->qrCode, null, null)->getString();
    }

    public function toPngInline(): string
    {
        return 'data:image/png;base64,'.base64_encode($this->writer->write($this->qrCode, null, null)->getString());
    }
}