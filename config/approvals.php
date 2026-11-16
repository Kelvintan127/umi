<?php

/*
|--------------------------------------------------------------------------
| Approval-Controlled Content
|--------------------------------------------------------------------------
|
| Customer names, attributed testimonials and performance claims are not
| facts the site owns — they are statements about third parties. Publication
| on the old website does not establish permission for continued use, so
| every name starts here as unapproved and is filtered out of the rendered
| page until someone with authority marks it.
|
| This is the same fail-closed shape as config/locales.php: absent means
| unapproved, an empty approval list publishes nothing, and silence never
| publishes. Rendering an unapproved name is the bug this file prevents.
|
| To approve: set the value to true AND record when and by whom in the
| 'signed_off' block below. A bare true with no attribution is not a record
| of permission, and tests/Feature/ContentApprovalTest.php does not check
| for one — that judgement is deliberately human.
|
*/

return [

    /*
    | Customer names carried from the company's published customer list.
    |
    | 'relationship' distinguishes a customer UMI invoices directly from an
    | end-product brand reached indirectly through a contract manufacturer.
    | The distinction matters: listing an indirect brand beside direct
    | customers implies a commercial relationship UMI may not have.
    |
    | 'approved' gates publication. All false until permission is confirmed.
    */

    'customers' => [
        ['name' => 'Sanyo Energy Batam', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'Panasonic', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'Digi', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'Patlite', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'OrieX', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'Foster Electric', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'Wellington', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'WIK', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'HW Genting', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'Valeo', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'SIIX', 'relationship' => 'direct', 'approved' => false],
        ['name' => 'Hitachi', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'Apple', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'BlackBerry', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'Kenwood', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'Dell', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'JVC', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'Nokia', 'relationship' => 'indirect', 'approved' => false],
        ['name' => 'Kyocera', 'relationship' => 'indirect', 'approved' => false],
    ],

    /*
    | Attributed acknowledgements. Published on the old site, which is not the
    | same as UMI holding the award letter behind each quote. Both start
    | unapproved, so neither renders until someone confirms the source
    | document exists.
    */

    'testimonials' => [
        ['name' => 'Foster Electric', 'period' => '2013–2015', 'approved' => false],
        ['name' => 'Sanyo Energy Batam', 'period' => 'Since 2000', 'approved' => false],
    ],

    /*
    | Record of who approved what. Populate alongside a true 'approved' flag
    | above. Empty means nothing has been approved by anyone, which is the
    | truthful current state.
    */

    'signed_off' => [
        // 'Foster Electric' => ['by' => '...', 'on' => '2026-01-15', 'basis' => 'written permission, ref ...'],
    ],

];
