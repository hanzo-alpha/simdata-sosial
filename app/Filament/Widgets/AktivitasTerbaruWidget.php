<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\PenyaluranBantuanRastra;
use App\Traits\HasGlobalFilters;
use App\Traits\HasWidgetShield;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class AktivitasTerbaruWidget extends BaseWidget
{
    use HasGlobalFilters;
    use HasWidgetShield;

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 20;

    protected static ?string $heading = 'Aktivitas Penyaluran Terbaru';

    public function table(Table $table): Table
    {
        $filters = $this->getFilters();

        return $table
            ->query(
                PenyaluranBantuanRastra::query()
                    ->with(['bantuan_rastra'])
                    ->whereHas('bantuan_rastra', function (Builder $query) use ($filters): void {
                        $query->when($filters['kecamatan'], fn(Builder $q) => $q->where('kecamatan', $filters['kecamatan']))
                            ->when($filters['kelurahan'], fn(Builder $q) => $q->where('kelurahan', $filters['kelurahan']));
                    })
                    ->latest('tgl_penyerahan')
                    ->limit(10),
            )
            ->columns([
                Tables\Columns\TextColumn::make('tgl_penyerahan')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nama_lengkap')
                    ->label('Nama KPM')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nik')
                    ->label('NIK')
                    ->copyable(),
                Tables\Columns\TextColumn::make('status_penyaluran')
                    ->label('Status')
                    ->badge(),
            ]);
    }
}
