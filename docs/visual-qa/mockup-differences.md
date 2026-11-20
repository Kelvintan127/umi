# Mockup differences and priorities

Based on compressed approved full-page references and actual running Laravel/Inertia GitHub Actions screenshots. Reference widths are downscaled; geometry measures are qualitative until a native-resolution source is available.

| Page | Section | Expected | Actual before this branch | Severity | Root cause | Fix | Status |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Both | Global header | Technical scale with 0–140, thin ticks and red markers | Absent | P1 | No ruler component | Reusable SVG EngineeringRuler | Implemented; visual QA pending |
| Home | Hero | Exact raised-disc battery contact | Compressed cropped asset | P0 | No approved high-res original supplied | Retain exact content crop | Source blocked |
| Home | About | Factory aerial | Compressed reference crop | P0 | High-res aerial absent in photos | Retain exact scene | Source blocked |
| Home | Process | Open six-stage connected diagram | Six white rectangular cards | P1 | Incorrect card treatment | Remove cards, keep exact approved six icons/lines | Implemented; QA pending |
| Home | Products | Four exact isolated products | Enlarged compressed crops | P0 | No matched high-res originals | Retain exact crop; request authentic files | Blocked by originals |
| Home | Facilities | AIDA row, four tabs, ruler | Cropped AIDA photo, ruler missing | P1 | Missing scale | Add reusable SVG ruler | Implemented; QA pending |
| Home | Certificates | Genuine documents and readable card previews | Compressed screenshot crops | P0 | PDFs embedded blank in CI; no committed native preview | Identify original PDFs and update false ISO 14000 claim | Partially corrected |
| Contact | Form | "Request a Quote", 01/02/03 steps | "Send us your project details", 03 Send | P1 | Existing form wording | Localized heading and stage labels | Implemented |
| Contact | Upload | 25 MB PDF/CAD upload, private handling | Informational placeholder | P0 | No private attachment pipeline | New secure upload backend | Pending backend integration |
| Contact | Geometry | Compact hero and quote section | Larger vertical whitespace | P1 | Oversized paddings | Reduce padding | Implemented; QA pending |
| Contact | Map | Interactive Batam/Jakarta map | Google Maps iframe/overlay | P2 | Provider styling differs | Preserve live map interaction | Ongoing |
| Both | Company video | Real UMI media, on-demand load | Local video URL unverified | P0 | Original is 1 GB MOV, no confirmed CDN | Media processing/storage task | Blocked |
| Both | Footer | Reference four-column composition | Similar but larger gaps | P2 | Spacing differences | Further geometry QA | Ongoing |

No claim of pixel-perfect reconstruction is made without matched original media and normalized screenshot comparisons.
\n## Additional compactness corrections\n- Contact: reduced hero padding, input padding and gaps, project textarea rows, upload drop-zone padding, and form spacing to target the approved compact RFQ proportions.\n- Shared footer: reduced spacing and switched Jakarta office block to the existing contact data rather than hard-coded shortened placeholder.\n- Homepage bottom CTA: added office phone link from verified application content.\n- Quantified visual offsets still require native-resolution reference alignment; the supplied screenshots are compressed.\n