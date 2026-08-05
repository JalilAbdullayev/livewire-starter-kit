<?php

namespace App\Filament\Resources\SiteModules;

use App\Enums\SiteModuleTypeEnum;
use App\Filament\Forms\Components\SeoMetaForm;
use App\Filament\Resources\SiteModules\Pages\EditSiteModule;
use App\Filament\Resources\SiteModules\Pages\ListSiteModules;
use App\Filament\Resources\SiteModules\Pages\ViewSiteModule;
use App\Models\SiteModule;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class SiteModuleResource extends Resource
{
    protected static ?string $model = SiteModule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Site';

    protected static ?string $recordTitleAttribute = 'label';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sort_order')
                    ->numeric()
                    ->required()
                    ->default(0),
                Toggle::make('is_active'),
                Toggle::make('show_page')
                    ->visible(fn (?Model $record): bool => $record instanceof SiteModule && $record->type === SiteModuleTypeEnum::Services),
                Toggle::make('show_cards')
                    ->visible(fn (?Model $record): bool => $record instanceof SiteModule && $record->type === SiteModuleTypeEnum::Services),
                ...SeoMetaForm::make(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('label'),
                TextEntry::make('key')
                    ->badge(),
                TextEntry::make('type')
                    ->badge(),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('show_page')
                    ->boolean()
                    ->visible(fn (Model $record): bool => $record instanceof SiteModule && $record->type === SiteModuleTypeEnum::Services),
                IconEntry::make('show_cards')
                    ->boolean()
                    ->visible(fn (Model $record): bool => $record instanceof SiteModule && $record->type === SiteModuleTypeEnum::Services),
                TextEntry::make('sort_order'),
                TextEntry::make('seoMeta.meta_title')
                    ->label('Meta title')
                    ->placeholder('—'),
                TextEntry::make('seoMeta.meta_description')
                    ->label('Meta description')
                    ->placeholder('—')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('label')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('key')
                    ->badge()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                ToggleColumn::make('is_active'),
                ToggleColumn::make('show_page')
                    ->disabled(fn (Model $record): bool => ! $record instanceof SiteModule || $record->type !== SiteModuleTypeEnum::Services),
                ToggleColumn::make('show_cards')
                    ->disabled(fn (Model $record): bool => ! $record instanceof SiteModule || $record->type !== SiteModuleTypeEnum::Services),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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
            'index' => ListSiteModules::route('/'),
            'view' => ViewSiteModule::route('/{record}'),
            'edit' => EditSiteModule::route('/{record}/edit'),
        ];
    }
}
