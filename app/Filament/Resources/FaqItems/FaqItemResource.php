<?php

namespace App\Filament\Resources\FaqItems;

use App\Filament\Resources\FaqItems\Pages\CreateFaqItem;
use App\Filament\Resources\FaqItems\Pages\EditFaqItem;
use App\Filament\Resources\FaqItems\Pages\ListFaqItems;
use App\Filament\Resources\FaqItems\Pages\ViewFaqItem;
use App\Models\FaqItem;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class FaqItemResource extends Resource
{
    protected static ?string $model = FaqItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Site';

    protected static ?string $recordTitleAttribute = 'question';

    protected static ?string $navigationLabel = 'FAQ';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('answer')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->required()
                    ->default(0),
                Toggle::make('is_published'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('question')
                    ->columnSpanFull(),
                TextEntry::make('answer')
                    ->columnSpanFull(),
                TextEntry::make('sort_order'),
                IconEntry::make('is_published')
                    ->boolean(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('question')
                    ->searchable()
                    ->limit(60),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListFaqItems::route('/'),
            'create' => CreateFaqItem::route('/create'),
            'view' => ViewFaqItem::route('/{record}'),
            'edit' => EditFaqItem::route('/{record}/edit'),
        ];
    }
}
