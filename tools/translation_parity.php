<?php

/**
 * Key-parity check between the English source locale and a target locale.
 *
 *   php tools/translation_parity.php id
 *
 * Prints every key present in lang/en/*.php but missing from lang/{locale}/, and
 * every key the target has that English does not (structure drift). Exit 1 when
 * either list is non-empty, so it can gate a commit.
 *
 * Keys are compared, not values: a translation is allowed — expected — to have
 * different text. What it may not have is a different shape, because the React
 * components index into these arrays by key.
 */

$locale = $argv[1] ?? null;

if ($locale === null || ! preg_match('/^[a-z]{2}$/', $locale)) {
    fwrite(STDERR, "usage: php tools/translation_parity.php <two-letter-locale>\n");
    exit(2);
}

$root = dirname(__DIR__);
$source = $root.'/lang/en';
$target = $root.'/lang/'.$locale;

if (! is_dir($target)) {
    fwrite(STDERR, "missing locale directory: lang/{$locale}\n");
    exit(2);
}

/**
 * @return array<string, true> flattened dot-notation key paths
 */
function flatten(array $data, string $prefix = ''): array
{
    $out = [];

    foreach ($data as $key => $value) {
        $path = $prefix === '' ? (string) $key : $prefix.'.'.$key;

        if (is_array($value)) {
            $out += flatten($value, $path);
        } else {
            $out[$path] = true;
        }
    }

    return $out;
}

$failures = 0;

foreach (glob($source.'/*.php') as $file) {
    $name = basename($file);
    $targetFile = $target.'/'.$name;

    if (! is_file($targetFile)) {
        printf("%-14s MISSING FILE\n", $name);
        $failures++;

        continue;
    }

    $en = flatten(require $file);
    $tr = flatten(require $targetFile);

    $missing = array_diff_key($en, $tr);
    $extra = array_diff_key($tr, $en);

    if ($missing === [] && $extra === []) {
        printf("%-14s OK  %d keys\n", $name, count($en));

        continue;
    }

    printf("%-14s FAIL  missing=%d extra=%d\n", $name, count($missing), count($extra));
    foreach (array_slice(array_keys($missing), 0, 12) as $key) {
        echo "    missing: {$key}\n";
    }
    foreach (array_slice(array_keys($extra), 0, 12) as $key) {
        echo "    extra:   {$key}\n";
    }

    $failures++;
}

echo $failures === 0 ? "\nparity OK for {$locale}\n" : "\n{$failures} file(s) out of parity for {$locale}\n";

exit($failures === 0 ? 0 : 1);
