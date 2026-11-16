# Content and asset inventory

Every published claim, where it came from, and whether the company has confirmed
it. The rule this file exists to enforce: **nothing on the site is invented.**

Legend for approval — `SOURCE` (carried from published material, not
re-confirmed) · `PENDING` (needs owner confirmation) · `CONFIRMED` (company
confirmed; none yet).

## Company facts

| Claim | Value | Source | Approval |
|---|---|---|---|
| Legal name | PT. Uni-Metaltech Industry | umistamping.com | SOURCE |
| Short name | UMI | umistamping.com | SOURCE |
| Founded | 2000 | umistamping.com | SOURCE |
| Manufacturing site | Kara Industrial Park Block C 05 No. 01, Batam Center 29432, Kepri, Indonesia | umistamping.com | SOURCE |
| Sales office | Ruko CBD, Jl. Niaga Raya Block E No. 7, Jababeka 2, Cikarang, Bekasi, Jawa Barat | umistamping.com | SOURCE |
| Jakarta office opened | 2014 | umistamping.com | SOURCE |
| Factory floor area | approximately 3,000 m² | umistamping.com | **PENDING** — figure carried as published, not independently verified |
| Minimum material thickness | 0.10 mm | umistamping.com | SOURCE |
| Phone / fax | +62 778 464141 / +62 778 464143 | umistamping.com | SOURCE |
| Email | info@umistamping.com | umistamping.com | SOURCE |

The 3,000 m² figure is published on the live site and is reproduced as-is. It is
not described as certified, audited or exact, and the about page wording keeps
"approximately".

## Certifications

The certifications page carries a visible note stating that status is drawn from
the company's published material and is **pending owner re-confirmation of
certificate numbers, issuing bodies and validity dates**. That note must not be
removed until someone confirms the certificates.

| Certificate | As published | Image | Approval |
|---|---|---|---|
| ISO 9001:2015 — Quality Management System | "Certified since 2000 according to ISO 9001:2015" | `certifications/iso-9001.jpg` | PENDING |
| ISO 14001:2015 — Environmental Management System | "Certified to ISO 14001:2015" | `certifications/iso-14001.jpg` | PENDING |
| SMETA — Ethical Trade Audit | "SMETA audited" | `certifications/smeta.jpg` | PENDING |

The three certificate images are the **only** certificate evidence on the site
and are the published scans. No certificate number, issuing body, audit date or
expiry is stated anywhere, because none was confirmed. Do not add one without
the certificate in hand.

## Policy

The quality and environmental policy text is carried from the published site.
It is presented as the company's published commitments without paraphrase.
**PENDING** — policy wording is often contractual; the company should confirm
the published text is current.

## Products and services

| Item | Source page | Image |
|---|---|---|
| Battery contacts | umistamping.com | `products/battery-contacts.jpg` |
| Wire harnessing / cable terminals | umistamping.com | `products/wire-harnessing.jpg` |
| ODS DVD drive parts | umistamping.com | `products/ods-dvd-drive.jpg` |
| Mechanical assembly | umistamping.com | `products/mechanical-assembly.jpg` |
| Electrical and other metal parts | umistamping.com | `products/electrical-metal-parts.jpg` |

Secondary operations named in the copy — tapping, reverting, spot welding — are
those the published site lists. No machine model, tonnage, tolerance or capacity
figure appears anywhere: none was published, so none was written.

## Facilities

| Section | Content | Image |
|---|---|---|
| Production machines | categories only (stamping presses, etc.) | `facilities/production-machines.jpg` |
| Supporting machines | categories only | `facilities/supporting-machines.jpg` |
| Tools design and storage | prose from published copy | `facilities/tools-design-storage.jpg` |
| Measurement equipment | categories only | `facilities/measurement-equipment.jpg` |

**No machine specifications are stated** — no make, model, count or tonnage. The
published site does not give them. If the company supplies a machine list, that
is a content addition, not a bug fix.

## Industry and customers

Industry sectors (electrical, electronic, automotive) are from the published
copy. The "Our Metal Part Users" page names **sectors**, not customers: no
customer name or logo appears.

**PENDING** — if the company wants named customers or logos, that requires
written permission from each customer. Do not add them from a hunch.

## Imagery and video

| Asset | Origin | Status |
|---|---|---|
| `public/images/**` (26 files) | downloaded from the published site | genuine company photography |
| `public/videos/hero-factory.mp4`, `hero-factory-mobile.mp4` | carried from the migrated project | company profile video |

No stock photography was used. No image was generated. No placeholder graphic
was left in place of a real one. Where the published site has no image for a
section, that section ships without an image rather than with a stand-in.

**PENDING** — image provenance per file (which photo is which part of the
factory, and whether the company's photographer released it) is not recorded on
disk. Worth confirming before the images are reused in marketing.

## Copy provenance

| File | Content |
|---|---|
| `lang/en/pages.php` | per-page copy, all pages |
| `lang/en/site.php` | shared blocks: capabilities, industries, products, facilities, certifications, quality, process, stats, policy, gallery, news, users, contact |
| `lang/en/seo.php` | meta titles and descriptions |
| `lang/en/forms.php` | contact form labels and messages |

All of it derives from `https://www.umistamping.com/` and the migrated Next.js
project. Where a page did not exist on the old site (e.g. `/metal-part-users`),
the copy was assembled from published material on other pages — it did not
introduce new claims.

## What is deliberately absent

- No certification number, expiry date or audit body.
- No machine count, model, tonnage or tolerance.
- No customer names or logos.
- No awards, export figures, headcount or revenue.
- No testimonial attributed to a named person.
- No map embed keyed to a guessed coordinate.

Each of these would be an invented claim. If the company wants one, it has to
supply it.
