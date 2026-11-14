#!/usr/bin/env bash
# ac41_callsites.sh - AC-41 breakpoint/media-query contract, inventory-keyed.
#
# Same calling convention as the AC-41 gate it replaces:
#     bash tools/ac41_callsites.sh [TREE]        # default TREE=/reference/umi-nextjs
# Exit: 0 PASS · 1 FAIL · 2 precondition. See ac41_callsites.cjs for the rules,
# the four verification dimensions, and which mutation each failure mode catches.
#
# The implementation is `.cjs` on purpose: package.json declares "type": "module",
# so a `.js` sibling would be loaded as ESM and `require` would fail.
set -uo pipefail
HERE=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)
TREE=${1:-/reference/umi-nextjs}
if [ "$#" -gt 0 ]; then shift; fi
exec node "$HERE/ac41_callsites.cjs" "$TREE" "$@"
