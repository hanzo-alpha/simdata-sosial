<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard\Concerns\HasFiltersAction;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersAction;

//    protected function getHeaderActions(): array
//    {
//        return [
//            FilterAction::make()
//                ->form([
//                    DatePicker::make('startDate')
//                        ->displayFormat('d/M/Y'),
//                    DatePicker::make('endDate')
//                        ->displayFormat('d/M/Y'),
//                ]),
//        ];
//    }
}