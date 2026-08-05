---
paths:
    - "app/Enums/**"
    - "app/Policies/**"
    - "app/Filament/**"
    - "app/Providers/**"
    - "app/Models/**"
    - "database/seeders/**"
  - "routes/site.php"
  - "routes/web.php"
  - "resources/views/pages/site/**"
  - "resources/views/layouts/site.blade.php"
  - "resources/views/components/site/**"
  - "app/Livewire/Concerns/**"
  - "app/Http/Middleware/SetLocale.php"
  - "app/Enums/LocaleEnum.php"
  - "lang/**"
---

# Authorization and site modules

## Authorization uses permissions not roles

Check `$user->can(PermissionsEnum::...)` and policies — not `hasRole()` — in app code. Base roles are only `super_admin`, `admin`, and `user` (`RolesEnum`). Super Admin bypasses all abilities via `Gate::before`. Kit content permissions (`manage_modules`, `manage_pages`, `manage_blog`, `manage_faqs`, `manage_contact_messages`, `manage_service_cards`) are baseline — do not invent shop/portfolio permissions here. Seed via `RolesAndPermissionsSeeder`; kit admin is `admin@mail.com` with `super_admin`.

## Toggleable site modules

Public sections are driven by `SiteModule` + `SiteModuleEnum`. Use `SiteModule::isActive()` / `module:{key}` middleware for public access. The home page is `pages::site.home` at `/` (always public, not module-gated). Other public routes use `Route::livewire()` with `pages::site.*` full-page components under `resources/views/pages/site/` (same pattern as `pages::settings.*`). Use the `RendersSitePage` trait to apply `layouts::site` with SEO data. Site layout includes `<x-site.appearance-toggle />` (Flux `$flux.appearance`) and `<x-site.locale-switcher />`. Supported UI locales: `LocaleEnum` (`az`, `en`, `ru`) via session + `SetLocale` middleware; switch with the `site.locale-switcher` Livewire component; translations live in `lang/{locale}.json`. Services uses independent `show_page` and `show_cards` (not either/or). SEO lives on polymorphic `SeoMeta` (`HasSeoMeta`); Twitter tags are rendered from Open Graph in `<x-seo>`. After mass-updating modules outside Eloquent events, call `SiteModule::clearActiveCache()`.
