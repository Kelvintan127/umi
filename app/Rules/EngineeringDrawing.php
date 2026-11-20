<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Private RFQ engineering documents. A filename extension by itself is not
 * proof of type: verify elementary file signatures before storage or mailing.
 * This is not a malware scanner and must not be represented as one.
 */
final class EngineeringDrawing implements ValidationRule
{
    private const EXTENSIONS = ['pdf', 'dwg', 'dxf', 'step', 'stp', 'iges', 'igs'];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            $fail('The engineering drawing could not be uploaded.');
            return;
        }

        $ext = strtolower($value->getClientOriginalExtension());
        if (! in_array($ext, self::EXTENSIONS, true)) {
            $fail('Only PDF, DWG, DXF, STEP, and IGES drawings are accepted.');
            return;
        }

        $stream = @fopen($value->getRealPath(), 'rb');
        if ($stream === false) {
            $fail('The drawing could not be read.');
            return;
        }
        $header = (string) fread($stream, 4096);
        fclose($stream);

        $valid = match ($ext) {
            'pdf' => str_starts_with($header, '%PDF-'),
            'dwg' => (bool) preg_match('/^AC10\d{2}/', $header),
            'dxf' => (bool) preg_match('/^\xEF\xBB\xBF?\s*0\s+SECTION\b/i', $header)
                || (bool) preg_match('/^\s*0\s+SECTION\b/i', $header),
            'stp', 'step' => str_contains(substr($header, 0, 256), 'ISO-10303-21'),
            'igs', 'iges' => (bool) preg_match('/^.{72}[SGDPT]\s*\d+/m', $header),
            default => false,
        };
        if (! $valid) {
            $fail('The drawing contents do not match the stated file format.');
        }
    }
}
