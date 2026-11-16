<?php

/*
|--------------------------------------------------------------------------
| 联系表单（简体中文）——
| UNREVIEWED zh draft; NOT company-approved; not served until the company
| adds the locale code in config/locales.php; English source is
| authoritative.
|--------------------------------------------------------------------------
|
| 未经公司审阅的翻译草稿。键结构与 lang/en/forms.php 完全一致，仅翻译取值。
| 电子邮箱地址、电话号码与 'PT. Uni-Metaltech Industry' 保持原文。
|
*/

return [

    'title' => '请告诉我们您的项目详情',
    'intro' => '标有 * 的字段为必填项。',

    'fields' => [
        'name' => '姓名',
        'company' => '公司',
        'email' => '电子邮箱',
        'phone' => '电话',
        'inquiry_type' => '咨询类型',
        'message' => '项目详情',
    ],

    'placeholders' => [
        'name' => '张伟',
        'company' => '公司名称',
        'email' => 'john@company.com',
        'phone' => '+62 ...',
        'message' => '请介绍您的项目 — 材料、数量、公差、时间安排……',
    ],

    'inquiry_types' => [
        'new-project' => '新项目',
        'engineering' => '工程技术',
        'partnership' => '合作',
        'other' => '其他',
    ],

    'submit' => '发送咨询',
    'submitting' => '正在发送……',
    'success_title' => '感谢您的咨询',
    'success_body' => '您的信息已记录，我们的团队将尽快与您联系。',
    'success_again' => '再发送一条信息',

    'ack_subject' => '我们已收到您的咨询 — PT. Uni-Metaltech Industry',
    'ack_body' => '感谢您联系 PT. Uni-Metaltech Industry。我们的团队已收到您的咨询，将尽快回复。',
    'internal_body' => '网站收到一条新的咨询。',

    'errors' => [
        'title' => '请检查表单内容',
        'generic' => '咨询未能发送，请重试。',
        'throttled' => '此连接提交的咨询过多，请在一分钟后重试。',
    ],

    'consent' => '提交本咨询即表示您同意我们使用所提供的信息来回复您的请求。',

];
