<?php

namespace App\Filament\Resources\CommodityPrices\Pages;

use App\Filament\Resources\CommodityPrices\CommodityPriceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommodityPrices extends ListRecords
{
    protected static string $resource = CommodityPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
