<?php

namespace App\Filament\Resources\Commodities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommodityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Komoditas')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('unit')
                    ->label('Satuan')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('price')
                    ->label('Harga (Rp)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('Rp'),
                DatePicker::make('price_date')
                    ->label('Tanggal harga')
                    ->required()
                    ->native(false)
                    ->default(now()),
                TextInput::make('source')
                    ->label('Sumber data')
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label('Tampilkan di beranda')
                    ->default(true),
            ]);
    }
}
