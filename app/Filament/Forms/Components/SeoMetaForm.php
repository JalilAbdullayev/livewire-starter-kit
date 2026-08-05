<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;

class SeoMetaForm
{
    /**
     * @return array<int, Section>
     */
    public static function make(string $relationship = 'seoMeta'): array
    {
        return [
            Section::make('SEO')
                ->description('Twitter tags are generated from Open Graph values on the public site.')
                ->relationship($relationship)
                ->schema([
                    Fieldset::make('Basic')
                        ->schema([
                            TextInput::make('meta_title')
                                ->label('Meta title')
                                ->maxLength(255),
                            Textarea::make('meta_description')
                                ->label('Meta description')
                                ->rows(3)
                                ->columnSpanFull(),
                            TextInput::make('meta_keywords')
                                ->label('Meta keywords')
                                ->maxLength(255),
                            TextInput::make('meta_author')
                                ->label('Author')
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    Fieldset::make('Indexing')
                        ->schema([
                            TextInput::make('canonical_url')
                                ->label('Canonical URL')
                                ->url()
                                ->maxLength(255),
                            TextInput::make('robots')
                                ->placeholder('index,follow')
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    Fieldset::make('Open Graph')
                        ->schema([
                            TextInput::make('og_title')
                                ->label('OG title')
                                ->maxLength(255),
                            Textarea::make('og_description')
                                ->label('OG description')
                                ->rows(3)
                                ->columnSpanFull(),
                            TextInput::make('og_image')
                                ->label('OG image path or URL')
                                ->maxLength(255),
                            TextInput::make('og_type')
                                ->label('OG type')
                                ->placeholder('website')
                                ->maxLength(255),
                            TextInput::make('og_url')
                                ->label('OG URL')
                                ->url()
                                ->maxLength(255),
                            TextInput::make('og_site_name')
                                ->label('OG site name')
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    KeyValue::make('meta_extra')
                        ->label('Extra meta tags')
                        ->keyLabel('Name')
                        ->valueLabel('Content')
                        ->reorderable()
                        ->columnSpanFull(),
                ])
                ->collapsed()
                ->columnSpanFull(),
        ];
    }
}
