<?php

namespace App\Filament\Resources\CandidateResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class JobsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobs';
    protected static ?string $title = 'Jobs';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('job_id')
                ->relationship('jobs', 'title')
                ->searchable()
                ->required(),
            Forms\Components\Select::make('stage')
                ->options([
                    'applied' => 'Applied',
                    'phone_screen' => 'Phone Screen',
                    'assessment' => 'Assessment',
                    'interview' => 'Interview',
                    'offer' => 'Offer',
                    'hired' => 'Hired',
                    'disqualified' => 'Disqualified',
                ])->required(),
            Forms\Components\Textarea::make('notes'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Job Title')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('pivot.stage')->badge()->label('Stage'),
            Tables\Columns\TextColumn::make('pivot.notes')->label('Notes')->limit(30),
        ]);
    }
} 