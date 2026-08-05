<?php

namespace App\Enums;

enum SiteModuleEnum: string
{
    case About = 'about';
    case Contact = 'contact';
    case Blog = 'blog';
    case Privacy = 'privacy';
    case Terms = 'terms';
    case Faq = 'faq';
    case Services = 'services';

    public function label(): string
    {
        return match ($this) {
            self::About => 'About',
            self::Contact => 'Contact',
            self::Blog => 'Blog',
            self::Privacy => 'Privacy',
            self::Terms => 'Terms',
            self::Faq => 'FAQ',
            self::Services => 'Services',
        };
    }

    public function type(): SiteModuleTypeEnum
    {
        return match ($this) {
            self::About, self::Privacy, self::Terms => SiteModuleTypeEnum::Single,
            self::Contact => SiteModuleTypeEnum::Contact,
            self::Blog => SiteModuleTypeEnum::Blog,
            self::Faq => SiteModuleTypeEnum::Faq,
            self::Services => SiteModuleTypeEnum::Services,
        };
    }

    public function routeName(): string
    {
        return match ($this) {
            self::About => 'site.about',
            self::Contact => 'site.contact',
            self::Blog => 'site.blog.index',
            self::Privacy => 'site.privacy',
            self::Terms => 'site.terms',
            self::Faq => 'site.faq',
            self::Services => 'site.services.index',
        };
    }

    public function hasPage(): bool
    {
        return in_array($this->type(), [
            SiteModuleTypeEnum::Single,
            SiteModuleTypeEnum::Contact,
            SiteModuleTypeEnum::Services,
        ], true);
    }
}
