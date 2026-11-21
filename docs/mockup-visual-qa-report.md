# UMI Stamping mockup reconstruction — visual QA

Approved reference: https://drive.google.com/drive/folders/15ewF5ManbJ3ASyBWhXkjqx5aJ9xsgmxR

The reference folder contains a compressed 534×1600 homepage mockup, a 1024×1536 contact mockup, and six approved process icons. It does not contain isolated original-resolution product or factory photos.

## Asset mapping

| Depiction | Source crop (x,y,w,h) | Component | Status |
| --- | --- | --- | --- |
| Silver battery contact | Home 258,54,267,184 | Hero | Exact pictured part, compressed |
| Factory aerial | Home 258,321,261,103 | About | Exact pictured scene, compressed |
| Battery contact | Home 15,605,122,82 | Product 1 | Exact subject, compressed |
| Copper cable terminal | Home 143,605,124,82 | Product 2 | Exact subject, compressed |
| Mechanical assembly | Home 270,605,126,82 | Product 3 | Exact subject, compressed |
| Other metal parts | Home 401,605,120,82 | Product 4 | Exact subject, compressed |
| AIDA production-line photograph | Home 21,899,303,188 | Facilities 1 | Exact scene, compressed |
| Batam factory map | Contact 37,1041,954,233 | Map | Static preview with external Google Maps link |
| Engineering through Delivery icons | Six original PNGs in supplied ZIP | Process | Original assets extracted by prebuild/predev |
| ISO certificate card previews | Home 26,1200,226,147 and 286,1200,225,147 | Quality | Compressed approved mockup previews, not a substitute for the original PDFs |\n| UMI identity | public/images/logo.png | Header, footer | Original repository logo |
| Certification PDFs | public/images/certifications | Quality | Existing original PDFs; validity not verified |

The SVG viewBox media component displays exact crop subjects but does not restore source detail. Approved high-resolution files are required for final production media.

## Visual difference inventory

| Area | Initial running app | Correction | Outstanding |
| --- | --- | --- | --- |
| Hero | Oversized; wrong component previously | Correct reference crop, reduced desktop height | Low-res image |
| About | Wrong industrial photo | Correct aerial crop, reduced spacing | Low-res image |
| Process | Generic illustration | Original six icons, reduced spacing | Precise typography review |
| Products | Mismatched images, tall section | Four matching crops, shorter section | Original-resolution images |
| Facilities | Single press | AIDA line image, enlarged media/tabs | Original-resolution image |
| Quality | Headless PDF preview blank | Approved reference previews plus original PDF links | Compressed reference crops; current certification validity unverified |
| Footer | Compressed | Increased CTA/footer spacing | Visual sign-off |
| Contact map | Blank iframe in isolated CI | Clickable reference map | Interactive map available for Batam factory |
| RFQ upload | No backend support | Explicit email handoff | Secure CAD/PDF attachment pipeline |

## Verified baseline evidence

GitHub Actions run: https://github.com/Kelvintan127/umi/actions/runs/44689316966

Playwright captured the real running Laravel/Inertia app, not a static HTML preview, at 375, 390, 768, 1024, 1440 and 1920px for Home and Contact. All 12 visited page/viewports returned HTTP 200, with no horizontal overflow, uncaught page errors, or missing img elements. Facility tab switching and mobile navigation expansion passed.

All PHP assertions now pass after test-cache isolation, correcting localized data contracts, and updating stale unpublished-language fixtures. Final verification: 80 passed, 770 assertions; no risky tests.

The ruler at the top of the screenshots is interpreted as measurement tooling, not website navigation. The compressed source prevents a defensible pixel-error score. Do not claim 100% parity or deploy without owner QA and original media.

## 2026-11-20 certification visual correction

The actual Chromium screenshots from run 44691512298 showed blank certificate preview cards although the PDF files were linked. The card media now uses two faithful, low-resolution certificate crops from the user-provided approved screenshot. View PDF / Download PDF retain the existing repository PDF documents. These cropped previews are design references only: no new certificates were created, and certificate status still requires verification. Build and browser rerun required after this change.


## Final verification (2026-11-20)

- Commit `f0459dc2f05929cf27153b63b7647aaf16fedfba`
- [GitHub Actions: successful build, Playwright screenshots and PHP tests](https://github.com/Kelvintan127/umi/actions/runs/44693122103)
- `npm ci`, `npm run typecheck`, `npm run build`, `npm run ssr`: passed
- Laravel migrations and `php artisan test`: **80 passed, 770 assertions**
- Playwright: actual Inertia pages visited at 375, 390, 768, 1024, 1440 and 1920 pixels; all HTTP 200, no missing images or JavaScript page errors, no horizontal overflow
- Facilities tab and responsive navigation interactions: passed
- Source images remain low-resolution crops of approved compressed mockups. Real CAD upload, production-resolution original images and owner-confirmed certifications remain release blockers.

No merge into `dev` or deployment has been performed.
