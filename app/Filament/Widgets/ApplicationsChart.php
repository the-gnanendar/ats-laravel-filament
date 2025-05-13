<?php

namespace App\Filament\Widgets;

use App\Models\Candidate;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ApplicationsChart extends ChartWidget
{
    protected function getData(): array
    {
        $data = Candidate::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing dates with zero counts
        $dates = collect();
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $data->firstWhere('date', $date)?->count ?? 0;
            $dates->push(['date' => $date, 'count' => $count]);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Applications',
                    'data' => $dates->pluck('count')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B98120',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $dates->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
} 