UMI smooth navigation and Batam-only contact update

All current public Home, About and Contact pages and SEO copy advertise the Batam factory only. The former secondary office has been removed from locale content, the Contact view, footer and Organization JSON-LD. Archived Git history remains intact.

Navigation uses Inertia 2.3 native View Transitions on GET requests, with 145 ms exit and 260 ms entry. The mobile menu, Facilities panels and Batam map switch have short transitions. Browsers without native support fall back to regular Inertia navigation; prefers-reduced-motion disables motion. RFQ POST requests remain unaffected.

Run the real-app GitHub Actions workflow. Its motion script checks SPA navigation, animation where available, reduced-motion, mobile navigation, and Batam-only mapping.
