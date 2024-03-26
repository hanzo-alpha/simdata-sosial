<?php

declare(strict_types=1);

namespace App\Traits;

trait HasInputDateLimit
{
    public function disableInputLimitDate(): bool
    {
        return ! $this->enableInputLimitDate();
    }

    public function enableInputLimitDate(): bool
    {
        $date = setting('app.batas_tgl_input');

        return cek_batas_input($date);
    }
}
