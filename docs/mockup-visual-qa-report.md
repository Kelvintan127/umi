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
| UMI identity | public/images/logo.png | Header, footer | Original repository logo |
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
| Quality | Generic certificate visuals | Existing PDF embeds | Headless PDF preview unavailable |
| Footer | Compressed | Increased CTA/footer spacing | Visual sign-off |
| Contact map | Blank iframe in isolated CI | Clickable reference map | Embedded provider only for Jakarta |
| RFQ upload | No backend support | Explicit email handoff | Secure CAD/PDF attachment pipeline |

## Verified baseline evidence

GitHub Actions run: https://github.com/Kelvintan127/umi/actions/runs/44689316966

Playwright captured the real running Laravel/Inertia app, not a static HTML preview, at 375, 390, 768, 1024, 1440 and 1920px for Home and Contact. All 12 visited page/viewports returned HTTP 200, with no horizontal overflow, uncaught page errors, or missing img elements. Facility tab switching and mobile navigation expansion passed.

The first full Laravel suite remains failing in legacy locale assertions and inquiry rate-limit/test isolation. Correct before merging. Re-run after subsequent visual commits.

The ruler at the top of the screenshots is interpreted as measurement tooling, not website navigation. The compressed source prevents a defensible pixel-error score. Do not claim 100% parity or deploy without owner QA and original media.
