<?php

declare(strict_types=1);

namespace App\Traits;

trait HasInputDateLimit
{
    public function disableInputLimitDate(): bool
    {
        return ! $this->enableInputLimitDate();
    }

    public function enableInputLimitDate(?string $bantuan = null): bool
    {
        $date = match ($bantuan) {
            'bpjs' => setting('app.batas_tgl_input_bpjs'),
            'rastra' => setting('app.batas_tgl_input_rastra'),
            'ppks' => setting('app.batas_tgl_input_ppks'),
            'pkh' => setting('app.batas_tgl_input_pkh'),
            'bpnt' => setting('app.batas_tgl_input_bpnt'),
            'mutasi' => setting('app.batas_tgl_input_mutasi'),
            default => setting('app.batas_tgl_input'),
        };

        return cek_batas_input($date);
    }
}
