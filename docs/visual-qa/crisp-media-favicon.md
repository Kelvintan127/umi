# UMI clarity & favicon asset audit

## Root cause

The previously published Home product cards used crops as small as 120×82 px from a 534×1600 compressed approved screenshot. The isolated hero was also a crop of only 267×184 px, and the production-line photo was a 303×188 px crop. These pixels cannot become genuinely detailed by CSS enlarging or conventional sharpening.

## Implemented

- Hero: switched from compressed screenshot crop to an existing original 1400×933 transparent WebP precision-metal component from the project's provided frontend asset bundle (original byte-for-byte, not AI-generated). Responsive object-fit contain and intrinsic dimensions retain component proportions.
- Products: switched all four home product cards to the corresponding source-managed `product.image` paths already used on UMI interior pages. These are original uploaded UMI media, not fabricated compositions. `object-contain` avoids stretching.
- Home Facilities and interior Facilities: switched from low-res screen crop to the actual UMI machine photo stored in `facility.image`. This **changes** the presentation from the approved multi-press AIDA reference screenshot to a verified individual machine photo; the multi-press original must be supplied to faithfully restore that exact scene.
- Company factory aerial on Home: retained the compressed approved crop because no matching high-resolution source aerial exists in the original uploaded photo set. Do not represent a machine or unrelated building as UMI's own aerial image. Source art is still needed.
- Certificates stay the authentic original PDF-derived JPEG preview assets.
- Browser icon: the actual existing official `/images/logo.png` is now linked as favicon and Apple touch icon. The old `/favicon.ico` was an empty 0-byte placeholder; it is no longer referenced from the HTML.

## Outstanding

The user should supply an original aerial photograph and the approved AIDA/SEYI multi-machine production-line photo, preferably at least 1600 px wide, for fully sharp and reference-faithful presentation. Upsampling the mockup screenshot would only interpolate blur.

## Verification

CI builds, checks responsive screenshots and inspects the resulting HTML. New tests assert the official PNG favicon, hero image path and the absence of enlarged sub-200px mockup crops in critical product/facility sections.
