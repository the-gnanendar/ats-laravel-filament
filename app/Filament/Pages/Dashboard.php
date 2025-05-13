<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // You can override getColumns(), widgets(), etc. here

    public function widgets(): array
    {
        return [
            // Built-in Filament widgets will be registered here
        ];
    }
} 