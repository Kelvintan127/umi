<?php

/*
|--------------------------------------------------------------------------
| Per-page copy — English source locale
|--------------------------------------------------------------------------
|
| Every page in App\Support\Pages::REGISTRY has an entry here. A page renders
| its `hero` plus an ordered list of `sections`; the React side has one
| component per section `type`, so page structure lives in data and the visual
| design lives in the components.
|
| Section types the renderer understands:
|   prose         heading + paragraphs (+ image, alignment)
|   cards         grid of title/description (image optional)
|   specs         list of title/summary/specs[] (image optional)
|   policy        numbered commitment list
|   stats         the four headline figures from site.php
|   testimonials  customer quotes from site.php
|   gallery       image grid from site.php
|   legal         numbered clauses with heading + body
|   cta           contact call to action
|   process       the six-stage workflow
|
| Provenance: all copy is carried from https://www.umistamping.com/ or the
| migrated Next.js content (src/data/site.ts @ b5c0c50). No invented claims.
|
*/

return [

    'home' => [
        'seo' => [
            'title' => 'UMI Stamping — Precision Metal Stamping Manufacturer in Batam, Indonesia',
            'description' => 'PT. Uni-Metaltech Industry is a precision metal stamping manufacturer in Batam, Indonesia. Stamping, tool and die, welding and assembly for automotive, electronics and industrial applications.',
        ],
        'hero' => [
            'eyebrow' => 'Precision manufacturing',
            'title' => 'Precision. Manufacturing excellence.',
            'lead' => 'Precision metal stamping, tooling, welding, assembly, and manufacturing solutions engineered for demanding industries.',
            'video' => '/videos/hero-factory.mp4',
            'video_mobile' => '/videos/hero-factory-mobile.mp4',
            'poster' => '/images/hero/factory.jpg',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Precision metal stamping, engineered in Batam',
                'video' => '/media/company-profile.mp4',
                'paragraphs' => [
                    'PT. Uni-Metaltech Industry (UMI) is a precision metal stamping company incorporated in the year 2000 in Batam, Indonesia. Our factory sits in Kara Industrial Park, Batam Center, with a Jakarta Sales Office in Jababeka Industrial Park established in 2014.',
                    'We manufacture battery contacts, wire harnesses and cable terminals, ODS DVD drive parts, mechanical assemblies, and electrical and other metal parts for electrical, electronic and automotive manufacturers.',
                ],
            ],
            ['type' => 'stats'],
            ['type' => 'process', 'heading' => 'From design to delivery'],
            ['type' => 'cards', 'heading' => 'Our products and services', 'source' => 'products', 'link_base' => 'products'],
            ['type' => 'specs', 'heading' => 'Inside the factory', 'source' => 'facilities'],
            ['type' => 'certifications', 'heading' => 'Quality and certifications'],
            ['type' => 'policy', 'heading' => 'Company policy'],
            ['type' => 'cta'],
        ],
    ],

    'about' => [
        'seo' => [
            'title' => 'About UMI Stamping — PT. Uni-Metaltech Industry',
            'description' => 'PT. Uni-Metaltech Industry is a precision metal stamping company incorporated in 2000 in Batam, Indonesia, with a Jakarta sales office in Jababeka since 2014.',
        ],
        'hero' => [
            'eyebrow' => 'About Us',
            'title' => 'Precision metal parts for leading manufacturers.',
            'lead' => 'Our company produces many kinds of custom-made metal parts and supports world’s leading manufacturers in electrical, electronic and automotive industries.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Our Company',
                'video' => '/media/company-profile.mp4',
                'paragraphs' => [
                    'Our Company produces many kinds of custom-made metal parts and supports world’s leading Manufactures in Electrical, Electronic and Automotive Industries. The metal parts are used in various products such as Battery pack & applied, Cable terminal, Audio System, Weighing System, Audible Warning Devices, etc.',
                    'PT. UNI METALTECH INDUSTRY (UMI) is a precision metal stamping company and incorporated in year 2000 in Batam - Indonesia. It is located at Kara Industrial Park - Batam center.',
                    'Our factory in Batam Island which is a Free Trade Zone and it is considered as the best manufacturing location compared to other places in Indonesia especially for export oriented manufacturing base.',
                    'Our factory space is about 3,000 m2, consist of production, warehouse and office area.',
                    'We have gain experiences over the time and we are capable to stamp material as thin as 0.10 mm which required high precision tooling and skilled engineers.',
                ],
            ],
            ['type' => 'stats'],
            ['type' => 'cards', 'heading' => 'Capabilities', 'source' => 'capabilities'],
            ['type' => 'cta'],
        ],
    ],

    'certifications' => [
        'seo' => [
            'title' => 'Certifications — UMI Stamping',
            'description' => 'PT. UMI has been certified according to International Standard ISO 9001:2015 Edition and ISO 14000:2015.',
        ],
        'hero' => [
            'eyebrow' => 'Certifications',
            'title' => 'Certified for confidence.',
            'lead' => 'Our certifications reflect the commitment to structured manufacturing systems, quality assurance and continuous improvement.',
            'note' => 'site.quality.labelling',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Management systems',
                'paragraphs' => [
                    'To confirm with our customer requirements and commitment of good management systems, PT. UMI has been certified since 2000 according to International Standard ISO 9001 : 2015 Edition and ISO 14000 : 2015.',
                    'Internal audit and audits conducted by an external, independent, accredited assessment and certification bodies ensure that our manufacturing management system is periodically reviewed, audited and updated to sustain operational competency, compliance to specification as well as continual product quality and performance improvements.',
                    'In addition, all Raw material are tested to comply with government rules and various customer requirements such as RoHS, REACH, etc.',
                ],
            ],
            ['type' => 'certifications'],
            ['type' => 'cta'],
        ],
    ],

    'policy' => [
        'seo' => [
            'title' => 'Quality and Environmental Policy — UMI Stamping',
            'description' => 'The published quality and environmental policy of PT. Uni-Metaltech Industry.',
        ],
        'hero' => [
            'eyebrow' => 'Company policy',
            'title' => 'Committed to quality and sustainability.',
            'lead' => 'The quality and environmental policy published by PT. Uni-Metaltech Industry.',
        ],
        'sections' => [
            ['type' => 'policy'],
            ['type' => 'cta'],
        ],
    ],

    'capabilities' => [
        'seo' => [
            'title' => 'Capabilities — UMI Stamping',
            'description' => 'Integrated metal stamping capabilities: precision stamping to 0.10 mm, in-house tool and die, welding, and mechanical assembly.',
        ],
        'hero' => [
            'eyebrow' => 'Capabilities',
            'title' => 'Integrated manufacturing.',
            'lead' => 'From engineering and tooling to stamping, assembly and quality inspection — our capabilities are designed to deliver consistent quality and reliability.',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => 'What we do', 'source' => 'capabilities'],
            ['type' => 'process'],
            ['type' => 'stats'],
            ['type' => 'cta'],
        ],
    ],

    'products' => [
        'seo' => [
            'title' => 'Products and Services — UMI Stamping',
            'description' => 'UMI produces custom-made battery contacts, cable terminals, other metal parts and in-house mechanical assembly services.',
        ],
        'hero' => [
            'eyebrow' => 'Products and services',
            'title' => 'Product & Services.',
            'lead' => 'UMI produces various kinds of metal parts and mostly are customized to specific project needs. Our products and services capability includes battery contacts, cable terminals, other metal parts applications and in-house mechanical assembly.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Product Range',
                'paragraphs' => [
                    'UMI produces various kinds of metal parts and mostly are customized to specific project needs. Our products and services capability are:',
                    'We have gain experiences over the time and we are capable to stamp material as thin as 0.10 mm which required high precision tooling and skilled engineers.',
                ],
            ],
            ['type' => 'cards', 'heading' => 'Product range', 'source' => 'products', 'link_base' => '/products/'],
            ['type' => 'cta'],
        ],
    ],

    'products.battery-contacts' => [
        'seo' => [
            'title' => 'Battery Contacts — UMI Stamping',
            'description' => 'Precision stamped battery contacts for electronic appliances, battery packs and portable electronic devices.',
        ],
        'hero' => [
            'eyebrow' => 'Products',
            'title' => 'Battery contacts.',
            'lead' => 'Battery Contact products are widely used in electronic appliances, battery packs and portable electronic devices.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Application',
                'image' => '/images/products/assorted-precision-metal-stamping-parts.png',
                'paragraphs' => [
                    'Battery contacts are stamped from strip material to the dimensional and contact-resistance requirements of the battery pack or device they serve.',
                    'Typical applications include battery packs and portable electronic devices, where contact geometry and material selection determine both electrical performance and cycle life.',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.wire-harnessing' => [
        'seo' => [
            'title' => 'Wire Harnessing and Cable Terminals — UMI Stamping',
            'description' => 'Cable terminals used in wire-harnessing applications supporting the electrical and automotive industries.',
        ],
        'hero' => [
            'eyebrow' => 'Products',
            'title' => 'Wire harnessing and cable terminals.',
            'lead' => 'Cable terminals used in wire-harnessing applications supporting the electrical and automotive industries.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Application',
                'image' => '/images/products/precision-metal-bar-assembly.png',
                'paragraphs' => [
                    'UMI stamps cable terminals for wire-harnessing applications in the electrical and automotive industries.',
                    'Terminal parts are produced in-house and can be combined with secondary operations such as tapping, reverting and spot welding when a project requires an assembled component.',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.ods-dvd-drive' => [
        'seo' => [
            'title' => 'ODS DVD Drive Parts — UMI Stamping',
            'description' => 'Precision stamped metal parts for optical disc drive assemblies.',
        ],
        'hero' => [
            'eyebrow' => 'Products',
            'title' => 'ODS DVD drive parts.',
            'lead' => 'Precision stamped parts for optical disc drive assemblies, produced to tight dimensional requirements.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Application',
                'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
                'paragraphs' => [
                    'Optical disc drive assemblies use stamped metal components where flatness, dimensional accuracy and surface condition affect the movement of the drive mechanism.',
                    'These parts are produced with progressive tooling and verified with the measurement equipment described in our facilities section.',
                ],
                'note' => 'Detailed part specifications are available on request; they are not published on this page.',
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.mechanical-assembly' => [
        'seo' => [
            'title' => 'Mechanical Assembly — UMI Stamping',
            'description' => 'Value-added in-house mechanical assembly including tapping, reverting and spot welding.',
        ],
        'hero' => [
            'eyebrow' => 'Products',
            'title' => 'Mechanical assembly.',
            'lead' => 'Value-added services such as tapping, reverting and spot welding are provided in-house to give a more comprehensive service to our customers.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Secondary operations, in house',
                'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
                'paragraphs' => [
                    'Value-added services such as tapping, reverting and spot welding are provided in-house to give a more comprehensive service to our customers.',
                ],
            ],
            [
                'type' => 'specs',
                'heading' => 'In-house secondary operations',
                'items' => [
                    ['title' => 'Tapping', 'summary' => 'Threaded operations performed in-house after stamping.', 'specs' => []],
                    ['title' => 'Reverting', 'summary' => 'Reverting operations performed in-house after stamping.', 'specs' => []],
                    ['title' => 'Spot welding', 'summary' => 'Spot welding carried out in-house as a secondary process.', 'specs' => []],
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.electrical-metal-parts' => [
        'seo' => [
            'title' => 'Electrical and Other Metal Parts — UMI Stamping',
            'description' => 'Stamped metal parts for computer, printer, telephone, MCB, power supply, lighting device and UPS applications.',
        ],
        'hero' => [
            'eyebrow' => 'Products',
            'title' => 'Electrical and other metal parts.',
            'lead' => 'Metal parts for computer, printer, telephone, MCB, power supply, lighting device and UPS applications.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Application',
                'image' => '/images/products/formed-steel-mounting-plate.png',
                'paragraphs' => [
                    'UMI produces a broad range of custom metal parts for electrical and electronic applications, mostly customized to specific project needs.',
                    'Applications include computer, printer, telephone, miniature circuit breaker (MCB), power supply, lighting device and UPS products.',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'facilities' => [
        'seo' => [
            'title' => 'Facilities — UMI Stamping',
            'description' => 'UMI manufacturing facilities: production presses from 15 to 160 ton, supporting tooling machines, tool design and storage, and measurement equipment.',
        ],
        'hero' => [
            'eyebrow' => 'Facilities',
            'title' => 'Equipment behind the precision.',
            'lead' => 'Production presses, in-house tooling machines, organised tool storage and high-precision measurement equipment.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Facility groups', 'source' => 'facilities'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.production-machines' => [
        'seo' => [
            'title' => 'Production Machines — UMI Stamping',
            'description' => 'C-frame power presses from 15 to 160 ton by Seyi, Aida and Amada; high-speed presses by Yamada Dobby, Amada, Seyi and ISIS.',
        ],
        'hero' => [
            'eyebrow' => 'Facilities',
            'title' => 'Production machines.',
            'lead' => 'Production machines range from 15 to 160 ton presses made in Japan and Taiwan, with mechanical roller, air and NC feeders.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Press equipment', 'only' => 'production-machines'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.supporting-machines' => [
        'seo' => [
            'title' => 'Supporting Machines — UMI Stamping',
            'description' => 'In-house tooling equipment: CNC WireCut, NC EDM, NC Superdrill, grinding, CNC milling and laser engraving.',
        ],
        'hero' => [
            'eyebrow' => 'Facilities',
            'title' => 'Supporting machines.',
            'lead' => 'A complete in-house tooling department keeps tooling cost low and delivery short through continual investment in equipment.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Tooling and engineering equipment', 'only' => 'supporting-machines'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.tools-design-storage' => [
        'seo' => [
            'title' => 'Tools Design and Storage — UMI Stamping',
            'description' => 'In-house die design and fabrication with short lead times, prototype production, and organised tool storage.',
        ],
        'hero' => [
            'eyebrow' => 'Facilities',
            'title' => 'Tools design and storage.',
            'lead' => 'Our engineering team designs and fabricates die sets locally with short lead time; high-end die sets are supported from Singapore and Malaysia.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Tooling capability', 'only' => 'tools-design-storage'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.measurement-equipment' => [
        'seo' => [
            'title' => 'Measurement Equipment — UMI Stamping',
            'description' => 'Optical measurement, Mitutoyo profile projector and high gauge, pin and block gauges, vernier caliper and micrometer, with regular internal and external calibration.',
        ],
        'hero' => [
            'eyebrow' => 'Facilities',
            'title' => 'Measurement machine.',
            'lead' => 'High-precision QA equipment keeps the commitment that only high-quality parts are delivered; calibration is carried out internally and externally.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Quality assurance equipment', 'only' => 'measurement-equipment'],
            ['type' => 'cta'],
        ],
    ],

    'metal-part-users' => [
        'seo' => [
            'title' => 'Our Metal Part Users — UMI Stamping',
            'description' => 'Manufacturers across the electrical, electronic and automotive industries supplied with UMI metal parts.',
        ],
        'hero' => [
            'eyebrow' => 'Our metal part users',
            'title' => 'Trusted by leading manufacturers.',
            'lead' => 'UMI supplies metal parts to manufacturers across the electrical, electronic and automotive industries.',
        ],
        'sections' => [
            ['type' => 'users'],
            ['type' => 'testimonials'],
            ['type' => 'cta'],
        ],
    ],

    'industries' => [
        'seo' => [
            'title' => 'Industries — UMI Stamping',
            'description' => 'Manufacturing solutions for automotive, electronics, industrial and consumer industries.',
        ],
        'hero' => [
            'eyebrow' => 'Industries',
            'title' => 'Built for demanding industries.',
            'lead' => 'Manufacturing solutions engineered around the requirements of different industries — from automotive to consumer electronics.',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => 'Industries served', 'source' => 'industries'],
            ['type' => 'users'],
            ['type' => 'cta'],
        ],
    ],

    'quality' => [
        'seo' => [
            'title' => 'Quality — UMI Stamping',
            'description' => 'Quality is built in, not inspected in: principles, certifications and measurement equipment at UMI Stamping.',
        ],
        'hero' => [
            'eyebrow' => 'Quality assurance',
            'title' => 'Quality is built in, not inspected in.',
            'lead' => 'We are the believer of the concept "quality is built in, not through inspection" — yet high-precision QA equipment ensures only high-quality parts are delivered.',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => 'Quality principles', 'source' => 'quality.principles'],
            ['type' => 'certifications'],
            ['type' => 'specs', 'heading' => 'Measurement equipment', 'only' => 'measurement-equipment'],
            ['type' => 'cta'],
        ],
    ],

    'gallery' => [
        'seo' => [
            'title' => 'Gallery — UMI Stamping',
            'description' => 'The UMI manufacturing environment, production capability and the people behind the work.',
        ],
        'hero' => [
            'eyebrow' => 'Gallery',
            'title' => 'Built by people. Powered by technology.',
            'lead' => 'Explore our manufacturing environment, production capabilities and the people behind our work.',
        ],
        'sections' => [
            ['type' => 'gallery'],
            ['type' => 'cta'],
        ],
    ],

    'news' => [
        'seo' => [
            'title' => 'News and Updates — UMI Stamping',
            'description' => 'News and updates from PT. Uni-Metaltech Industry.',
        ],
        'hero' => [
            'eyebrow' => 'News and updates',
            'title' => 'Latest from UMI Stamping.',
            'lead' => 'Company updates from PT. Uni-Metaltech Industry.',
        ],
        'sections' => [
            ['type' => 'news'],
            ['type' => 'cta'],
        ],
    ],

    'contact' => [
        'seo' => [
            'title' => 'Contact — UMI Stamping',
            'description' => 'Contact PT. Uni-Metaltech Industry: Batam manufacturing factory and Jakarta sales representative office, with phone, fax and email.',
        ],
        'hero' => [
            'eyebrow' => 'Contact',
            'title' => 'Have a part to manufacture?',
            'lead' => 'Tell us what you are building. Our engineering and manufacturing team can help turn your requirements into a reliable production solution.',
        ],
        'sections' => [],
    ],

    'privacy' => [
        'seo' => [
            'title' => 'Privacy Policy — UMI Stamping',
            'description' => 'How PT. Uni-Metaltech Industry collects, uses and protects your information.',
        ],
        'hero' => [
            'eyebrow' => 'Legal',
            'title' => 'Privacy policy.',
            'lead' => 'How PT. Uni-Metaltech Industry collects, uses and protects your information.',
        ],
        'sections' => [
            [
                'type' => 'legal',
                'clauses' => [
                    ['heading' => 'Information we collect', 'body' => ['When you contact us through our website or inquiry forms, we may collect your name, company name, email address, phone number and any project details you provide voluntarily. This information is used solely for the purpose of responding to your inquiry and providing manufacturing services.']],
                    ['heading' => 'Use of information', 'body' => ['Your information is used to process inquiries, prepare quotations, communicate about projects and provide manufacturing services. We do not sell, rent or share your personal information with third parties for marketing purposes.']],
                    ['heading' => 'Data security', 'body' => ['We implement appropriate technical and organisational measures to protect your personal information against unauthorised access, alteration, disclosure or destruction. Access to personal data is restricted to authorised personnel only.']],
                    ['heading' => 'Cookies', 'body' => ['Our website may use cookies to improve user experience and analyse website traffic. You can control cookies through your browser settings. Disabling cookies may affect some functionality of the website.']],
                    ['heading' => 'Third-party links', 'body' => ['Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites. We encourage you to review the privacy policies of any third-party sites you visit.']],
                    ['heading' => 'Contact us', 'body' => ['If you have questions about this Privacy Policy, please contact PT. Uni-Metaltech Industry (UMI Stamping), Kara Industrial Park Block - C 05 No. 01, Batam Center 29432, Indonesia. Phone +62 778 464141. Email info@umistamping.com.']],
                ],
            ],
        ],
    ],

    'terms' => [
        'seo' => [
            'title' => 'Terms of Service — UMI Stamping',
            'description' => 'The terms and conditions governing use of the UMI Stamping website and manufacturing services.',
        ],
        'hero' => [
            'eyebrow' => 'Legal',
            'title' => 'Terms of service.',
            'lead' => 'The terms and conditions governing use of our website and manufacturing services.',
        ],
        'sections' => [
            [
                'type' => 'legal',
                'clauses' => [
                    ['heading' => 'Acceptance of terms', 'body' => ['By accessing and using the UMI Stamping website, you accept and agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our website.']],
                    ['heading' => 'Services', 'body' => ['PT. Uni-Metaltech Industry (UMI Stamping) provides precision metal stamping, tooling, welding and assembly services. The information on this website is provided for general informational purposes and does not constitute an offer or contract for services.']],
                    ['heading' => 'Intellectual property', 'body' => ['All content on this website, including text, graphics, logos, images and software, is the property of PT. Uni-Metaltech Industry and is protected by intellectual property laws. You may not reproduce, distribute or use any content without prior written permission.']],
                    ['heading' => 'Quotations and orders', 'body' => ['All quotations provided by UMI Stamping are subject to change based on material costs, design revisions and order quantities. Orders are accepted subject to our standard terms and conditions of sale, which will be provided with formal quotations.']],
                    ['heading' => 'Limitation of liability', 'body' => ['UMI Stamping shall not be liable for any indirect, incidental or consequential damages arising from the use of our website or services. Our total liability is limited to the value of the services provided.']],
                    ['heading' => 'Governing law', 'body' => ['These Terms of Service are governed by the laws of the Republic of Indonesia. Any disputes shall be resolved in the courts having jurisdiction over Batam, Indonesia.']],
                    ['heading' => 'Contact', 'body' => ['For questions regarding these Terms of Service, please contact PT. Uni-Metaltech Industry (UMI Stamping), Kara Industrial Park Block - C 05 No. 01, Batam Center 29432, Indonesia. Phone +62 778 464141. Email info@umistamping.com.']],
                ],
            ],
        ],
    ],

];
