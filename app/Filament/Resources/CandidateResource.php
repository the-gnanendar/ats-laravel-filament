<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Filament\Resources\CandidateResource\RelationManagers;
use App\Models\Candidate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?string $navigationLabel = 'Candidates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Current Position')
                    ->schema([
                        Forms\Components\TextInput::make('current_company')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('current_position')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('experience_years')
                            ->numeric()
                            ->minValue(0),
                    ])->columns(3),

                Forms\Components\Section::make('Application Details')
                    ->schema([
                        Forms\Components\Select::make('job_id')
                            ->relationship('job', 'title')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('source')
                            ->options([
                                'linkedin' => 'LinkedIn',
                                'indeed' => 'Indeed',
                                'company_website' => 'Company Website',
                                'referral' => 'Referral',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'screening' => 'Screening',
                                'interview' => 'Interview',
                                'offer' => 'Offer',
                                'hired' => 'Hired',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\FileUpload::make('resume_path')
                            ->directory('resumes')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->required(),
                        Forms\Components\RichEditor::make('cover_letter')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Professional Profile')
                    ->schema([
                        Forms\Components\TextInput::make('linkedin_url')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('portfolio_url')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TagsInput::make('skills')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\RichEditor::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_position')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'gray',
                        'screening' => 'info',
                        'interview' => 'warning',
                        'offer' => 'success',
                        'hired' => 'success',
                        'rejected' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('applied_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'screening' => 'Screening',
                        'interview' => 'Interview',
                        'offer' => 'Offer',
                        'hired' => 'Hired',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'linkedin' => 'LinkedIn',
                        'indeed' => 'Indeed',
                        'company_website' => 'Company Website',
                        'referral' => 'Referral',
                        'other' => 'Other',
                    ]),
                Tables\Filters\SelectFilter::make('job_id')
                    ->relationship('job', 'title'),
            ])
            ->actions([
                Tables\Actions\Action::make('resume')
                    ->url(fn (Candidate $record): string => storage_path('app/' . $record->resume_path))
                    ->icon('heroicon-m-document-text'),
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
            RelationManagers\JobsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit' => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }
}
