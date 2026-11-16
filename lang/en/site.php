<?php

/*
|--------------------------------------------------------------------------
| Site chrome, shared data, and structured content (English, source locale)
|--------------------------------------------------------------------------
|
| Provenance: every string below is carried from the published site
| https://www.umistamping.com/ or from the migrated Next.js content module
| (src/data/site.ts @ b5c0c50). Nothing here is invented. Claims that still
| need owner confirmation are marked with a `@claim` docblock and are tracked
| in docs/content-inventory.md.
|
| Brand tokens (UMI, ISO 9001:2015, machine makes, customer names) are NOT
| translated: lang/id and lang/zh carry them verbatim so a rename is a visible
| single-line diff in en only.
|
*/

return [

    'meta' => [
        'company' => 'PT. Uni-Metaltech Industry',
        'short' => 'UMI Stamping',
        'founded' => '2000',
        'tagline' => 'Precision metal stamping and manufacturing',
        'description' => 'Precision metal stamping and manufacturing solutions for automotive, electronics, and industrial applications.',
    ],

    'nav' => [
        'home' => 'Home',
        'about' => 'About',
        'capabilities' => 'Capabilities',
        'products' => 'Products',
        'facilities' => 'Facilities',
        'industries' => 'Industries',
        'quality' => 'Quality',
        'contact' => 'Contact',
    ],

    'cta' => [
        'contact' => 'Contact Us',
        'quote' => 'Request a Quote',
        'capabilities' => 'Explore Capabilities',
        'team' => 'Talk to Our Team',
        'project' => 'Discuss Your Project',
    ],

    /*
     * Closing call to action. Kept in one place so every page ends the same way
     * and a reword is a single-line diff.
     */
    'cta_block' => [
        'title' => 'Have a part to manufacture?',
        'lead' => 'Tell us what you are building. Our engineering and manufacturing team can help turn your requirements into a reliable production solution.',
    ],

    'contact_page' => [
        'locations_eyebrow' => 'Locations',
        'locations_title' => 'Two locations, one standard.',
        'email' => 'Email',
        'phone' => 'Phone',
        'location' => 'Location',
        'view_map' => 'View on map',
    ],

    'nav_aria' => [
        'open' => 'Open navigation',
        'close' => 'Close navigation',
        'primary' => 'Primary',
        'footer' => 'Footer',
        'breadcrumb' => 'Breadcrumb',
        'language' => 'Language',
        'pause_video' => 'Pause background video',
        'play_video' => 'Play background video',
        'skip' => 'Skip to content',
    ],

    'footer' => [
        'blurb' => 'PT. Uni-Metaltech Industry — precision metal stamping and manufacturing solutions since 2000. Batam, Indonesia.',
        'company' => 'Company',
        'resources' => 'Resources',
        'rights' => 'All rights reserved.',
        'privacy' => 'Privacy Policy',
        'terms' => 'Terms of Service',
        'links' => [
            'company_section' => [
                'about' => 'About',
                'company-profile' => 'Company Profile',
                'capabilities' => 'Capabilities',
                'products' => 'Products',
            ],
            'resources_section' => [
                'quality' => 'Quality',
                'certifications' => 'Certifications',
                'facilities' => 'Facilities',
                'contact' => 'Contact',
            ],
        ],
    ],

    'stats' => [
        ['value' => '25+', 'label' => 'Years of experience'],
        ['value' => '3,000', 'label' => 'm² factory space'],
        ['value' => '0.10', 'label' => 'mm minimum material thickness'],
        ['value' => '15–160', 'label' => 'ton press range'],
    ],

    'capabilities' => [
        [
            'title' => 'Metal Stamping',
            'category' => 'Core Manufacturing',
            'description' => 'High-precision metal stamping solutions for complex and demanding components, capable of stamping material as thin as 0.10 mm.',
            'image' => '/images/capabilities/metal-stamping.jpg',
        ],
        [
            'title' => 'Tool & Die',
            'category' => 'Precision Tooling',
            'description' => 'In-house tooling design and fabrication with CNC WireCut, NC EDM, and grinding capabilities for short lead times.',
            'image' => '/images/capabilities/tool-die.jpg',
        ],
        [
            'title' => 'Welding',
            'category' => 'Secondary Process',
            'description' => 'Spot welding and other welding processes provided in-house as value-added services for comprehensive manufacturing.',
            'image' => '/images/capabilities/welding.jpg',
        ],
        [
            'title' => 'Assembly',
            'category' => 'Value-Added Service',
            'description' => 'Mechanical assembly including tapping, reverting, and spot welding to provide comprehensive service to customers.',
            'image' => '/images/capabilities/assembly.jpg',
        ],
    ],

    'industries' => [
        [
            'title' => 'Automotive',
            'description' => 'Precision components and assemblies engineered for demanding automotive applications, where consistency, durability, and dimensional accuracy are critical.',
            'image' => '/images/industries/automotive.jpg',
        ],
        [
            'title' => 'Electronics',
            'description' => 'High-precision components manufactured for electronics applications requiring tight tolerances, repeatability, and reliable production performance.',
            'image' => '/images/industries/electronics.jpg',
        ],
        [
            'title' => 'Industrial',
            'description' => 'Robust manufacturing solutions for industrial applications, combining engineering expertise with scalable and consistent production.',
            'image' => '/images/industries/industrial.jpg',
        ],
        [
            'title' => 'Consumer',
            'description' => 'Reliable metal components and assemblies supporting consumer products where design, precision, and manufacturing efficiency come together.',
            'image' => '/images/industries/consumer.jpg',
        ],
    ],

    'process' => [
        ['title' => 'Engineering', 'description' => 'Product analysis, design review, and manufacturing feasibility.'],
        ['title' => 'Tooling', 'description' => 'Precision die and tooling development for production requirements.'],
        ['title' => 'Stamping', 'description' => 'Controlled production using high-precision stamping equipment.'],
        ['title' => 'Inspection', 'description' => 'Quality inspection and dimensional verification.'],
        ['title' => 'Assembly', 'description' => 'Integrated secondary processes and component assembly.'],
        ['title' => 'Delivery', 'description' => 'Secure packaging and reliable delivery to customers.'],
    ],

    'quality' => [
        'principles' => [
            ['title' => 'Precision', 'description' => 'Every component is manufactured with close attention to dimensional accuracy, specifications, and production requirements.'],
            ['title' => 'Consistency', 'description' => 'Structured manufacturing processes help maintain reliable and repeatable results throughout production.'],
            ['title' => 'Traceability', 'description' => 'Production and quality processes are supported by systematic documentation and monitoring.'],
            ['title' => 'Reliability', 'description' => 'Quality is integrated throughout the manufacturing workflow to support dependable long-term performance.'],
        ],
        'labelling' => 'Certification status shown on this page is carried from the company’s published material and is pending owner re-confirmation of certificate numbers, issuing bodies and validity dates.',
    ],

    'certifications' => [
        [
            'name' => 'ISO 9001:2015',
            'title' => 'Quality Management System',
            'description' => 'Certified since 2000 according to ISO 9001:2015. Internal and external audits ensure our manufacturing management system is periodically reviewed and updated to sustain operational competency and continual product quality improvement.',
            'image' => '/images/certifications/iso-9001.jpg',
        ],
        [
            'name' => 'ISO 14001:2015',
            'title' => 'Environmental Management System',
            'description' => 'Certified to ISO 14001:2015. We are committed to preventing pollution, minimizing waste, complying with regulations, and reducing energy consumption across our production processes.',
            'image' => '/images/certifications/iso-14001.jpg',
        ],
        [
            'name' => 'SMETA',
            'title' => 'Ethical Trade Audit',
            'description' => 'SMETA audited, demonstrating our commitment to ethical business practices, responsible sourcing, and continuous improvement across our operations and supply chain.',
            'image' => '/images/certifications/smeta.jpg',
        ],
    ],

    'policy' => [
        'heading' => 'Quality and Environmental Policy',
        'intro' => 'We are committed to:',
        'items' => [
            'Providing high-quality metal stamping products that meet customer requirements.',
            'Preventing environmental pollution and minimizing waste from production processes.',
            'Complying with all applicable legal, regulatory, and other environmental requirements.',
            'Reducing energy consumption and improving resource efficiency.',
            'Identifying and addressing climate change risks and opportunities that may affect our operations.',
            'Enhancing employee competence and awareness on quality and environmental protection.',
            'Continually improving the effectiveness of our quality and environmental management systems.',
        ],
    ],

    'products' => [
        [
            'key' => 'battery-contacts',
            'title' => 'Battery Contacts',
            'description' => 'Battery contacts widely used in electronic appliances, battery packs and portable electronic devices.',
            'image' => '/images/products/battery-contacts.jpg',
        ],
        [
            'key' => 'wire-harnessing',
            'title' => 'Wire Harnessing / Cable Terminals',
            'description' => 'Cable terminals used in wire-harnessing applications supporting the electrical and automotive industries.',
            'image' => '/images/products/wire-harnessing.jpg',
        ],
        [
            'key' => 'ods-dvd-drive',
            'title' => 'ODS DVD Drive',
            'description' => 'Precision stamped parts for optical disc drive assemblies, produced to tight dimensional requirements.',
            'image' => '/images/products/ods-dvd-drive.jpg',
        ],
        [
            'key' => 'mechanical-assembly',
            'title' => 'Mechanical Assembly',
            'description' => 'Value-added services including tapping, reverting and spot welding, provided in-house for a more comprehensive service.',
            'image' => '/images/products/mechanical-assembly.jpg',
        ],
        [
            'key' => 'electrical-metal-parts',
            'title' => 'Electrical & Other Metal Parts',
            'description' => 'Metal parts for computer, printer, telephone, MCB, power supply, lighting device and UPS applications.',
            'image' => '/images/products/electrical-metal-parts.jpg',
        ],
    ],

    'facilities' => [
        [
            'key' => 'production-machines',
            'title' => 'Production Machines',
            'summary' => 'Production machines range from 15 to 160 ton presses made in Japan and Taiwan with mechanical roller, air and NC feeders.',
            'specs' => [
                'C-Frame Power Press, 15–160 ton: Seyi, Aida, Amada',
                'High Speed Press, 15–60 ton: Yamada Dobby, Amada, Seyi, ISIS',
                'Auto cutting, tapping and reverting machines',
                'Manual press machines',
            ],
            'image' => '/images/facilities/production-machines.jpg',
        ],
        [
            'key' => 'supporting-machines',
            'title' => 'Supporting Machines',
            'summary' => 'A complete in-house tooling department maintains low tooling cost and short delivery through continual investment in equipment.',
            'specs' => [
                'CNC WireCut: Sodick, Mitsubishi',
                'NC EDM: SEIKI',
                'NC Superdrill: SEIKI',
                'Grinding machine: Okamoto, Equiptop',
                'CNC Milling: Hurco',
                'LX-A1 portable laser engraving',
            ],
            'image' => '/images/facilities/supporting-machines.jpg',
        ],
        [
            'key' => 'tools-design-storage',
            'title' => 'Tools Design and Storage',
            'summary' => 'Our engineering team designs and fabricates die sets locally with short lead time; high-end die sets are supported from Singapore and Malaysia.',
            'specs' => [
                'In-house die design and fabrication',
                'Prototype production before mass-production tooling where required',
                'Organised tool storage and maintenance',
                'Die set sourcing from Singapore and Malaysia for high-end tooling',
            ],
            'image' => '/images/facilities/tools-design-storage.jpg',
        ],
        [
            'key' => 'measurement-equipment',
            'title' => 'Measurement Equipment',
            'summary' => 'High-precision QA equipment keeps the commitment that only high-quality parts are delivered; calibration is carried out internally and externally.',
            'specs' => [
                'Optical measurement (VS)',
                'Profile projector: Mitutoyo',
                'High gauge: Mitutoyo',
                'Pin gauge, block gauge',
                'Vernier caliper, micrometer',
            ],
            'image' => '/images/facilities/measurement-equipment.jpg',
        ],
    ],

    'metal_part_users' => [
        'intro' => 'UMI supplies metal parts to manufacturers across the electrical, electronic and automotive industries.',
        'users' => [
            'Sanyo Energy Batam', 'Panasonic', 'Digi', 'Patlite', 'OrieX',
            'Foster Electric', 'Wellington', 'WIK', 'HW Genting', 'Valeo', 'SIIX',
            'Hitachi', 'Apple', 'BlackBerry', 'Kenwood', 'Dell', 'JVC', 'Nokia', 'Kyocera',
        ],
        'testimonials' => [
            ['name' => 'Foster Electric', 'period' => '2013–2015', 'quote' => '"Zero Reject" and "Zero Claim" for year 2013–2015.'],
            ['name' => 'Sanyo Energy Batam', 'period' => 'Since 2000', 'quote' => 'Service excellence acknowledgment for good quality and excellent support since year 2000.'],
        ],
        'customers_heading' => 'Customers we supply directly',
        'brands_heading' => 'End products our parts reach',
        'brands_intro' => 'Parts supplied to contract manufacturers also reach these end products. UMI does not supply these brands directly.',
        'withheld_note' => 'Customer names and quoted acknowledgements are withheld pending written permission from each company. The reference list is available on request at info@umistamping.com.',
        'note' => 'Customer names and quoted acknowledgements are withheld pending written permission from each company. The reference list is available on request at info@umistamping.com.',
    ],

    'contact' => [
        'batam' => [
            'label' => 'Manufacturing Factory (Batam)',
            'lines' => [
                'Kara Industrial Park Block - C 05 No. 01',
                'Batam Center 29432 - Batam',
                'Kepri - Indonesia',
            ],
            'phone' => '+62 778 464141',
            'fax' => '+62 778 464143',
            'map' => 'https://maps.google.com/maps?q=1.109035+104.046600&hl=en&z=16',
        ],
        'jakarta' => [
            'label' => 'Sales Representative (Jakarta)',
            'lines' => [
                'Ruko Central Business District (CBD)',
                'Jalan Niaga Raya Block E No. 7',
                'Jababeka 2 - Cikarang, Bekasi',
                'Jawa Barat - Indonesia',
            ],
            'map' => 'https://maps.google.com/maps?q=-6.299956+107.151841&hl=en&z=17',
        ],
        'email' => 'info@umistamping.com',
        'phone' => '+62 778 464141',
        'location' => 'Batam, Indonesia',
    ],

    'gallery' => [
        ['title' => 'Manufacturing floor', 'label' => 'Production environment', 'image' => '/images/gallery/factory-01.jpg'],
        ['title' => 'Precision machinery', 'label' => 'Production equipment', 'image' => '/images/gallery/machine-01.jpg'],
        ['title' => 'Production process', 'label' => 'Manufacturing capability', 'image' => '/images/gallery/product-01.jpg'],
        ['title' => 'Engineering detail', 'label' => 'Precision manufacturing', 'image' => '/images/gallery/team-01.jpg'],
    ],

    'news' => [
        ['date' => '2024', 'title' => 'UMI Stamping company profile', 'excerpt' => 'An overview of our manufacturing facility, capabilities and quality system in Batam, Indonesia.'],
        ['date' => '2024', 'title' => 'Tool and die capability', 'excerpt' => 'In-house die design and fabrication with CNC WireCut, NC EDM and grinding for short lead times.'],
        ['date' => '2024', 'title' => 'Quality and certification', 'excerpt' => 'Our management systems are reviewed through internal and external audits on a periodic basis.'],
    ],

    'language' => [
        'label' => 'Language',
        'en' => 'English',
        'id' => 'Bahasa Indonesia',
        'zh' => '简体中文',
        'unavailable' => 'Translation pending company sign-off — this page is served in English.',
    ],

    /*
     * Exact strings the translation-completeness test requires to differ from
     * English in a translated locale. Not used for rendering: they are the
     * sample the parity check keys on, because a locale that translates the
     * navigation but leaves every page body in English must not pass.
     */
    'i18n_probe' => [
        'nav' => 'About',
        'hero_title' => 'About UMI',
        'cta' => 'Contact Us',
        'policy' => 'We are committed to:',
    ],

];
