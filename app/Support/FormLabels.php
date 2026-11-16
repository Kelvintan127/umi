<?php

namespace App\Support;

/**
 * Flattens lang/{locale}/forms.php into the shape ContactForm.tsx takes.
 *
 * Done here rather than in JSX so the component has no nested lookups and a
 * missing key is a PHP-visible `null`, not a silent `undefined` in the render.
 */
final class FormLabels
{
    /**
     * @return array<string, mixed>
     */
    public static function for(string $locale): array
    {
        $t = (array) trans('forms', [], $locale);
        $fields = (array) ($t['fields'] ?? []);

        return [
            'title' => $t['title'] ?? '',
            'intro' => $t['intro'] ?? '',
            'fields' => [
                'name' => $fields['name'] ?? '',
                'company' => $fields['company'] ?? '',
                'email' => $fields['email'] ?? '',
                'phone' => $fields['phone'] ?? '',
                'inquiryType' => $fields['inquiry_type'] ?? '',
                'message' => $fields['message'] ?? '',
            ],
            'placeholders' => (array) ($t['placeholders'] ?? []),
            'inquiryTypes' => (array) ($t['inquiry_types'] ?? []),
            'submit' => $t['submit'] ?? '',
            'submitting' => $t['submitting'] ?? '',
            'successTitle' => $t['success_title'] ?? '',
            'successBody' => $t['success_body'] ?? '',
            'successAgain' => $t['success_again'] ?? '',
            'errorsTitle' => $t['errors']['title'] ?? '',
            'consent' => $t['consent'] ?? '',
            'privacy' => trans('site.footer.privacy', [], $locale),
        ];
    }
}
