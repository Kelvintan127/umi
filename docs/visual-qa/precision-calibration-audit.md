# Precision reference audit

The approved homepage reference is 534 × 1600 pixels, and the approved
contact reference is 1024 × 1536. Both are compressed full-page images, not
native screenshots at the same CSS viewport width. Side-by-side before/after
images must be aligned to section landmarks before treating pixel differences
as actual design errors.

## P0 correction

- Home ruler: reference major numeric labels 0, 10, 20 ... 140.
- Contact ruler: reference major numeric labels 0, 50, 100 ... 1400.
- Reusable native-pixel SVG now supports route-specific variants, thicker
  major/medium/minor ticks, distinct numeric cadence and positioned red triangles.
- Facilities ruler: 32px scale, red active-segment accent, sits flush under tabs.

## Typography tokens

The existing website uses Inter with a system-font fallback, maintained here.
No new font dependency. New scoped CSS tokens:
- section heading: clamp(2.15rem, 3.45vw, 3.6rem), 900 weight, 1.055 line-height
- body text: clamp(.95rem, 1.15vw, 1.07rem)
- technical metadata: .78rem at 800 weight
- Facilities tab numbers: 1.55rem; titles: clamp(.95rem, 1.32vw, 1.22rem)
- Facilities main title: clamp(1.65rem, 2.25vw, 2.4rem)

These are starting calibrations against the supplied 1440-wide comparison,
not a verified pixel-perfect score.

## Facilities content

The new panel retains the approved AIDA/SEYI image crop and existing
source-managed production machine specifications. Its column ratio is
1.62:1 (61.8% photo before the 24px column gap). The headline presents the
number and title in one row; technical items use short red dash markers.
The four tab subtitles are localized for English, Indonesian and Chinese.

## Browser evidence

The updated GitHub Actions job saves actual running-app screenshots, the
global ruler screenshot, the Facilities full section and its ruler, plus
measurements at 1440, 1920, 1024, 768 and 390px. These values show dimensions
at the application viewport; they do not claim the compressed reference has
corresponding native geometry.
