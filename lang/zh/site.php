<?php

/*
|--------------------------------------------------------------------------
| Kelengkapan situs, data bersama, dan konten terstruktur (简体中文) —
| UNREVIEWED zh draft; NOT company-approved; not served until the company
| adds the locale code in config/locales.php; English source is
| authoritative.
|--------------------------------------------------------------------------
|
| 未经公司审阅的翻译草稿。所有字符串均取自 lang/en/site.php；未新增任何
| 声明、认证、客户或数字。品牌标识（UMI、PT. Uni-Metaltech Industry、
| ISO 9001:2015、ISO 14001:2015、SMETA、设备品牌、客户名称）保持原文。
|
| 说明：客户评价的引述文字由英文材料翻译而来，源文件中没有原始引文，
| 上线前需核实。
|
*/

return [

    'meta' => [
        'company' => 'PT. Uni-Metaltech Industry',
        'short' => 'UMI Stamping',
        'founded' => '2000',
        'tagline' => '精密金属冲压与制造',
        'description' => '面向汽车、电子和工业应用的精密金属冲压与制造解决方案。',
    ],

    'nav' => [
        'home' => '首页',
        'about' => '关于我们',
        'capabilities' => '制造能力',
        'products' => '产品',
        'facilities' => '设备与厂房',
        'industries' => '应用行业',
        'quality' => '质量保证',
        'contact' => '联系我们',
    ],

    'cta' => [
        'contact' => '联系我们',
        'quote' => '获取报价',
        'capabilities' => '了解制造能力',
        'team' => '联系我们的团队',
        'project' => '洽谈您的项目',
    ],

    /*
     * 页面结尾的统一行动号召，集中放置以便一次性修改。
     */
    'cta_block' => [
        'title' => '有零件需要加工吗？',
        'lead' => '请告诉我们您正在开发的产品。我们的工程与制造团队可以协助将您的需求转化为可靠的生产方案。',
    ],

    'contact_page' => [
        'locations_eyebrow' => '地点',
        'locations_title' => '两个地点，同一标准。',
        'email' => '电子邮箱',
        'phone' => '电话',
        'location' => '地址',
        'view_map' => '在地图上查看',
    ],

    'nav_aria' => [
        'open' => '打开导航',
        'close' => '关闭导航',
        'primary' => '主导航',
        'footer' => '页脚',
        'breadcrumb' => '面包屑导航',
        'language' => '语言',
        'skip' => '跳转到主要内容',
    ],

    'footer' => [
        'blurb' => 'PT. Uni-Metaltech Industry — 自 2000 年起提供精密金属冲压与制造解决方案。印度尼西亚巴淡岛。',
        'company' => '公司',
        'resources' => '资源',
        'rights' => '版权所有。',
        'privacy' => '隐私政策',
        'terms' => '服务条款',
        'links' => [
            'company_section' => [
                'about' => '关于我们',
                'company-profile' => '公司简介',
                'capabilities' => '制造能力',
                'products' => '产品',
            ],
            'resources_section' => [
                'quality' => '质量保证',
                'certifications' => '认证',
                'facilities' => '设备与厂房',
                'contact' => '联系我们',
            ],
        ],
    ],

    'stats' => [
        ['value' => '25+', 'label' => '年行业经验'],
        ['value' => '3,000', 'label' => '平方米厂房面积'],
        ['value' => '0.10', 'label' => '最小材料厚度（mm）'],
        ['value' => '15–160', 'label' => '吨位冲压机范围'],
    ],

    'capabilities' => [
        [
            'title' => '金属冲压',
            'category' => '核心制造',
            'description' => '为复杂且要求严苛的零件提供高精度金属冲压解决方案，可冲压厚度低至 0.10 mm 的材料。',
            'image' => '/images/capabilities/metal-stamping.jpg',
        ],
        [
            'title' => '模具',
            'category' => '精密工装',
            'description' => '具备 CNC 线切割、NC 电火花和磨削能力的厂内工装设计与制造，交货周期短。',
            'image' => '/images/capabilities/tool-die.jpg',
        ],
        [
            'title' => '焊接',
            'category' => '二次加工',
            'description' => '点焊及其他焊接工艺由厂内完成，作为增值服务提供完整的制造支持。',
            'image' => '/images/capabilities/welding.jpg',
        ],
        [
            'title' => '组装',
            'category' => '增值服务',
            'description' => '机械组装包括攻丝、reverting 和点焊，为客户提供更全面的服务。',
            'image' => '/images/capabilities/assembly.jpg',
        ],
    ],

    'industries' => [
        [
            'title' => '汽车',
            'description' => '为要求严苛的汽车应用而设计的精密零件与组件，其中一致性、耐久性和尺寸精度至关重要。',
            'image' => '/images/industries/automotive.jpg',
        ],
        [
            'title' => '电子',
            'description' => '为电子应用制造的高精度零件，要求严格公差、可重复性以及可靠的生产表现。',
            'image' => '/images/industries/electronics.jpg',
        ],
        [
            'title' => '工业',
            'description' => '面向工业应用的稳健制造方案，将工程专业能力与可规模化、稳定一致的生产相结合。',
            'image' => '/images/industries/industrial.jpg',
        ],
        [
            'title' => '消费品',
            'description' => '支持消费类产品的可靠金属零件与组件，兼顾设计、精密与制造效率。',
            'image' => '/images/industries/consumer.jpg',
        ],
    ],

    'process' => [
        ['title' => '工程', 'description' => '产品分析、设计评审与制造可行性评估。'],
        ['title' => '工装', 'description' => '按生产需求开发精密模具与工装。'],
        ['title' => '冲压', 'description' => '使用高精度冲压设备进行受控生产。'],
        ['title' => '检验', 'description' => '质量检验与尺寸验证。'],
        ['title' => '组装', 'description' => '整合二次工序与零件组装。'],
        ['title' => '交付', 'description' => '安全包装并可靠交付客户。'],
    ],

    'quality' => [
        'principles' => [
            ['title' => '精密', 'description' => '每个零件在制造时都严格关注尺寸精度、规格与生产要求。'],
            ['title' => '一致性', 'description' => '结构化的制造流程有助于在整个生产过程中保持可靠且可重复的结果。'],
            ['title' => '可追溯性', 'description' => '生产与质量流程由系统化的文档记录与监控支持。'],
            ['title' => '可靠性', 'description' => '质量贯穿整个制造流程，以支持长期可靠的性能表现。'],
        ],
        'labelling' => '本页面显示的认证状态摘自公司已发布的材料，证书编号、发证机构与有效期仍有待公司再次确认。',
    ],

    'certifications' => [
        [
            'name' => 'ISO 9001:2015',
            'title' => '质量管理体系',
            'description' => '自 2000 年起依据 ISO 9001:2015 获得认证。内部与外部审核确保我们的制造管理体系得到定期评审与更新，以维持运营能力并持续提升产品质量。',
            'image' => '/images/certifications/iso-9001.jpg',
        ],
        [
            'name' => 'ISO 14001:2015',
            'title' => '环境管理体系',
            'description' => '已通过 ISO 14001:2015 认证。我们承诺在生产过程中防止污染、减少废弃物、遵守法规并降低能源消耗。',
            'image' => '/images/certifications/iso-14001.jpg',
        ],
        [
            'name' => 'SMETA',
            'title' => '商业道德审核',
            'description' => '经 SMETA 审核，体现我们对商业道德实践、负责任采购以及运营与供应链持续改进的承诺。',
            'image' => '/images/certifications/smeta.jpg',
        ],
    ],

    'policy' => [
        'heading' => '质量与环境方针',
        'intro' => '我们承诺：',
        'items' => [
            '提供满足客户要求的高品质金属冲压产品。',
            '防止生产过程中的环境污染并减少废弃物。',
            '遵守所有适用的法律、法规及其他环境要求。',
            '降低能源消耗并提升资源利用效率。',
            '识别并应对可能影响我们运营的气候变化风险与机遇。',
            '提升员工在质量与环境保护方面的能力与意识。',
            '持续改进质量与环境管理体系的有效性。',
        ],
    ],

    'products' => [
        [
            'key' => 'battery-contacts',
            'title' => '电池触点',
            'description' => '广泛应用于电子器具、电池组和便携式电子设备的电池触点。',
            'image' => '/images/products/battery-contacts.jpg',
        ],
        [
            'key' => 'wire-harnessing',
            'title' => '线束加工 / 接线端子',
            'description' => '用于线束加工应用的接线端子，服务于电气与汽车行业。',
            'image' => '/images/products/wire-harnessing.jpg',
        ],
        [
            'key' => 'ods-dvd-drive',
            'title' => 'ODS DVD Drive',
            'description' => '用于光盘驱动器组件的精密冲压零件，按严格的尺寸要求生产。',
            'image' => '/images/products/ods-dvd-drive.jpg',
        ],
        [
            'key' => 'mechanical-assembly',
            'title' => '机械组装',
            'description' => '增值服务，包括攻丝、reverting 和点焊，由厂内完成以提供更全面的服务。',
            'image' => '/images/products/mechanical-assembly.jpg',
        ],
        [
            'key' => 'electrical-metal-parts',
            'title' => '电气及其他金属零件',
            'description' => '用于电脑、打印机、电话、MCB、电源、照明设备和 UPS 应用的金属零件。',
            'image' => '/images/products/electrical-metal-parts.jpg',
        ],
    ],

    'facilities' => [
        [
            'key' => 'production-machines',
            'title' => '生产设备',
            'summary' => '生产设备包括日本和台湾制造的 15 至 160 吨冲床，配备机械滚轮送料、气动送料与 NC 送料装置。',
            'specs' => [
                'C 型冲床，15–160 吨：Seyi、Aida、Amada',
                '高速冲床，15–60 吨：Yamada Dobby、Amada、Seyi、ISIS',
                '自动切割、攻丝及 reverting 设备',
                '手动冲床',
            ],
            'image' => '/images/facilities/production-machines.jpg',
        ],
        [
            'key' => 'supporting-machines',
            'title' => '辅助设备',
            'summary' => '完整的厂内工装部门通过持续的设备投入，保持较低的工装成本与较短的交期。',
            'specs' => [
                'CNC WireCut：Sodick、Mitsubishi',
                'NC EDM：SEIKI',
                'NC Superdrill：SEIKI',
                '磨床：Okamoto、Equiptop',
                'CNC 铣床：Hurco',
                'LX-A1 便携式激光打标机',
            ],
            'image' => '/images/facilities/supporting-machines.jpg',
        ],
        [
            'key' => 'tools-design-storage',
            'title' => '模具设计与存放',
            'summary' => '我们的工程团队在本地设计和制造模具，交期短；高端模具由新加坡和马来西亚提供支持。',
            'specs' => [
                '厂内模具设计与制造',
                '必要情况下在批量生产模具之前进行样件试制',
                '规范的工装存放与维护',
                '高端工装模具由新加坡和马来西亚采购',
            ],
            'image' => '/images/facilities/tools-design-storage.jpg',
        ],
        [
            'key' => 'measurement-equipment',
            'title' => '测量设备',
            'summary' => '高精度质量保证设备确保只交付高品质零件；校准由内部与外部机构执行。',
            'specs' => [
                '光学测量（VS）',
                '投影仪：Mitutoyo',
                '高度规：Mitutoyo',
                '销规、块规',
                '游标卡尺、千分尺',
            ],
            'image' => '/images/facilities/measurement-equipment.jpg',
        ],
    ],

    'metal_part_users' => [
        'intro' => 'UMI 为电气、电子和汽车行业的制造商供应金属零件。以下公司名单摘自公司已发布的客户清单。',
        'users' => [
            'Sanyo Energy Batam', 'Panasonic', 'Digi', 'Patlite', 'OrieX',
            'Foster Electric', 'Wellington', 'WIK', 'HW Genting', 'Valeo', 'SIIX',
            'Hitachi', 'Apple', 'BlackBerry', 'Kenwood', 'Dell', 'JVC', 'Nokia', 'Kyocera',
        ],
        'testimonials' => [
            ['name' => 'Foster Electric', 'period' => '2013–2015', 'quote' => '2013–2015 年度实现“零退货”与“零索赔”。'],
            ['name' => 'Sanyo Energy Batam', 'period' => '自 2000 年起', 'quote' => '自 2000 年以来，因品质优良与支持出色而获得的优秀服务表彰。'],
        ],
        'note' => '客户名称与引述的评价由公司自行决定发布；内容摘自公司现有材料，本页面未对其进行独立核实。',
    ],

    'contact' => [
        'batam' => [
            'label' => '制造工厂（Batam）',
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
            'label' => '销售代表处（Jakarta）',
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
        ['title' => '生产车间', 'label' => '生产环境', 'image' => '/images/gallery/factory-01.jpg'],
        ['title' => '精密设备', 'label' => '生产设备', 'image' => '/images/gallery/machine-01.jpg'],
        ['title' => '生产过程', 'label' => '制造能力', 'image' => '/images/gallery/product-01.jpg'],
        ['title' => '工程细节', 'label' => '精密制造', 'image' => '/images/gallery/team-01.jpg'],
    ],

    'news' => [
        ['date' => '2024', 'title' => 'UMI Stamping 公司简介', 'excerpt' => '概述我们在印度尼西亚巴淡岛的制造工厂、制造能力与质量体系。'],
        ['date' => '2024', 'title' => '模具制造能力', 'excerpt' => '厂内模具设计与制造，配备 CNC WireCut、NC EDM 与磨削，交货周期短。'],
        ['date' => '2024', 'title' => '质量与认证', 'excerpt' => '我们的管理体系通过内部与外部审核定期评审。'],
    ],

    'language' => [
        'label' => '语言',
        'en' => 'English',
        'id' => 'Bahasa Indonesia',
        'zh' => '简体中文',
        'unavailable' => '译文待公司确认 — 本页面目前以英文提供。',
    ],

    /*
     * 在翻译语种中必须与英文不同的字符串。不用于渲染：仅作为完整性
     * 检查的取样。
     */
    'i18n_probe' => [
        'nav' => '关于我们',
        'hero_title' => '关于 UMI',
        'cta' => '联系我们',
        'policy' => '我们承诺：',
    ],

];
