<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;

trait HasImportNotifications
{
    public ?User $user = null;

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function importRegisterEvents(): array
    {
        return [
            AfterImport::class => function (AfterImport $event): void {
                if ($this->user) {
                    Notification::make()
                        ->title($this->getImportSuccessTitle())
                        ->body($this->getImportSuccessMessage())
                        ->success()
                        ->sendToDatabase($this->user);
                }
            },
            ImportFailed::class => function (ImportFailed $event): void {
                if ($this->user) {
                    Notification::make()
                        ->title($this->getImportFailedTitle())
                        ->body($this->getImportFailedMessage())
                        ->danger()
                        ->sendToDatabase($this->user);
                }
            },
        ];
    }

    protected function getImportSuccessTitle(): string
    {
        return 'Impor Berhasil';
    }

    protected function getImportSuccessMessage(): string
    {
        return 'Data berhasil di impor ke database.';
    }

    protected function getImportFailedTitle(): string
    {
        return 'Impor Gagal';
    }

    protected function getImportFailedMessage(): string
    {
        return 'Terjadi kesalahan saat mengimpor data.';
    }
}
