<?php

/*
|--------------------------------------------------------------------------
| Per-page copy — Simplified Chinese (zh) — UNREVIEWED DRAFT
|--------------------------------------------------------------------------
|
| STATUS: This is an unreviewed Simplified Chinese draft. It is NOT
| company-approved. It is not served to visitors until a locale code is
| added to config/locales.php by the company. The English source in
| lang/en/pages.php is authoritative: where this file and the English
| source disagree, English governs.
|
| Provenance: translated from lang/en/pages.php only. No claim, figure,
| certification, customer or product has been added. Brand tokens (UMI,
| PT. Uni-Metaltech Industry, ISO 9001:2015, ISO 14001:2015, SMETA, Batam,
| Jababeka, Cikarang, Kara Industrial Park, ODS DVD, mm units, machine
| makes, certificate identifiers) and all URL paths, emails, phone and fax
| numbers are carried verbatim.
|
| Structure mirrors lang/en/pages.php exactly: identical page keys,
| identical 'seo'/'hero'/'sections' keys, and within 'sections' the same
| 'type' values in the same order with the same counts of paragraphs,
| items and clauses, so the React components can index by key.
|
*/

return [

    'home' => [
        'seo' => [
            'title' => 'UMI Stamping — 印度尼西亚 Batam 精密金属冲压制造商',
            'description' => 'PT. Uni-Metaltech Industry 是位于印度尼西亚 Batam 的精密金属冲压制造商。为汽车、电子及工业应用提供冲压、模具、焊接与组装服务。',
        ],
        'hero' => [
            'eyebrow' => '精密制造',
            'title' => '精密。卓越制造。',
            'lead' => '为要求严苛的行业量身打造的精密金属冲压、模具、焊接、组装与制造解决方案。',
            'video' => '/videos/hero-factory.mp4',
            'video_mobile' => '/videos/hero-factory-mobile.mp4',
            'poster' => '/images/hero/factory.jpg',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '精密金属冲压，源于 Batam 的工程制造',
                'video' => '/media/company-profile.mp4',
                'paragraphs' => [
                    'PT. Uni-Metaltech Industry (UMI) 是一家精密金属冲压企业，于 2000 年在印度尼西亚 Batam 注册成立。我们的工厂位于 Batam Center 的 Kara Industrial Park，并于 2014 年在 Jababeka Industrial Park 设立了雅加达销售办事处。',
                    '我们为电气、电子及汽车制造商生产电池触点、线束与接线端子、ODS DVD 驱动器部件、机械组件，以及电气及其他金属零件。',
                ],
            ],
            ['type' => 'stats'],
            ['type' => 'process', 'heading' => '从设计到交付'],
            ['type' => 'cards', 'heading' => '我们的产品与服务', 'source' => 'products', 'link_base' => 'products'],
            ['type' => 'specs', 'heading' => '工厂内部', 'source' => 'facilities'],
            ['type' => 'certifications', 'heading' => '质量与认证'],
            ['type' => 'policy', 'heading' => '公司方针'],
            ['type' => 'cta'],
        ],
    ],

    'about' => [
        'seo' => [
            'title' => '关于 UMI Stamping — PT. Uni-Metaltech Industry',
            'description' => 'PT. Uni-Metaltech Industry 是一家精密金属冲压企业，于 2000 年在印度尼西亚 Batam 注册成立，自 2014 年起在 Jababeka 设有雅加达销售办事处。',
        ],
        'hero' => [
            'eyebrow' => '关于 UMI',
            'title' => '自 2000 年以来的精密冲压。',
            'lead' => 'PT. Uni-Metaltech Industry (UMI) 是一家精密金属冲压企业，于 2000 年在印度尼西亚 Batam 注册成立。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '具战略意义的制造区位',
                'video' => '/media/company-profile.mp4',
                'paragraphs' => [
                    '我们的工厂位于 Batam Center 的 Kara Industrial Park，距离 Singapore Batamindo Industrial Park 与国际渡轮码头不远。',
                    'Batam 岛是自由贸易区，被视为印度尼西亚最佳的出口导向型生产基地之一。我们同时受益于印度尼西亚具竞争力的成本优势，以及新加坡高技能、快速的支持。',
                    '我们的厂房面积约 3,000 m²，由生产区、仓库区和办公区组成。雅加达销售办事处于 2014 年设立于 Jababeka Industrial Park。',
                ],
            ],
            ['type' => 'stats'],
            ['type' => 'cards', 'heading' => '制造能力', 'source' => 'capabilities'],
            ['type' => 'cta'],
        ],
    ],

    'company-profile' => [
        'seo' => [
            'title' => '公司简介 — UMI Stamping',
            'description' => 'PT. Uni-Metaltech Industry 公司简介：2000 年注册成立于印度尼西亚 Batam，厂房面积约 3,000 m²，服务电气、电子及汽车制造商。',
        ],
        'hero' => [
            'eyebrow' => '公司简介',
            'title' => '值得信赖的精密金属冲压合作伙伴。',
            'lead' => 'UMI 生产定制金属零件，为电气、电子及汽车行业的领先制造商提供支持。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '关于我们',
                'image' => '/images/about/factory.jpg',
                'paragraphs' => [
                    'PT. UNI METALTECH INDUSTRY (UMI) 是一家精密金属冲压企业，于 2000 年在印度尼西亚 Batam 注册成立，位于 Batam Center 的 Kara Industrial Park。',
                    '本公司生产多种定制金属零件，为电气、电子及汽车行业的领先制造商提供支持。这些金属零件应用于电池组及应用、接线端子、音响系统、称重系统与声响报警装置等产品。',
                    '我们在长期经营中积累了经验，能够冲压薄至 0.10 mm 的材料，这需要高精密模具与熟练的工程师。',
                ],
            ],
            [
                'type' => 'specs',
                'heading' => '公司概况',
                'items' => [
                    ['title' => '成立时间', 'summary' => '于 2000 年在印度尼西亚 Batam 注册成立。', 'specs' => []],
                    ['title' => '工厂', 'summary' => '位于 Batam Center 的 Kara Industrial Park，生产、仓库与办公面积约 3,000 m²。', 'specs' => []],
                    ['title' => '销售办事处', 'summary' => '设于 Jababeka Industrial Park 的雅加达销售代表办事处，成立于 2014 年。', 'specs' => []],
                    ['title' => '制造能力', 'summary' => '可冲压薄至 0.10 mm 的材料，冲床能力为 15 至 160 吨。', 'specs' => []],
                ],
            ],
            ['type' => 'process'],
            ['type' => 'cta'],
        ],
    ],

    'certifications' => [
        'seo' => [
            'title' => '认证 — UMI Stamping',
            'description' => 'UMI Stamping 管理体系认证：ISO 9001:2015 质量管理体系与 ISO 14001:2015 环境管理体系，并通过 SMETA 道德贸易审核。',
        ],
        'hero' => [
            'eyebrow' => '认证',
            'title' => '以认证铸就信赖。',
            'lead' => '我们的认证体现了对规范化制造体系、质量保证与持续改进的承诺。',
            'note' => 'site.quality.labelling',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '管理体系',
                'paragraphs' => [
                    '为符合客户要求，并作为对良好管理体系的承诺，PT. UMI 自 2000 年起已按国际标准 ISO 9001:2015 版及 ISO 14001:2015 获得认证。',
                    '内部审核，以及由外部独立且获认可的评估与认证机构实施的审核，确保我们的制造管理体系得到定期评审、审核与更新，以持续保持运营能力、符合规格，并持续改进产品质量与性能表现。',
                    '所有原材料均经检测，以符合政府法规及客户的各项要求，如 RoHS 与 REACH。',
                ],
            ],
            ['type' => 'certifications'],
            ['type' => 'cta'],
        ],
    ],

    'policy' => [
        'seo' => [
            'title' => '质量与环境方针 — UMI Stamping',
            'description' => 'PT. Uni-Metaltech Industry 已发布的质量与环境方针。',
        ],
        'hero' => [
            'eyebrow' => '公司方针',
            'title' => '致力质量与可持续发展。',
            'lead' => 'PT. Uni-Metaltech Industry 发布的质量与环境方针。',
        ],
        'sections' => [
            ['type' => 'policy'],
            ['type' => 'cta'],
        ],
    ],

    'capabilities' => [
        'seo' => [
            'title' => '制造能力 — UMI Stamping',
            'description' => '一体化金属冲压能力：薄至 0.10 mm 的精密冲压、厂内模具、焊接与机械组装。',
        ],
        'hero' => [
            'eyebrow' => '制造能力',
            'title' => '一体化制造。',
            'lead' => '从工程设计与模具制作，到冲压、组装与质量检验 — 我们的制造能力旨在实现始终如一的质量与可靠性。',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => '我们的业务', 'source' => 'capabilities'],
            ['type' => 'process'],
            ['type' => 'stats'],
            ['type' => 'cta'],
        ],
    ],

    'products' => [
        'seo' => [
            'title' => '产品与服务 — UMI Stamping',
            'description' => 'UMI 产品范围：电池触点、线束加工与接线端子、ODS DVD 驱动器部件、机械组装，以及电气及其他金属零件。',
        ],
        'hero' => [
            'eyebrow' => '产品与服务',
            'title' => '定制金属零部件。',
            'lead' => 'UMI 生产多种金属零件，大多按具体项目需求定制。我们能够冲压薄至 0.10 mm 的材料，这需要高精密模具与熟练的工程师。',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => '产品范围', 'source' => 'products', 'link_base' => '/products/'],
            ['type' => 'cta'],
        ],
    ],

    'products.battery-contacts' => [
        'seo' => [
            'title' => '电池触点 — UMI Stamping',
            'description' => '用于电子电器、电池组与便携式电子设备的精密冲压电池触点。',
        ],
        'hero' => [
            'eyebrow' => '产品',
            'title' => '电池触点。',
            'lead' => '广泛用于电子电器、电池组与便携式电子设备的电池触点。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '应用',
                'image' => '/images/products/battery-contacts.jpg',
                'paragraphs' => [
                    '电池触点由带材冲压而成，满足其所配套的电池组或设备在尺寸与接触电阻方面的要求。',
                    '典型应用包括电池组与便携式电子设备，其中触点的几何形状与材料选择同时决定电气性能与循环寿命。',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.wire-harnessing' => [
        'seo' => [
            'title' => '线束加工与接线端子 — UMI Stamping',
            'description' => '用于线束加工应用、服务电气与汽车行业的接线端子。',
        ],
        'hero' => [
            'eyebrow' => '产品',
            'title' => '线束加工与接线端子。',
            'lead' => '用于线束加工应用、服务电气与汽车行业的接线端子。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '应用',
                'image' => '/images/products/wire-harnessing.jpg',
                'paragraphs' => [
                    'UMI 为电气与汽车行业的线束加工应用冲压接线端子。',
                    '端子零件为厂内生产，当项目需要组装成件时，可结合攻牙、铆合与点焊等二次加工。',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.ods-dvd-drive' => [
        'seo' => [
            'title' => 'ODS DVD 驱动器部件 — UMI Stamping',
            'description' => '用于光盘驱动器组件的精密冲压金属零件。',
        ],
        'hero' => [
            'eyebrow' => '产品',
            'title' => 'ODS DVD 驱动器部件。',
            'lead' => '用于光盘驱动器组件的精密冲压零件，按严格的尺寸要求生产。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '应用',
                'image' => '/images/products/ods-dvd-drive.jpg',
                'paragraphs' => [
                    '光盘驱动器组件使用冲压金属零部件，其平面度、尺寸精度与表面状态会影响驱动机构的运动。',
                    '这些零件采用连续模生产，并使用我们生产设施章节所述的测量设备进行验证。',
                ],
                'note' => '详细零件规格可来函索取；本页面不予公布。',
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.mechanical-assembly' => [
        'seo' => [
            'title' => '机械组装 — UMI Stamping',
            'description' => '包括攻牙、铆合与点焊的增值厂内机械组装。',
        ],
        'hero' => [
            'eyebrow' => '产品',
            'title' => '机械组装。',
            'lead' => '攻牙、铆合与点焊等增值服务由厂内提供，为客户带来更全面的服务。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '厂内二次加工',
                'image' => '/images/products/mechanical-assembly.jpg',
                'paragraphs' => [
                    '攻牙、铆合与点焊等增值服务由厂内提供，为客户带来更全面的服务。',
                ],
            ],
            [
                'type' => 'specs',
                'heading' => '厂内二次加工',
                'items' => [
                    ['title' => '攻牙', 'summary' => '冲压完成后在厂内进行的螺纹加工。', 'specs' => []],
                    ['title' => '铆合', 'summary' => '冲压完成后在厂内进行的铆合加工。', 'specs' => []],
                    ['title' => '点焊', 'summary' => '作为二次工序在厂内进行的点焊。', 'specs' => []],
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.electrical-metal-parts' => [
        'seo' => [
            'title' => '电气及其他金属零件 — UMI Stamping',
            'description' => '用于计算机、打印机、电话、MCB、电源、照明设备与 UPS 应用的冲压金属零件。',
        ],
        'hero' => [
            'eyebrow' => '产品',
            'title' => '电气及其他金属零件。',
            'lead' => '用于计算机、打印机、电话、MCB、电源、照明设备与 UPS 应用的金属零件。',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => '应用',
                'image' => '/images/products/electrical-metal-parts.jpg',
                'paragraphs' => [
                    'UMI 生产范围广泛的电气与电子应用定制金属零件，大多按具体项目需求定制。',
                    '应用包括计算机、打印机、电话、微型断路器（MCB）、电源、照明设备与 UPS 产品。',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'facilities' => [
        'seo' => [
            'title' => '生产设施 — UMI Stamping',
            'description' => 'UMI 生产设施：15 至 160 吨生产冲床、配套模具设备、模具设计与存放，以及测量设备。',
        ],
        'hero' => [
            'eyebrow' => '生产设施',
            'title' => '精密背后的设备。',
            'lead' => '生产冲床、厂内模具设备、有序的模具存放与高精密测量设备。',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => '设施分类', 'source' => 'facilities'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.production-machines' => [
        'seo' => [
            'title' => '生产设备 — UMI Stamping',
            'description' => '由 Seyi、Aida 与 Amada 制造的 15 至 160 吨 C 型冲床；由 Yamada Dobby、Amada、Seyi 与 ISIS 制造的高速冲床。',
        ],
        'hero' => [
            'eyebrow' => '生产设施',
            'title' => '生产设备。',
            'lead' => '生产设备包括日本与台湾制造的 15 至 160 吨冲床，配机械滚轮送料机、气动送料机与 NC 送料机。',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => '冲床设备', 'only' => 'production-machines'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.supporting-machines' => [
        'seo' => [
            'title' => '配套设备 — UMI Stamping',
            'description' => '厂内模具设备：CNC 线切割、NC 电火花、NC 深孔钻、磨床、CNC 铣床与激光雕刻。',
        ],
        'hero' => [
            'eyebrow' => '生产设施',
            'title' => '配套设备。',
            'lead' => '完整的厂内模具部门通过持续的设备投入，保持较低模具成本与较短交期。',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => '模具与工程设备', 'only' => 'supporting-machines'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.tools-design-storage' => [
        'seo' => [
            'title' => '模具设计与存放 — UMI Stamping',
            'description' => '厂内模具设计与制作，交期短，可进行样品试制，并有序存放模具。',
        ],
        'hero' => [
            'eyebrow' => '生产设施',
            'title' => '模具设计与存放。',
            'lead' => '我们的工程团队在本地设计与制作模具，交期短；高端模具由新加坡与马来西亚支持。',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => '模具能力', 'only' => 'tools-design-storage'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.measurement-equipment' => [
        'seo' => [
            'title' => '测量设备 — UMI Stamping',
            'description' => '光学测量、Mitutoyo 投影仪与高精度量表、销式与块式量规、游标卡尺与千分尺，并定期进行内部与外部校准。',
        ],
        'hero' => [
            'eyebrow' => '生产设施',
            'title' => '测量设备。',
            'lead' => '高精密质检设备坚守只交付高品质零件的承诺；校准由内部与外部进行。',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => '质量保证设备', 'only' => 'measurement-equipment'],
            ['type' => 'cta'],
        ],
    ],

    'metal-part-users' => [
        'seo' => [
            'title' => '我们的金属零件用户 — UMI Stamping',
            'description' => '电气、电子及汽车行业中采用 UMI 金属零件的制造商。',
        ],
        'hero' => [
            'eyebrow' => '我们的金属零件用户',
            'title' => '深受领先制造商信赖。',
            'lead' => 'UMI 为电气、电子及汽车行业的制造商供应金属零件。',
        ],
        'sections' => [
            ['type' => 'users'],
            ['type' => 'testimonials'],
            ['type' => 'cta'],
        ],
    ],

    'industries' => [
        'seo' => [
            'title' => '行业应用 — UMI Stamping',
            'description' => '面向汽车、电子、工业与消费类行业的制造解决方案。',
        ],
        'hero' => [
            'eyebrow' => '行业应用',
            'title' => '为要求严苛的行业而造。',
            'lead' => '围绕不同行业的需求量身打造的制造解决方案 — 从汽车到消费电子。',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => '服务行业', 'source' => 'industries'],
            ['type' => 'users'],
            ['type' => 'cta'],
        ],
    ],

    'quality' => [
        'seo' => [
            'title' => '质量 — UMI Stamping',
            'description' => '质量源于制造，而非检验：UMI Stamping 的质量原则、认证与测量设备。',
        ],
        'hero' => [
            'eyebrow' => '质量保证',
            'title' => '质量源于制造，而非检验。',
            'lead' => '我们信奉「质量源于制造，而非检验」的理念 — 同时以高精密质检设备确保只交付高品质零件。',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => '质量原则', 'source' => 'quality.principles'],
            ['type' => 'certifications'],
            ['type' => 'specs', 'heading' => '测量设备', 'only' => 'measurement-equipment'],
            ['type' => 'cta'],
        ],
    ],

    'gallery' => [
        'seo' => [
            'title' => '图库 — UMI Stamping',
            'description' => 'UMI 的制造环境、生产能力，以及工作背后的人员。',
        ],
        'hero' => [
            'eyebrow' => '图库',
            'title' => '由人构建，以技术驱动。',
            'lead' => '探索我们的制造环境、生产能力，以及工作背后的人员。',
        ],
        'sections' => [
            ['type' => 'gallery'],
            ['type' => 'cta'],
        ],
    ],

    'news' => [
        'seo' => [
            'title' => '新闻与动态 — UMI Stamping',
            'description' => 'PT. Uni-Metaltech Industry 的新闻与动态。',
        ],
        'hero' => [
            'eyebrow' => '新闻与动态',
            'title' => 'UMI Stamping 最新动态。',
            'lead' => 'PT. Uni-Metaltech Industry 的公司动态。',
        ],
        'sections' => [
            ['type' => 'news'],
            ['type' => 'cta'],
        ],
    ],

    'contact' => [
        'seo' => [
            'title' => '联系我们 — UMI Stamping',
            'description' => '联系 PT. Uni-Metaltech Industry：Batam 制造工厂与雅加达销售代表办事处，含电话、传真与邮箱。',
        ],
        'hero' => [
            'eyebrow' => '联系我们',
            'title' => '有零件需要制造？',
            'lead' => '告诉我们您正在打造什么。我们的工程与制造团队可协助将您的需求转化为可靠的生产方案。',
        ],
        'sections' => [],
    ],

    'privacy' => [
        'seo' => [
            'title' => '隐私政策 — UMI Stamping',
            'description' => 'PT. Uni-Metaltech Industry 如何收集、使用与保护您的信息。',
        ],
        'hero' => [
            'eyebrow' => '法律',
            'title' => '隐私政策。',
            'lead' => 'PT. Uni-Metaltech Industry 如何收集、使用与保护您的信息。',
        ],
        'sections' => [
            [
                'type' => 'legal',
                'clauses' => [
                    ['heading' => '我们收集的信息', 'body' => ['当您通过我们的网站或询价表单联系我们时，我们可能收集您的姓名、公司名称、电子邮箱、电话号码以及您自愿提供的任何项目详细信息。这些信息仅用于回复您的询价及提供制造服务。']],
                    ['heading' => '信息的使用', 'body' => ['您的信息用于处理询价、准备报价、就项目进行沟通以及提供制造服务。我们不会为营销目的出售、出租或与第三方共享您的个人信息。']],
                    ['heading' => '数据安全', 'body' => ['我们实施适当的技术与组织措施，保护您的个人信息免遭未经授权的访问、更改、披露或销毁。个人数据的访问仅限获授权人员。']],
                    ['heading' => 'Cookie', 'body' => ['我们的网站可能使用 Cookie 以改善用户体验并分析网站流量。您可以通过浏览器设置控制 Cookie。停用 Cookie 可能影响网站的某些功能。']],
                    ['heading' => '第三方链接', 'body' => ['我们的网站可能包含指向第三方网站的链接。我们不对这些外部网站的隐私做法或内容负责。我们建议您查阅所访问的任何第三方网站的隐私政策。']],
                    ['heading' => '联系我们', 'body' => ['如您对本隐私政策有任何疑问，请联系 PT. Uni-Metaltech Industry (UMI Stamping)，Kara Industrial Park Block - C 05 No. 01, Batam Center 29432, Indonesia。电话 +62 778 464141。邮箱 info@umistamping.com。']],
                ],
            ],
        ],
    ],

    'terms' => [
        'seo' => [
            'title' => '服务条款 — UMI Stamping',
            'description' => '规范 UMI Stamping 网站与制造服务使用的条款与条件。',
        ],
        'hero' => [
            'eyebrow' => '法律',
            'title' => '服务条款。',
            'lead' => '规范我们网站与制造服务使用的条款与条件。',
        ],
        'sections' => [
            [
                'type' => 'legal',
                'clauses' => [
                    ['heading' => '条款的接受', 'body' => ['访问并使用 UMI Stamping 网站，即表示您接受并同意受本服务条款约束。如您不同意这些条款，请勿使用我们的网站。']],
                    ['heading' => '服务', 'body' => ['PT. Uni-Metaltech Industry (UMI Stamping) 提供精密金属冲压、模具、焊接与组装服务。本网站所载信息仅供一般参考，不构成服务要约或合同。']],
                    ['heading' => '知识产权', 'body' => ['本网站的所有内容，包括文字、图形、标识、图像与软件，均属 PT. Uni-Metaltech Industry 的财产，并受知识产权法律保护。未经事先书面许可，您不得复制、分发或使用任何内容。']],
                    ['heading' => '报价与订单', 'body' => ['UMI Stamping 提供的所有报价均可能因材料成本、设计变更及订单数量而变动。订单的接受以我们的标准销售条款与条件为准，该等条款将随正式报价一并提供。']],
                    ['heading' => '责任限制', 'body' => ['对于因使用我们的网站或服务而产生的任何间接、附带或后果性损害，UMI Stamping 概不承担责任。我们的全部责任以所提供服务的价值为限。']],
                    ['heading' => '适用法律', 'body' => ['本服务条款受印度尼西亚共和国法律管辖。任何争议应在对印度尼西亚 Batam 具有管辖权的法院解决。']],
                    ['heading' => '联系方式', 'body' => ['如对本服务条款有任何疑问，请联系 PT. Uni-Metaltech Industry (UMI Stamping)，Kara Industrial Park Block - C 05 No. 01, Batam Center 29432, Indonesia。电话 +62 778 464141。邮箱 info@umistamping.com。']],
                ],
            ],
        ],
    ],

];
