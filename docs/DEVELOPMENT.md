# Environment and troubleshooting

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm ci

# Three processes:
php artisan serve --port=8931              # app
php artisan inertia:start-ssr              # SSR renderer (required for real <head>)
npm run dev                                # vite HMR
```

Without the SSR renderer the app still runs — Inertia falls back to
client-side rendering — but the served HTML carries no title, description,
canonical or hreflang. **Restart the renderer after `npm run ssr`**: it loads the
bundle once at startup, so it keeps rendering stale markup against a rebuilt
bundle. This looks like "my change did nothing".

## Test and build

```bash
php artisan test                 # 32 tests
npx tsc --noEmit                 # TypeScript, no emit
npm run build                    # client bundle -> public/build
npm run ssr                      # SSR bundle -> bootstrap/ssr
php tools/translation_parity.php id    # key parity, exit 1 on drift
```

## Layout

```
app/Support/Pages.php       page registry: key -> path, component, action, nav, SEO priority
app/Support/PageProps.php   the single builder for every shared Inertia prop
app/Support/Locales.php     locale policy: which locales serve their own URLs
app/Support/FormLabels.php  flattens forms.php into the shape the form takes
lang/{en,id,zh}/            copy. English is the source; id/zh are unreviewed drafts
resources/js/components/    presentational; page structure comes from the lang files
resources/js/pages/         ContentPage serves 24 of 25 pages; the 25th is Contact
config/locales.php          the sign-off allow-list (see docs/translation-signoff.md)
```

Adding a page: add an entry to `Pages::REGISTRY` and a matching `lang/en/pages.php`
key. Adding a *section* to a page: add a `type` entry to that page's `sections`
array — no component change, unless the type is new, in which case add it to the
switch in `SectionRenderer.tsx` and to the known list in
`tests/Feature/TranslationCompletenessTest.php`.

## Things that will bite you

**Dotted page keys.** `products.battery-contacts` is a single flat key in the
pages lang file, not nesting. `trans('pages.products.battery-contacts.hero')`
splits on the dot, finds nothing and returns the key string. Use `Pages::copy()`
or `Pages::copyValue()`, which index the file literally.

**`trans()` returns the key, not null, on a miss.** A missing translation
surfaces as literal `pages.about.hero.title` in the page, and passes any
`assertNotEmpty`. When adding copy, check the rendered page, not just that the
array key exists.

**Restart the SSR renderer after rebuilding the SSR bundle.**

**`config:cache` bakes `.env` in.** Later `.env` edits appear to do nothing until
`php artisan config:clear`.

**`RouteRegistrar::whereIn()` does not `preg_quote()`.** That is why
`Locales::CODES` is a class constant of lowercase two-letter codes and why `zh`
stays two letters in the URL while `<html lang>` expands to `zh-Hans`.
`tests/Feature/LocalePolicyTest.php` enforces it.

**The contact form has a minimum-submit-time anti-spam check.** Submitting
within ~1.2 s of the form appearing is treated as a bot: it returns the normal
success shape and stores nothing. If you are testing the form by script, wait,
or you will conclude the form is broken when it is working as designed.

**Mail is unconfigured by default.** `MAIL_INQUIRY_TO` empty means inquiries are
stored and nothing is emailed, with `contact.mail_not_configured` in the log.
The response reports `queued=false`. A test that asserts a send needs
`config(['mail.inquiry_to' => ...])` set.

**`Mailable::$locale` already exists.** Do not declare a `readonly $locale`
promoted property on a mailable; it is a fatal error. Pass it through
`$this->locale()`.

## Storage

`/mnt/truenas-umi` (NFS) is for backups and media assets. Do **not** put a live
SQLite database on NFS: SQLite locking over NFS is unreliable and corrupts the
file. Keep the database on local disk.
