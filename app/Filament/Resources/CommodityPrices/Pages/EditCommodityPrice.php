<?php

namespace App\Filament\Resources\CommodityPrices\Pages;

use App\Filament\Resources\CommodityPrices\CommodityPriceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommodityPrice extends EditRecord
{
    protected static string $resource = CommodityPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
