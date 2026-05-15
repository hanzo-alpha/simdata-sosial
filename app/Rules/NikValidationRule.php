<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NikValidationRule implements ValidationRule
{
    /**
     * Create a new rule instance.
     */
    public function __construct(
        protected bool $checkMaster = false,
        protected bool $checkAllPrograms = false,
        protected ?string $ignoreModel = null,
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( ! is_numeric($value)) {
            $fail('NIK/No.KK harus berupa angka.');

            return;
        }

        if (16 !== mb_strlen((string) $value)) {
            $fail('NIK/No.KK harus berjumlah 16 karakter.');

            return;
        }

        if ($this->checkMaster) {
            $exists = \App\Models\PesertaBpjs::where('nik', $value)->exists();
            if ( ! $exists) {
                $fail('NIK tidak terdaftar dalam data master kependudukan.');
                return;
            }
        }

        if ($this->checkAllPrograms) {
            $programs = [
                \App\Models\BantuanRastra::class => 'Rastra',
                \App\Models\BantuanBpjs::class => 'BPJS',
                \App\Models\BantuanBpnt::class => 'BPNT',
                \App\Models\BantuanPkh::class => 'PKH',
                \App\Models\BantuanPpks::class => 'PPKS',
            ];

            foreach ($programs as $model => $label) {
                if ($this->ignoreModel === $model) {
                    continue;
                }

                if ($model::where('nik', $value)->exists()) {
                    $fail("NIK ini sudah terdaftar sebagai penerima bantuan {$label}.");
                    return;
                }
            }
        }
    }
}
