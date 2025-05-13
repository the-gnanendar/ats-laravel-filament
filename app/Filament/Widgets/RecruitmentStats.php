<?php

namespace App\Filament\Widgets;

use App\Models\Candidate;
use App\Models\Job;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecruitmentStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Jobs', Job::where('status', 'open')->count())
                ->description('Currently open positions')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),
            
            Stat::make('Total Applications', Candidate::count())
                ->description('All time applications')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('New Applications', Candidate::where('status', 'new')->count())
                ->description('Requires review')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
            
            Stat::make('Interview Stage', Candidate::where('status', 'interview')->count())
                ->description('In interview process')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),
            
            Stat::make('Offers Made', Candidate::where('status', 'offer')->count())
                ->description('Pending offers')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),
            
            Stat::make('Hired', Candidate::where('status', 'hired')->count())
                ->description('Successful placements')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Rejected', Candidate::where('status', 'rejected')->count())
                ->description('Not proceeding')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
} 