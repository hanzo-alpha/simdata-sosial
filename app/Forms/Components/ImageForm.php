<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageForm extends Field
{
    public ?string $relationship = null;

    protected string $view = 'filament-forms::components.group';

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record?->{$this->getRelationship()}();

        if ($relationship === null) {
            return;
        }

        if ($image = $relationship->first()) {
            $image->update($state);
        } else {
            if (isset($state['nama_image']) && is_array($state['nama_image'])) {
                $state['nama_image'] = array_values($state['nama_image']);
            }

            $relationship->updateOrCreate($state);
        }

        $record?->touch();
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }

    public function getChildComponents(): array
    {
        return [
            FileUpload::make('nama_image')
                ->label('Unggah Foto Rumah')
                ->getUploadedFileNameForStorageUsing(
                    fn(TemporaryUploadedFile $file
                    ): string => (string) str($file->getClientOriginalName())
                        ->prepend(date('d-m-Y-H-i-s') . '-'),
                )
                ->preserveFilenames()
                ->multiple()
                ->reorderable()
                ->appendFiles()
                ->openable()
                ->required()
                ->helperText('maks. 2MB')
                ->maxFiles(3)
                ->maxSize(2048)
                ->columnSpanFull()
                ->imagePreviewHeight('250')
                ->previewable(false)
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '16:9',
                    '4:3',
                    '1:1',
                ])
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (ImageForm $component, ?Model $record) {
            $image = $record?->getRelationValue($this->getRelationship());

            $component->state($image ? $image->toArray() : [
                'nama_image' => null,
                'path_url' => null,
            ]);
        });

        $this->dehydrated(false);
    }
}
