<?php

namespace App\Filament\Resources\Commodities\Pages;

use App\Filament\Resources\Commodities\CommodityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCommodity extends EditRecord
{
    protected static string $resource = CommodityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->hidden(),
        ];
    }
}
