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


## Reference-source inspection update

The supplied Drive folder contained two compressed design screenshots (534×1600
homepage, 1024×1536 contact), one palette image, and the six approved process
icons in a ZIP. No isolated original-resolution hero/product, aerial factory,
or AIDA production-line images were provided.

To preserve the mockup's photographic identity rather than substitute unrelated
images, the homepage now uses responsive SVG viewBox crops of the provided
**low-resolution screenshot**. The crops match the reference subject and
composition, but magnification cannot restore missing image detail.
These crops are temporary implementation assets and must be replaced by approved
high-resolution originals when available.

The process illustrations are the original supplied PNGs; a dependency-free
Node prebuild/predev script unpacks the six checked filenames into public/images.

The certification cards embed the already-committed source PDF files rather than
fabricating certificate imagery. Verify currency and content against issuing
authorities before release.

The inquiry form includes material/thickness/quantity selectors. These values
are appended to the existing free-text inquiry message before POST, retaining
the current controller's validated schema. CAD file upload remains unimplemented:
the existing backend has no secure, approved attachment-storage design.

The scale printed across the very top of each screenshot was identified as
reference screenshot annotation, not a website navigation element; it is not
rendered as site chrome.
