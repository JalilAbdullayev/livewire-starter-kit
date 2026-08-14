---
paths:
    - ".github/workflows/**"
    - "composer.json"
    - ".env.example"
    - "phpunit.xml"
---

# GitHub Actions CI

`.env.example` uses MySQL for local development. GitHub Actions does not run MySQL. `composer setup` copies `.env.example` and runs `php artisan migrate --force`, so the tests workflow must set `DB_CONNECTION=sqlite` and `DB_DATABASE=":memory:"` as job env vars (existing env wins over `.env`). Do not add a MySQL service just for that migrate — Pest already uses sqlite via `phpunit.xml`. `composer setup` also calls `bun`, so the workflow must install Bun rather than only Node.
