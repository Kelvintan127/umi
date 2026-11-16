<?php

namespace App\Support;

/**
 * Approval gate for third-party names and claims.
 *
 * Customer names, attributed testimonials and logos are statements about other
 * companies. Publishing them needs their permission, not just ours, and a name
 * appearing on an older version of the site is not that permission. So the site
 * publishes only what config/approvals.php marks approved, and absence is
 * treated as "not approved" rather than "presumably fine".
 *
 * The components for both remain in the codebase — they render whatever passes
 * the gate. Filtering here rather than deleting the components means approving a
 * customer later is a config change, and it keeps the render path exercised by
 * tests while the list is empty.
 */
final class Approvals
{
    /**
     * Customers cleared for publication, preserving the configured order.
     *
     * @return list<array{name: string, relationship: string}>
     */
    public static function customers(): array
    {
        $out = [];

        foreach ((array) config('approvals.customers', []) as $row) {
            if (! is_array($row) || ($row['approved'] ?? false) !== true) {
                continue;
            }

            $out[] = [
                'name' => (string) ($row['name'] ?? ''),
                'relationship' => (string) ($row['relationship'] ?? 'direct'),
            ];
        }

        return $out;
    }

    /**
     * Approved testimonials, in configured order.
     *
     * A quote is additionally withheld when its attributed name is itself
     * unapproved: publishing an endorsement from a company whose name we may
     * not publish is incoherent, so the stricter gate wins.
     *
     * @return list<array{name: string, period: string}>
     */
    public static function testimonials(): array
    {
        $approvedNames = array_column(self::customers(), 'name');
        $out = [];

        foreach ((array) config('approvals.testimonials', []) as $row) {
            if (! is_array($row) || ($row['approved'] ?? false) !== true) {
                continue;
            }

            $name = (string) ($row['name'] ?? '');

            // A testimonial whose subject is not itself cleared is withheld.
            // The check must run even when nothing is approved: an empty
            // approved list means "no company may be named", and short-circuiting
            // on emptiness would let every quote through unopposed.
            if (! in_array($name, $approvedNames, true)) {
                continue;
            }

            $out[] = [
                'name' => $name,
                'period' => (string) ($row['period'] ?? ''),
            ];
        }

        return $out;
    }

    /**
     * How many entries are held back, so a page can say so instead of silently
     * rendering an empty section that looks like a design bug.
     */
    public static function withheldCount(string $group): int
    {
        $total = count((array) config('approvals.'.$group, []));
        $shown = match ($group) {
            'customers' => count(self::customers()),
            'testimonials' => count(self::testimonials()),
            default => 0,
        };

        return max(0, $total - $shown);
    }

    /**
     * True when anything in this group is still pending. Used to decide whether
     * the page shows a "list available on request" note.
     */
    public static function hasWithheld(string $group): bool
    {
        return self::withheldCount($group) > 0;
    }
}
