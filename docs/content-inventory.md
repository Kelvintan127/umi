# Content and asset inventory

Every published claim, where it came from, and whether the company has confirmed
it. The rule this file exists to enforce: **nothing on the site is invented.**

Legend — `SOURCE` (carried from published material, not re-confirmed) ·
`PENDING` (needs owner confirmation) · `CONFIRMED` (company confirmed; none yet).

## Company facts

| Claim | Value | Source | Approval |
|---|---|---|---|
| Legal name | PT. Uni-Metaltech Industry | umistamping.com | SOURCE |
| Short name | UMI | umistamping.com | SOURCE |
| Founded | 2000 | umistamping.com | SOURCE |
| Manufacturing site | Kara Industrial Park Block C 05 No. 01, Batam Center 29432, Kepri, Indonesia | umistamping.com | SOURCE |
| Factory floor area | approximately 3,000 m² | umistamping.com | **PENDING** — published figure, not independently verified |
| Minimum material thickness | 0.10 mm | umistamping.com | SOURCE |
| Phone / fax | +62 778 464141 / +62 778 464143 | umistamping.com | SOURCE |
| Email | info@umistamping.com | umistamping.com | SOURCE |

The 3,000 m² figure is published and reproduced as-is, with "approximately"
retained. It is not described as audited or exact.

The map link carries hardcoded coordinates. **PENDING** — confirm they resolve to
the factory gate and not the industrial park entrance.

## Certifications

The certifications page carries a visible note stating that status is drawn from
the company's published material and is **pending owner re-confirmation of
certificate numbers, issuing bodies and validity dates**. That note must stay
until someone confirms the certificates.

| Certificate | As published | Image | Approval |
|---|---|---|---|
| ISO 9001:2015 — Quality Management System | "Certified since 2000 according to ISO 9001:2015" | `certifications/iso-9001.jpg` | PENDING |
| ISO 14001:2015 — Environmental Management System | "Certified to ISO 14001:2015" | `certifications/iso-14001.jpg` | PENDING |
| SMETA — Ethical Trade Audit | "SMETA audited" | `certifications/smeta.jpg` | PENDING |

The three images are the published certificate scans and the only certificate
evidence on the site. No certificate number, issuing body, audit date or expiry
is stated, because none was confirmed. Do not add one without the certificate in
hand.

## Policy

Seven numbered commitments (quality, pollution prevention, legal compliance,
energy, climate risk, competence, continual improvement), carried from the
published policy without paraphrase. **PENDING** — policy wording is often
contractual; confirm it is current.

## Products and services

| Item | Image |
|---|---|
| Battery contacts | `products/battery-contacts.jpg` |
| Wire harnessing / cable terminals | `products/wire-harnessing.jpg` |
| ODS DVD drive parts | `products/ods-dvd-drive.jpg` |
| Mechanical assembly | `products/mechanical-assembly.jpg` |
| Electrical and other metal parts | `products/electrical-metal-parts.jpg` |

Secondary operations named: tapping, reverting, spot welding. All published.

## Facilities — machine specifications ARE published

The company publishes model makes and tonnage. Reproduced verbatim; not invented,
not independently verified.

**Production machines** — presses 15–160 ton, made in Japan and Taiwan, with
mechanical roller, air and NC feeders:

| Spec | Detail |
|---|---|
| C-Frame Power Press | 15–160 ton — Seyi, Aida, Amada |
| High Speed Press | 15–60 ton — Yamada Dobby, Amada, Seyi, ISIS |
| Auto cutting / tapping / reverting | named only, no model |
| Manual press machines | named only, no model |

**Supporting machines** (in-house tooling department):

| Spec | Detail |
|---|---|
| CNC WireCut | Sodick, Mitsubishi |
| NC EDM | SEIKI |
| NC Superdrill | SEIKI |
| Grinding machine | Okamoto, Equiptop |
| CNC Milling | Hurco |
| Laser engraving | LX-A1 portable |

**Tools design and storage** — in-house die design and fabrication, prototype
production before mass-production tooling where required, organised tool storage
and maintenance, high-end die set sourcing from Singapore and Malaysia.

**Measurement equipment** — optical measurement (VS), Mitutoyo profile
projector, Mitutoyo high gauge, pin and block gauge, vernier caliper,
micrometer; calibration internal and external.

Approval: **PENDING**. Machine makes and tonnage age badly — equipment is sold
and replaced. Confirm the list is current, particularly the 160 ton upper bound
and the named makes, and whether the company is willing to publish makes at all.

## Customers and testimonials

The metal-part-users page lists 19 company names and 2 attributed quotes, all
carried from the company's published customer list.

Names: Sanyo Energy Batam, Panasonic, Digi, Patlite, OrieX, Foster Electric,
Wellington, WIK, HW Genting, Valeo, SIIX, Hitachi, Apple, BlackBerry, Kenwood,
Dell, JVC, Nokia, Kyocera.

| Customer | Period | Quote |
|---|---|---|
| Foster Electric | 2013–2015 | "Zero Reject" and "Zero Claim" for year 2013–2015. |
| Sanyo Energy Batam | Since 2000 | Service excellence acknowledgment for good quality and excellent support since year 2000. |

**PENDING — this is the highest-risk section on the site.** Naming customers
publicly, and attributing award quotes to them, generally needs permission from
each customer, not only from UMI. The page shows a visible note that the names
and quotes are published at the owner's discretion and are not independently
verified here. That limits the claim; it does not grant permission.

Three things to resolve before this page is final:
1. Does UMI hold written permission to name each of the 19 companies?
2. Are the two quotes attributable — does UMI have the award letter or
   correspondence behind each?
3. "Apple", "Dell", "Nokia", "BlackBerry" read as end customers supplied via a
   contract manufacturer. If that is the relationship, saying so is both more
   accurate and less exposed than listing them beside direct customers.

If any answer is no, the fix is to remove the name, not to add a disclaimer.

## Imagery and video

| Asset | Origin | Status |
|---|---|---|
| `public/images/**` (26 files) | downloaded from the published site | genuine company photography |
| `public/videos/hero-factory.mp4`, `hero-factory-mobile.mp4` | migrated project | company profile video |

No stock photography. No generated imagery. No placeholder standing in for a real
image: where the published site has no image for a section, the section ships
without one.

**PENDING** — per-file provenance (which photo is which part of the factory, and
whether the photographer released it for web use) is not recorded on disk.

## Copy provenance

| File | Content |
|---|---|
| `lang/en/pages.php` | per-page copy, all pages |
| `lang/en/site.php` | shared blocks: capabilities, industries, products, facilities, certifications, quality, process, stats, policy, gallery, news, users, contact |
| `lang/en/seo.php` | meta titles and descriptions |
| `lang/en/forms.php` | contact form labels and messages |

Derived from `https://www.umistamping.com/` and the migrated project
(`src/data/site.ts`). Where a page did not exist on the old site
(`/metal-part-users`, `/policy`, `/certifications`), copy was assembled from
published material on other pages. No new claim was introduced.

## Correction log

An earlier version of this file stated that no machine specifications and no
customer names appeared anywhere on the site, and that a map embed was omitted
because coordinates would be guessed. **All three statements were wrong**: the
company publishes machine makes and tonnage, publishes 19 customer names with two
quotes, and the map link uses coordinates from the published material.

The error came from reading one section of `site.php` and generalising. The
lesson belongs here rather than in a commit message: verify a "nothing is
published" claim as carefully as a "this is published" claim, because the first
is the one that lets a later change quietly invent a fact.

## What is deliberately absent

- No certificate number, expiry date or audit body.
- No machine count, model number, tolerance or capacity beyond the published tonnage.
- No awards, export figures, headcount or revenue.
- No testimonial attributed to a named individual (both are company-to-company).
- No claim about which customers are current vs historical, beyond the two dated quotes.

Each of these would be an invented claim. If the company wants one, it has to
supply it.
