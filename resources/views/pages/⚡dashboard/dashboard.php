<?php

use App\Enums\PermissionsEnum;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\FaqItem;
use App\Models\Page;
use App\Models\ServiceCard;
use App\Models\SiteModule;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component
{
    #[Computed]
    public function canAccessAdminPanel(): bool
    {
        return Auth::user()->can(PermissionsEnum::AccessAdminPanel);
    }

    #[Computed]
    public function emailIsVerified(): bool
    {
        return Auth::user()->email_verified_at !== null;
    }

    #[Computed]
    public function twoFactorEnabled(): bool
    {
        if (! Features::canManageTwoFactorAuthentication()) {
            return false;
        }

        return Auth::user()->hasEnabledTwoFactorAuthentication();
    }

    #[Computed]
    public function passkeysCount(): int
    {
        if (! Features::canManagePasskeys()) {
            return 0;
        }

        return Auth::user()->passkeys()->count();
    }

    #[Computed]
    public function accountIsSecured(): bool
    {
        if ($this->twoFactorEnabled) {
            return true;
        }

        return $this->passkeysCount > 0;
    }

    /**
     * @return list<array{label: string, done: bool, href: ?string}>
     */
    #[Computed]
    public function gettingStartedSteps(): array
    {
        $steps = [
            [
                'label' => __('Verify your email address'),
                'done' => $this->emailIsVerified,
                'href' => route('profile.edit'),
            ],
            [
                'label' => __('Enable two-factor authentication or add a passkey'),
                'done' => $this->accountIsSecured,
                'href' => route('security.edit'),
            ],
            [
                'label' => __('Visit your public site'),
                'done' => false,
                'href' => route('home'),
            ],
        ];

        if ($this->canAccessAdminPanel) {
            $steps[] = [
                'label' => __('Enable at least one site module'),
                'done' => SiteModule::query()->active()->exists(),
                'href' => route('filament.admin.resources.site-modules.index'),
            ];

            $steps[] = [
                'label' => __('Publish content for your site'),
                'done' => $this->hasPublishedContent(),
                'href' => route('filament.admin.resources.blog-posts.index'),
            ];
        }

        return $steps;
    }

    /**
     * @return array{
     *     unreadContactMessages: int,
     *     activeModules: int,
     *     inactiveModules: int,
     *     unpublishedBlogPosts: int,
     *     unpublishedFaqItems: int,
     *     unpublishedServiceCards: int,
     * }
     */
    #[Computed]
    public function adminSnapshot(): array
    {
        return [
            'unreadContactMessages' => ContactMessage::query()->whereNull('read_at')->count(),
            'activeModules' => SiteModule::query()->active()->count(),
            'inactiveModules' => SiteModule::query()->where('is_active', false)->count(),
            'unpublishedBlogPosts' => BlogPost::query()->where('is_published', false)->count(),
            'unpublishedFaqItems' => FaqItem::query()->where('is_published', false)->count(),
            'unpublishedServiceCards' => ServiceCard::query()->where('is_published', false)->count(),
        ];
    }

    /**
     * @return list<array{label: string, value: int, href: string}>
     */
    #[Computed]
    public function adminLinks(): array
    {
        return [
            [
                'label' => __('Site modules'),
                'value' => SiteModule::query()->count(),
                'href' => route('filament.admin.resources.site-modules.index'),
            ],
            [
                'label' => __('Contact messages'),
                'value' => ContactMessage::query()->count(),
                'href' => route('filament.admin.resources.contact-messages.index'),
            ],
            [
                'label' => __('Blog posts'),
                'value' => BlogPost::query()->count(),
                'href' => route('filament.admin.resources.blog-posts.index'),
            ],
            [
                'label' => __('FAQ items'),
                'value' => FaqItem::query()->count(),
                'href' => route('filament.admin.resources.faq-items.index'),
            ],
            [
                'label' => __('Service cards'),
                'value' => ServiceCard::query()->count(),
                'href' => route('filament.admin.resources.service-cards.index'),
            ],
        ];
    }

    protected function hasPublishedContent(): bool
    {
        if (BlogPost::query()->published()->exists()) {
            return true;
        }

        if (FaqItem::query()->published()->exists()) {
            return true;
        }

        if (ServiceCard::query()->published()->exists()) {
            return true;
        }

        return Page::query()
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->exists();
    }
};
