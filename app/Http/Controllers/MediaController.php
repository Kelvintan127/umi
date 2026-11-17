<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Streams the web-sized company profile asset with byte-range support so
 * browsers can seek and start playback without downloading the complete file.
 */
class MediaController extends Controller
{
    public function companyProfile(Request $request): StreamedResponse
    {
        $path = public_path('videos/company-profile-web-480.mp4');

        abort_unless(is_file($path) && is_readable($path), 404);

        $size = filesize($path);
        $range = $this->parseRange($request->header('Range'), $size);

        if ($range === null) {
            $start = 0;
            $end = $size - 1;
            $status = 200;
        } else {
            [$start, $end] = $range;
            $status = 206;
        }

        $length = $end - $start + 1;

        return response()->stream(function () use ($path, $start, $length): void {
            $handle = fopen($path, 'rb');

            if ($handle === false) {
                return;
            }

            try {
                fseek($handle, $start);

                $remaining = $length;
                while ($remaining > 0 && !feof($handle)) {
                    $chunk = fread($handle, min(1024 * 1024, $remaining));

                    if ($chunk === false || $chunk === '') {
                        break;
                    }

                    echo $chunk;
                    flush();
                    $remaining -= strlen($chunk);
                }
            } finally {
                fclose($handle);
            }
        }, $status, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => (string) $length,
            'Accept-Ranges' => 'bytes',
            'Content-Range' => $status === 206 ? "bytes {$start}-{$end}/{$size}" : null,
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    /**
     * @return array{int, int}|null
     */
    private function parseRange(?string $header, int $size): ?array
    {
        if ($header === null || !preg_match('/bytes=(\d*)-(\d*)/', $header, $matches)) {
            return null;
        }

        $requestedStart = $matches[1] === '' ? null : (int) $matches[1];
        $requestedEnd = $matches[2] === '' ? null : (int) $matches[2];

        if ($requestedStart === null) {
            $length = $requestedEnd ?? 0;
            $start = max(0, $size - $length);
            $end = $size - 1;
        } else {
            $start = $requestedStart;
            $end = $requestedEnd ?? ($size - 1);
        }

        if ($start < 0 || $start >= $size || $end < $start) {
            abort(416, 'Requested range not satisfiable', [
                'Content-Range' => "bytes */{$size}",
            ]);
        }

        return [$start, min($end, $size - 1)];
    }
}
