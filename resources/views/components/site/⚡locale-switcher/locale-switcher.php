<?php

use App\Enums\LocaleEnum;
use Livewire\Component;

new class extends Component
{
    public function switchLocale(string $locale): void
    {
        abort_unless(LocaleEnum::isSupported($locale), 404);

        session()->put('locale', $locale);

        $this->redirect(request()->header('Referer', route('home')), navigate: false);
    }

    public function currentLocale(): LocaleEnum
    {
        return LocaleEnum::from(app()->getLocale());
    }
};
