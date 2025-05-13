<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Filament\Resources\JobResource\RelationManagers;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?string $navigationLabel = 'Jobs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('department')
                            ->required()
                            ->options([
                                'engineering' => 'Engineering',
                                'marketing' => 'Marketing',
                                'sales' => 'Sales',
                                'hr' => 'Human Resources',
                                'finance' => 'Finance',
                                'it' => 'Information Technology',
                                'operations' => 'Operations',
                            ]),
                        Forms\Components\Select::make('type')
                            ->options([
                                'full-time' => 'Full Time',
                                'part-time' => 'Part Time',
                                'contract' => 'Contract',
                            ])
                            ->required(),
                        Forms\Components\Select::make('experience_level')
                            ->options([
                                'entry' => 'Entry Level',
                                'mid' => 'Mid Level',
                                'senior' => 'Senior Level',
                                'executive' => 'Executive Level',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Location & Details')
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_remote')
                            ->required(),
                        Forms\Components\TextInput::make('salary_range')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('application_deadline')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Job Description')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('requirements')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('skills_required')
                            ->required(),
                        Forms\Components\TagsInput::make('benefits')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'closed' => 'Closed',
                                'draft' => 'Draft',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('experience_level')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'danger',
                        'draft' => 'warning',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('application_deadline')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('candidates_count')
                    ->counts('candidates')
                    ->label('Applications')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                        'draft' => 'Draft',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'full-time' => 'Full Time',
                        'part-time' => 'Part Time',
                        'contract' => 'Contract',
                    ]),
                Tables\Filters\SelectFilter::make('experience_level')
                    ->options([
                        'entry' => 'Entry Level',
                        'mid' => 'Mid Level',
                        'senior' => 'Senior Level',
                        'executive' => 'Executive Level',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('applications')
                    ->url(fn (Job $record): string => route('filament.admin.resources.candidates.index', ['tableFilters' => ['job_id' => $record->id]]))
                    ->icon('heroicon-m-users'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
