<?php

namespace App\Filament\Resources\ContentPages;

use App\Filament\Forms\Components\SeoMetaForm;
use App\Filament\Resources\ContentPages\Pages\CreatePage;
use App\Filament\Resources\ContentPages\Pages\EditPage;
use App\Filament\Resources\ContentPages\Pages\ListPages;
use App\Filament\Resources\ContentPages\Pages\ViewPage;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Site';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'Page';

    protected static ?int $navigationSort = 2;

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
                RichEditor::make('content')
                    ->columnSpanFull(),
                Select::make('site_module_id')
                    ->relationship('siteModule', 'label')
                    ->required()
                    ->searchable()
                    ->preload(),
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
                TextEntry::make('siteModule.label')
                    ->label('Module'),
                TextEntry::make('content')
                    ->html()
                    ->columnSpanFull(),
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
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('siteModule.label')
                    ->label('Module')
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'view' => ViewPage::route('/{record}'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
