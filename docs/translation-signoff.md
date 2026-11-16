# Translation sign-off

The site supports English (`en`), Indonesian (`id`) and Simplified Chinese
(`zh`). English is the source locale and the only one that serves its own URLs
today.

## Current state

| Locale | Draft | Reviewed | Company sign-off | Served |
|---|---|---|---|---|
| `en` | — (source) | n/a | n/a | **yes** |
| `id` | complete, 595 keys | **no** | **no** | no — 302 to `/en` |
| `zh` | complete, 595 keys | **no** | **no** | no — 302 to `/en` |

`lang/id/` and `lang/zh/` each hold `site.php`, `pages.php`, `seo.php` and
`forms.php` in complete structural parity with the English source. Verify:

```bash
php tools/translation_parity.php id
php tools/translation_parity.php zh
```

Both print `parity OK` and a per-file key count. The tool compares **keys**, not
values — a translation is expected to differ in text, and may not differ in shape,
because the React components index into these arrays by key.

## Why the drafts are not served

`config/locales.php` holds a per-page allow-list of signed-off locales. A locale
absent from a page's list is not servable for that page, and the router 302s
`/{locale}/{page}` to `/en/{page}`. This fails **closed**: no entry means no
service. The drafts existing is deliberately not sufficient.

Publishing an unreviewed machine translation of a company's certifications,
quality policy and safety-relevant facility claims would put claims in the
company's name that no one at the company has read. That is the reason for the
gate, not caution for its own sake.

## What "reviewed" has to mean

A reviewer who reads the target language is not enough on its own. Sign-off
requires someone at PT. Uni-Metaltech Industry confirming:

1. The **factual** claims survive translation — the 3,000 m² figure and its
   caveat, the ISO 9001:2015 / ISO 14001:2015 / SMETA status and its
   "pending re-confirmation" note, the founding year, both addresses.
2. **Certification names** are rendered the way the company renders them in that
   language. Certificate names are proper nouns; a translator's guess is a defect.
3. The **quality and environmental policy** reads as the company's policy, not a
   paraphrase of it. Policy wording is often contractual.
4. **Product terms** match what the company's own sales material uses in that
   language (e.g. 金属冲压 vs 冲压 for stamping, perakitan kabel vs wire harness).

Record who signed what, and when. "The translation was checked" with no name is
not a record.

## How to publish a locale

1. Get sign-off per §"What reviewed has to mean".
2. Add the locale to **every** page's list in `config/locales.php`:

   ```php
   'translated' => [
       'about' => ['en', 'id'],
       // ...every key in App\Support\Pages::REGISTRY
   ],
   ```

   A locale is published only when it covers every page — the router is
   per-locale, so partial coverage would 404 or serve English under a foreign
   `<html lang>`.
3. Run the suite. `tests/Feature/TranslationCompletenessTest.php` fails if a
   published locale's files are missing or structurally divergent.
   `tests/Feature/LocalePolicyTest.php` re-checks the redirect rule from the
   other direction.
4. Verify in a browser: `/id` serves 200 with `lang="id"`, the language switcher
   offers it as available, `/sitemap.xml` gains the URLs, and the `hreflang`
   alternates point at real pages.
5. Note `zh` maps to `<html lang="zh-Hans">` while the URL segment stays `zh` —
   the route constraint requires a two-letter segment.

Signing off one locale before the other is fine; the gate is per locale.

## If a draft is wrong

Fix `lang/{locale}/` and re-run the parity tool. Do not edit the English source
to match a translation — English is authoritative, and a divergence is a defect
in the translation.
