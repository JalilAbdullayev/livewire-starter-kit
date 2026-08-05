<?php

namespace App\Enums;

enum SiteModuleTypeEnum: string
{
    case Single = 'single';
    case Blog = 'blog';
    case Faq = 'faq';
    case Contact = 'contact';
    case Services = 'services';
}
