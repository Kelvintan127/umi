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
        'policy' => 'Company Policy',
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
        'profile_play' => 'Play company profile video',
        'profile_loading' => 'Loading video...',
        'profile_error' => 'The video could not be loaded.',
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
            'image' => '/images/facilities/sni-110-mechanical-stamping-press.png',
        ],
        [
            'title' => 'Tool & Die',
            'category' => 'Precision Tooling',
            'description' => 'In-house tooling design and fabrication with CNC WireCut, NC EDM, and grinding capabilities for short lead times.',
            'image' => '/images/facilities/donrun-four-column-hydraulic-press.png',
        ],
        [
            'title' => 'Welding',
            'category' => 'Secondary Process',
            'description' => 'Spot welding and other welding processes provided in-house as value-added services for comprehensive manufacturing.',
            'image' => '/images/facilities/robotic-welding-arm.png',
        ],
        [
            'title' => 'Assembly',
            'category' => 'Value-Added Service',
            'description' => 'Mechanical assembly including tapping, reverting, and spot welding to provide comprehensive service to customers.',
            'image' => '/images/facilities/eko-esii2508-sheet-metal-bending-machine.png',
        ],
    ],

    'industries' => [
        [
            'title' => 'Automotive',
            'description' => 'Precision components and assemblies engineered for demanding automotive applications, where consistency, durability, and dimensional accuracy are critical.',
            'image' => '/images/products/formed-sheet-metal-mounting-bracket.png',
        ],
        [
            'title' => 'Electronics',
            'description' => 'High-precision components manufactured for electronics applications requiring tight tolerances, repeatability, and reliable production performance.',
            'image' => '/images/products/assorted-precision-metal-stamping-parts.png',
        ],
        [
            'title' => 'Industrial',
            'description' => 'Robust manufacturing solutions for industrial applications, combining engineering expertise with scalable and consistent production.',
            'image' => '/images/facilities/sni-110-mechanical-stamping-press.png',
        ],
        [
            'title' => 'Consumer',
            'description' => 'Reliable metal components and assemblies supporting consumer products where design, precision, and manufacturing efficiency come together.',
            'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
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
            'description' => 'Certificate QMS/15/R62/0013 is issued by Certification Partner Global for Metal Stamping. Recertified 05 Mar 2024; expiry stated as 05 Mar 2027, conditional on annual audits and issuer status.',
            'document' => '/images/certifications/CPG 9001 QMS Recertification.pdf',
        ],
        [
            'name' => 'ISO 14001:2015',
            'title' => 'Environmental Management System',
            'description' => 'Certificate EMS/2/R62/0013 is issued by Certification Partner Global for Metal Stamping. Recertified 05 Mar 2024; expiry stated as 05 Mar 2027, conditional on annual audits and issuer status.',
            'document' => '/images/certifications/CPG 14001 EMS Recertification.pdf',
        ],
    ],

    'policy' => [
        'heading' => 'Quality and Environmental Policy',
        'intro' => 'We are committed to:',
        'items' => [
            'Providing High-Quality Metal Stamping Products That Meet Customer Requirements.',
            'Preventing Environmental Pollution And Minimizing Waste From Production Processes.',
            'Complying With All Applicable Legal, Regulatory, And Other Environmental Requirements.',
            'Reducing Energy Consumption And Improving Resource Efficiency.',
            'Identifying And Addressing Climate Change Risks And Opportunities That May Affect Our Operations.',
            'Enhancing Employee Competence And Awareness On Quality And Environmental Protection.',
            'Continually Improving The Effectiveness Of Our Quality And Environmental Management Systems.',
        ],
    ],

    'products' => [
        [
            'key' => 'battery-contacts',
            'title' => 'Battery Contact',
            'description' => 'Battery Contacts which are widely used in electronic appliances, battery packs and portable electronic devices.',
            'image' => '/images/products/assorted-precision-metal-stamping-parts.png',
        ],
        [
            'key' => 'wire-harnessing',
            'title' => 'Cable Terminals',
            'description' => 'Cable Terminals which are used in wire-harnessing application supporting electrical and automotive industries.',
            'image' => '/images/products/precision-metal-bar-assembly.png',
        ],
        [
            'key' => 'mechanical-assembly',
            'title' => 'Mechanical Assembly',
            'description' => 'Mechanical assembly. This additional value added services such as tapping, reverting, spot welding are provided inhouse to give a more comprehensive service to our value customers.',
            'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
        ],
        [
            'key' => 'electrical-metal-parts',
            'title' => 'Other Metal Parts',
            'description' => 'Other metal parts applications such as in computer, printer, telephone, MCB, power supply, lighting device, UPS, etc.',
            'image' => '/images/products/formed-steel-mounting-plate.png',
        ],
    ],

    'facilities' => [
        [
            'key' => 'production-machines',
            'title' => 'Production Machines',
            'summary' => 'Production machines are range from 15 to 160 ton presses made in Japan and Taiwan with mechanical roller, Air and NC feeder.',
            'specs' => [
                'C-FRAME POWER PRESS MACHINE 15 Ton - 160 Ton: Seyi, Aida and Amada',
                'HIGH SPEED PRESS MACHINE 15 Ton to 60 Ton: Yamada Dobby, Amada, Seyi and ISIS',
                'Other supporting machine such as auto cutting machine, tapping, reverting machine and manual press machine',
                'Prototyping to production',
            ],
            'image' => '/images/facilities/snc-80-mechanical-stamping-press.png',
        ],
        [
            'key' => 'supporting-machines',
            'title' => 'Supporting Machines',
            'summary' => 'Our manufacturing facilities include complete in-house tooling departments, which allow us to maintain the lowest tooling costs and the fastest deliveries in the industry.',
            'specs' => [
                'CNC WireCut machine (Sodick & Mitsubishi)',
                'NC EDM (SEIKI)',
                'NC Superdrill (SEIKI)',
                'Grinding Machine (Okamoto & Equiptop)',
                'CNC Miling (Hurco)',
                'Manual Milling & Lathe',
                'LX-A1 Portable Laser Engraving Machine',
            ],
            'image' => '/images/facilities/sheet-metal-laser-cutting-machine.jpg',
        ],
        [
            'key' => 'tools-design-storage',
            'title' => 'Tools Design and Storage',
            'summary' => 'UMI adopts and applies precision processing technology by utilizing its management team many years of experience and effort to producing better quality products.',
            'specs' => [
                'High quality products are achieved by an optimum combination of equipment, dies, engineers and management team.',
                'Our Engineering team are capable to design and fabricate Die set locally with short lead time.',
                'High end Die set are supported from Singapore & Malaysia.',
                'We also produce prototype for our customer before proceeding with mass production tooling if required.',
            ],
            'image' => '/images/facilities/donrun-four-column-hydraulic-press.png',
        ],
        [
            'key' => 'measurement-equipment',
            'title' => 'Measurement Machine',
            'summary' => 'We are the believer of the concept of "Quality is build in not through inspection" yet high precision QA equipments are crucial in maintaining only high quality parts are delivered to our customers.',
            'specs' => [
                'Optical Measurement (VS)',
                'Profile Projector (Mitutoyo)',
                'High Gauge (Mitutoyo)',
                'Pin Gauge',
                'Block Gauge',
                'Vernier Caliper',
                'Micrometer',
                'Regular calibration is carried out for all QA equipment to ensure accuracy both internally and externally.',
            ],
            'image' => '/images/facilities/eko-esii2508-sheet-metal-bending-machine.png',
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
        'email' => 'info@umistamping.com',
        'phone' => '+62 778 464141',
        'location' => 'Batam, Indonesia',
    ],

    'gallery' => [
        ['title' => 'Manufacturing floor', 'label' => 'Production environment', 'image' => '/images/hero/factory.jpg'],
        ['title' => 'Precision machinery', 'label' => 'Production equipment', 'image' => '/images/facilities/snc-80-mechanical-stamping-press.png'],
        ['title' => 'Production process', 'label' => 'Manufacturing capability', 'image' => '/images/facilities/sheet-metal-laser-cutting-machine.jpg'],
        ['title' => 'Engineering detail', 'label' => 'Precision manufacturing', 'image' => '/images/products/formed-steel-mounting-plate.png'],
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
