# UMI mockup integration (2026-11-20)

Reference: Google Drive folder ID 15ewF5ManbJ3ASyBWhXkjqx5aJ9xsgmxR.
Base: dev at 6d530f309af55ca11ab78b0d93496c1460ff18f6.

## Scope of this branch
- Redesigns the homepage and contact page with the supplied visual direction:
  white header, technical blueprint dark hero, statistics, six-stage process,
  product tiles, tabbed facilities, certification cards, RFQ layout, and factory map.
- Retains the existing production Laravel routes, Inertia SEO props, localization
  policy, contact form validation/anti-spam, official product photography,
  existing PDFs and other pages without changing their backend.
- CSS is scoped under .umi-mockup; the main app CSS imports that stylesheet.

## Important remaining items
- The mockup's six icon PNGs, isolated hero metal asset and other original
  source-design images have not been migrated. Existing repository assets and
  Lucide diagrams are used as safe interim equivalents.
- The reference RFQ features CAD/PDF upload. This branch deliberately does not
  accept file uploads because the existing Inquiry controller and mail pipeline
  lack secure attachment handling. The page instead provides the office email.
- Only Home and Contact have been redesigned on this branch. Remaining
  company pages keep their current layout pending visual QA.
- Certification PDF links point to existing repository documents. Confirm their
  validity before displaying as current accreditations.
- Copy, translations and factory/contact details should be owner-reviewed.

## Release gate
Run in an environment with dependencies:
- npm ci && npm run typecheck && npm run build && npm run ssr
- composer install && php artisan test && php artisan route:list
- Browser screenshot parity at 375, 430, 768, 1024, 1440, 1920 px
- Contact submit/validation and language-switch smoke test

Do not deploy or merge without these checks.
