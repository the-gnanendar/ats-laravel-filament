<?php

namespace App\Filament\Widgets;

use App\Models\Job;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JobStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open Positions', Job::where('status', 'open')->count())
                ->description('Active job postings')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),
            
            Stat::make('Applications per Job', number_format(Job::withCount('candidates')->avg('candidates_count'), 1))
                ->description('Average applications received')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('Remote Jobs', Job::where('is_remote', true)->count())
                ->description('Remote positions available')
                ->descriptionIcon('heroicon-m-computer-desktop')
                ->color('info'),
            
            Stat::make('Most Popular Department', Job::selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->orderByDesc('count')
                ->first()?->department ?? 'N/A')
                ->description('Based on number of positions')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('success'),
        ];
    }
} 