<?php

namespace App\Filament\Resources\Commodities;

use App\Filament\Resources\Commodities\Pages\EditCommodity;
use App\Filament\Resources\Commodities\Pages\ListCommodities;
use App\Filament\Resources\Commodities\Schemas\CommodityForm;
use App\Filament\Resources\Commodities\Tables\CommoditiesTable;
use App\Models\Commodity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CommodityResource extends Resource
{
    protected static ?string $model = Commodity::class;

    protected static ?string $navigationLabel = 'Harga Komoditas';

    protected static ?string $modelLabel = 'Komoditas';

    protected static ?string $pluralModelLabel = 'Harga Komoditas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CommodityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommoditiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommodities::route('/'),
            'edit' => EditCommodity::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
