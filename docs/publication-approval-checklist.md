# Publication Approval Checklist

For PT. Uni-Metaltech to review and sign. Nothing in the **approval-controlled**
column is published in the release build until the corresponding box is signed
and dated by someone with authority to authorise it.

Prepared against commit `dee13b9`, branch `develop`.

## How to use this

For each item: read the **Currently published** column. If it is correct, sign.
If it is wrong, write the correction and sign. An unsigned item stays excluded
from public builds — silence fails closed, it never means yes.

Two different questions are being asked, and they are not the same question:

- **Is it accurate?** — does the site state something true about the company?
- **Are we authorised to publish it?** — do we have the right to name this third
  party, quote this person, or claim this certification today?

An item can be accurate and still unauthorised. Publication on the previous
website does not by itself establish authorisation for continued publication.

---

## 1. Indonesian translations

Draft translations of all 257 interface keys and every page body are complete.
They have **not** been read by a native speaker, and are not published.

| | |
|---|---|
| Status | Draft complete, unreviewed |
| In build? | No — `/id/*` redirects to `/en/*` |
| Risk if published unreviewed | A manufacturing client reads an awkward or wrong technical term and forms a poor impression. Worse, a mistranslated quantity changes what the company is promising. |
| What to check | Product and process terminology; the company policy wording; form labels and validation messages; date and number formatting |

Numbers verified programmatically: `3.000 m²` and `0,10 mm` in Indonesian carry
the same quantities as `3,000 m²` and `0.10 mm` in English. Programmatic checks
cannot tell whether the surrounding sentence reads naturally.

- [ ] Indonesian reviewed by a native speaker — Name: ____________ Date: ________
- [ ] Approved for publication

## 2. Simplified Chinese translations

Same position as Indonesian. Draft complete, unreviewed, unpublished.

- [ ] Simplified Chinese reviewed by a native speaker — Name: ____________ Date: ________
- [ ] Approved for publication

## 3. Factory area and published specifications

| Claim | Currently published | Source |
|---|---|---|
| Factory floor area | `3,000 m²` | Previous website |
| Press capacity | `15–160 ton` | Previous website |
| Machine makes | Seyi, Aida, Amada, Yamada Dobby, ISIS (presses); Sodick, Mitsubishi, SEIKI, Okamoto, Equiptop, Hurco, LX-A1 (tooling); Mitutoyo (measurement) | Previous website |
| Founded | `2000` | Previous website |
| Location | Batam, Indonesia | Previous website |

These are carried over as previously published. **Nobody has confirmed they are
still current.** Equipment gets sold, floor space gets reassigned, and a spec
sheet from a previous website can be years stale.

- [ ] Factory area still accurate — current value if different: ____________
- [ ] Press capacity range still accurate
- [ ] Machine list still accurate — remove any sold machines: ____________
- [ ] Founded 2000 confirmed
- [ ] Approved for publication

## 4. Three certificate assets and stated validity

The site shows three certificate images with descriptive headings. **The
certificate images are reproduced as they exist. No validity date, certificate
number or issuing body has been asserted on the site**, because those details
were not verified against the certificates themselves.

| Certificate category | Heading shown | Validity claimed |
|---|---|---|
| Quality management system | "Quality Management System" | None asserted |
| Environmental management system | "Environmental Management System" | None asserted |
| Ethical trade audit | "Ethical Trade Audit" | None asserted |

This is deliberate. An expired certificate presented as current is a
misrepresentation to every customer who relies on it, and in some markets a
compliance problem.

- [ ] Certificate images are the current, unexpired certificates
- [ ] Confirm standard and certificate number for each: ____________
- [ ] Confirm expiry date for each: ____________
- [ ] Approved to display current certificates
- [ ] Add validity dates to the site (requires the data above)

## 5. Company policy

The policy text is carried over from the previous website with its original
meaning preserved. It has not been edited for accuracy or re-approved.

- [ ] Policy text still reflects current company policy
- [ ] Approved for publication as written

## 6. Nineteen customer names

Nineteen customer names appear in the previous site's data. **None are published
in the release build.** The build shows a plain statement that named references
are withheld pending written permission.

Naming a customer implies a relationship. If that relationship has ended, or was
never authorised for marketing use, publishing the name damages the relationship
and can create a legal problem.

- [ ] Written permission held for each name published
- [ ] Approved names listed: ____________
- [ ] Understood that unpublished names stay withheld, not silently dropped

## 7. Two attributed testimonials

| Quote | Attribution | Period |
|---|---|---|
| Customer testimonial | Foster Electric | 2013–2015 |
| Customer testimonial | Sanyo Energy Batam | since 2000 |

Not published. A testimonial is a statement by a named third party; republishing
it needs that party's agreement, and a quote from 2013–2015 describes a
relationship that may no longer exist.

- [ ] Foster Electric quotation approved for publication — contact: ____________
- [ ] Sanyo Energy Batam quotation approved for publication — contact: ____________
- [ ] Quotes confirmed still representative of the relationship

---

## Verified versus approved

**Verified existing content** — carried from the previous website, internally
consistent, reproduced without change:

- Company identity, addresses, telephone numbers, email addresses
- Product categories and their descriptions
- Facility categories and machine listings
- Certificate imagery
- Company policy text
- Page structure and navigation

**Approved to republish** — specifically authorised for publication by the
company, after review:

- Nothing yet. Every item above is either carried-over-but-unconfirmed, or
  approval-controlled and withheld.

This is the honest position after an implementation pass. It is not a failure of
the build — the build is deliberately structured so that unauthorised material
cannot reach the public site even by accident.

## Where the gate lives

`config/approvals.php` holds the approval registry. `app/Support/Approvals.php`
enforces it and fails closed: an empty approval list withholds everything. Adding
a name there is the act of publication, so it should only ever change with a
signed line in this document behind it.

`tests/Feature/ContentApprovalTest.php` proves the gate withholds. Browser
verification confirmed zero customer names reach the rendered page.
