---
paths:
    - "app/Enums/**"
    - "app/Policies/**"
    - "app/Filament/**"
    - "app/Providers/**"
    - "app/Models/User.php"
    - "database/seeders/**"
---

# Authorization

## Authorization uses permissions not roles

Check `$user->can(PermissionsEnum::...)` and policies — not `hasRole()` — in app code. Base roles are only `super_admin`, `admin`, and `user` (`RolesEnum`). Super Admin bypasses all abilities via `Gate::before`. Site features add their own permissions; do not invent shop/portfolio permissions in the kit. Seed via `RolesAndPermissionsSeeder`; kit admin is `admin@mail.com` with `super_admin`.
