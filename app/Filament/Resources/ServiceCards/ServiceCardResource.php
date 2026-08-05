<?php

namespace App\Filament\Resources\ServiceCards;

use App\Filament\Forms\Components\SeoMetaForm;
use App\Filament\Resources\ServiceCards\Pages\CreateServiceCard;
use App\Filament\Resources\ServiceCards\Pages\EditServiceCard;
use App\Filament\Resources\ServiceCards\Pages\ListServiceCards;
use App\Filament\Resources\ServiceCards\Pages\ViewServiceCard;
use App\Models\ServiceCard;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ServiceCardResource extends Resource
{
    protected static ?string $model = ServiceCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Site';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                FileUpload::make('image')
                    ->disk('public')
                    ->directory('service-cards')
                    ->visibility('public')
                    ->image()
                    ->columnSpanFull(),
                Textarea::make('excerpt')
                    ->rows(3)
                    ->columnSpanFull(),
                RichEditor::make('text')
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->required()
                    ->default(0),
                Toggle::make('is_published'),
                ...SeoMetaForm::make(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug')
                    ->badge(),
                ImageEntry::make('image')
                    ->disk('public'),
                TextEntry::make('excerpt')
                    ->columnSpanFull(),
                TextEntry::make('text')
                    ->html()
                    ->columnSpanFull(),
                TextEntry::make('sort_order'),
                IconEntry::make('is_published')
                    ->boolean(),
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
            ->recordTitleAttribute('title')
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListServiceCards::route('/'),
            'create' => CreateServiceCard::route('/create'),
            'view' => ViewServiceCard::route('/{record}'),
            'edit' => EditServiceCard::route('/{record}/edit'),
        ];
    }
}
