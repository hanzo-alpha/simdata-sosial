<?php

namespace App\Filament\Reports;

use App\Enums\StatusKawinBpjsEnum;
use App\Models\BantuanBpjs;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Image;
use EightyNine\Reports\Components\Text;
use EightyNine\Reports\Components\VerticalSpace;
use EightyNine\Reports\Enums\ImageWidth;
use EightyNine\Reports\Report;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Illuminate\Support\Collection;

class BantuanBpjsReport extends Report
{
    public ?string $heading = "Laporan";

    // public ?string $subHeading = "A great report";
    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                Header\Layout\HeaderRow::make()
                    ->schema([
                        Header\Layout\HeaderColumn::make()
                            ->schema([
                                Text::make('Laporan Bantuan BPJS')
                                    ->title()
                                    ->primary(),
                            ]),
                        Header\Layout\HeaderColumn::make()
                            ->schema([
                                Image::make(asset('images/logos/logo-color.png'))->width(ImageWidth::Xl9),
                            ])
                            ->alignRight(),
                    ]),
            ]);
    }


    public function body(Body $body): Body
    {
        return $body
            ->schema([
                Body\Layout\BodyColumn::make()
                    ->schema([
                        Body\Table::make()
                            ->data(fn(?array $filters) => $this->registrationSummary($filters)),
                        VerticalSpace::make(),
                    ]),
            ]);
    }

    private function registrationSummary(?array $filters): Collection
    {
        return BantuanBpjs::where('status_nikah', StatusKawinBpjsEnum::BELUM_KAWIN)->take(5)->get();
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                Footer\Layout\FooterRow::make()
                    ->schema([
                        Footer\Layout\FooterColumn::make()
                            ->schema([
                                Text::make('Footer title')
                                    ->title()
                                    ->primary(),
                                Text::make('Footer subtitle')
                                    ->subtitle(),
                            ]),
                        Footer\Layout\FooterColumn::make()
                            ->schema([
                                Text::make('Generated on: '.now()->format('Y-m-d H:i:s')),
                            ])
                            ->alignRight(),
                    ]),
            ]);
    }

    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                //                Text::make('search')
                //                    ->placeholder('Search')
                //                    ->autofocus()
                //                    ->iconLeft('heroicon-o-search'),
                Select::make('status')
                    ->placeholder('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
            ]);
    }

    //    private function verificationSummary(?array $filters): Collection
    //    {
    //        return BantuanBpjs::find('id', 1);
    //    }
}
