#!/usr/bin/env node
/*
 * ac41_callsites.js — AC-41 breakpoint contract, inventory-keyed (ENG-007).
 * ────────────────────────────────────────────────────────────────────────────
 * Run through the wrapper so the calling convention matches the AC-41 gate this
 * replaces:
 *     bash tools/ac41_callsites.sh [TREE]        # default TREE=/reference/umi-nextjs
 *     node tools/ac41_callsites.cjs TREE [--json] [--suggest]
 * Exit codes: 0 PASS · 1 FAIL · 2 precondition (no TypeScript / no inventory / bad tree).
 * (The file is `.cjs` because package.json declares "type": "module"; a `.js` sibling
 * would load as ESM and `require` would be undefined.)
 *
 * WHY THIS EXISTS
 * ---------------
 * The previous criterion pinned condition STRINGS with a `>=` count. QA-004 §4
 * and ENG-006 P-6 both proved it passes a tree carrying an EXTRA call site of a
 * known condition in a known file, because a count only ever goes up. This gate
 * keys on an explicit, version-controlled inventory
 * (`ac41_callsites.inventory.json`, reviewed as its own diff) so an extra
 * occurrence is a failure instead of a silent pass.
 *
 * WHAT A "QUALIFYING CALL SITE" IS — syntax-aware, not regex
 * ---------------------------------------------------------
 * Every `.ts`/`.tsx` under `src/` is parsed with the TypeScript compiler API
 * (`ts.createSourceFile`). A qualifying site is:
 *   a) a CallExpression whose callee is `matchMedia` / `window.matchMedia` /
 *      `globalThis.matchMedia` (any `X.matchMedia`) WITH AT LEAST ONE ARGUMENT, i.e.
 *      it actually declares a condition; or
 *   b) the conditions call `X.add({...})` / `X.addAll({...})` where `X` is
 *      `gsap.matchMedia()` or a local identifier bound to it
 *      (`const mm = gsap.matchMedia(); mm.add({...})` — resolved through the
 *      binding, so the alias name is free to change).
 * A zero-argument `X.matchMedia()` is a FACTORY, not a site: it carries no
 * condition. It is still recognised, because that is how the alias in (b) is
 * resolved. Factories are listed in the output for transparency and are
 * deliberately not inventory entries — see "what a factory call is not" below.
 *
 * An AST is used rather than a line regex because the facts the contract depends
 * on are exactly the ones a line regex gets wrong:
 *   - `sizes="(max-width: 1024px) 100vw"` is an <Image> srcset hint, not a query.
 *     In the AST that is a JSX attribute, never a CallExpression, so the old
 *     gate's "blank the `sizes=` spans first" regex hack is unnecessary here.
 *   - a call split over several lines is one site; a one-line regex misses it,
 *     and the old gate reported hero-video.tsx's condition on line 10 when the
 *     call starts on line 9.
 *   - the ENCLOSING SYMBOL, part of the inventory key, is only knowable from the
 *     tree shape.
 * The only regex used is for the condition string inside an argument that the
 * AST has already located — genuinely equivalent to a syntax-aware match at that
 * point, because the argument's shape is already known.
 *
 * TWO INDEPENDENT PASSES, WHICH MUST AGREE
 * ----------------------------------------
 *   (I)  INVENTORY PASS — site-keyed: file + enclosing symbol + method +
 *        canonical arguments + permitted occurrence count. Produces D1–D4.
 *   (II) REQUIREMENT PASS — condition-keyed: each width condition AC-41's
 *        requirement names, with its required total, and no condition that the
 *        requirement does not name. This is the old gate's view of the world,
 *        kept as a second, independent reading of the same tree.
 * The inventory is derived from the REQUIREMENT (the `conditions` block states
 * the requirement's own numbers), not from whatever the tree contains. A tree
 * that disagrees with the requirement therefore fails pass (II) even if somebody
 * encoded that tree into the inventory, and the two passes disagreeing is itself
 * printed as a finding.
 *
 * FOUR VERIFICATION DIMENSIONS — each reported as its own outcome
 * ---------------------------------------------------------------
 *   D1 missing     inventory entry with no matching site in the tree.
 *                  Caught by: deleting the approved call site, or the block
 *                  containing it.
 *   D2 unexpected  qualifying site with no inventory entry, or a width condition
 *                  no requirement entry names.
 *                  Caught by: an invented breakpoint, a call site in a new file,
 *                  a call site in a new function of a known file, or a 4th
 *                  condition added to an existing conditions object.
 *   D3 excess      site present more times than its entry permits.
 *                  Caught by: a SECOND copy of an approved call site — same file,
 *                  same symbol, same method, same arguments. This is precisely
 *                  the mutant the `>=` gate passed.
 *   D4 changed     a site still at an approved location but structurally
 *                  different: arguments changed, enclosing symbol changed, or
 *                  call method changed. Needs a reviewed inventory update.
 *
 * Mutation each failure mode catches, in one line each:
 *   D1 → mutant "remove a site"  · D2 → mutant "add a 4th qualifying site"
 *   D3 → mutant "duplicate an approved site"  · D4 → mutant "change arguments"
 *   parse error → mutant "unparseable source" (a false PASS is worse than FAIL)
 *
 * THE INVENTORY IS READ, NEVER WRITTEN, AND NEVER REGENERATED HERE — that is what
 * keeps the check from being tautological. `--suggest` prints candidate entries
 * for a human to copy in by hand; the PASS/FAIL path never calls it.
 */
"use strict";

const fs = require("fs");
const path = require("path");
const crypto = require("crypto");

const HERE = __dirname;
const INVENTORY_PATH =
  process.env.AC41_INVENTORY || path.join(HERE, "ac41_callsites.inventory.json");

const DIM = {
  missing: "D1 missing",
  unexpected: "D2 unexpected",
  excess: "D3 excess",
  changed: "D4 changed",
};

function die(code, msg) {
  process.stderr.write("ac41: " + msg + "\n");
  process.exit(code);
}

/* ------------------------------------------------------------------ argv -- */

const argv = process.argv.slice(2);
let tree = null;
let asJson = false;
let suggest = false;
for (const a of argv) {
  if (a === "--json") asJson = true;
  else if (a === "--suggest") suggest = true;
  else if (a.startsWith("-")) die(2, "unknown flag " + a);
  else if (!tree) tree = a;
  else die(2, "unexpected argument " + a);
}
tree = path.resolve(tree || "/reference/umi-nextjs");
if (!fs.existsSync(tree)) die(2, "tree does not exist: " + tree);
const SRC = path.join(tree, "src");
if (!fs.existsSync(SRC)) die(2, "no src/ directory in tree: " + tree);

/* ------------------------------------------------------ TypeScript API -- */

function loadTs() {
  const candidates = [
    process.env.AC41_TSC,
    path.join(tree, "node_modules", "typescript"),
    path.join(HERE, "..", "node_modules", "typescript"),
    "/work/laravel-app/node_modules/typescript",
    "typescript",
  ].filter(Boolean);
  for (const c of candidates) {
    try {
      return { ts: require(c), from: c };
    } catch (e) {
      /* try the next candidate */
    }
  }
  return null;
}
const loaded = loadTs();
if (!loaded) {
  die(
    2,
    "no TypeScript compiler API found. A `typescript` package is required; set " +
      "AC41_TSC=/path/to/node_modules/typescript. Refusing to fall back to regex " +
      "matching: an AST was chosen because regex is not equivalent here."
  );
}
const ts = loaded.ts;

/* --------------------------------------------------------------- helpers -- */

function walk(dir, out) {
  for (const e of fs.readdirSync(dir, { withFileTypes: true })) {
    const p = path.join(dir, e.name);
    if (e.isDirectory()) walk(p, out);
    else if (/\.tsx?$/.test(e.name)) out.push(p);
  }
  return out;
}

const CANON = (s) => s.replace(/\s+/g, " ").trim();

function isFnLike(n) {
  return (
    ts.isFunctionDeclaration(n) ||
    ts.isFunctionExpression(n) ||
    ts.isArrowFunction(n) ||
    ts.isMethodDeclaration(n) ||
    ts.isGetAccessorDeclaration(n) ||
    ts.isSetAccessorDeclaration(n) ||
    ts.isConstructorDeclaration(n)
  );
}

/** Name of a function-like node, or null when genuinely anonymous. */
function functionName(n) {
  if (ts.isConstructorDeclaration(n)) return "constructor";
  if (n.name) return ts.isIdentifier(n.name) ? n.name.text : CANON(n.name.getText());
  const p = n.parent;
  if (p && ts.isVariableDeclaration(p) && ts.isIdentifier(p.name)) return p.name.text;
  if (p && ts.isPropertyAssignment(p)) return CANON(p.name.getText());
  if (p && ts.isPropertyDeclaration(p) && ts.isIdentifier(p.name)) return p.name.text;
  return null;
}

/**
 * Inventory key component: nearest NAMED function-like ancestor, so arrow
 * callbacks inside `useEffect` resolve to the component or hook that owns them —
 * a reviewer reads `Navbar`, not `useEffect`. Falls back to the enclosing class,
 * then `<module>`.
 */
function symbolOf(node) {
  let n = node.parent;
  let className = null;
  while (n) {
    if (isFnLike(n)) {
      const name = functionName(n);
      if (name) return name;
    }
    if (ts.isClassDeclaration(n) && n.name && !className) className = n.name.text;
    n = n.parent;
  }
  return className || "<module>";
}

/**
 * Canonical text of a call argument. String literals are keyed by VALUE, so a
 * quote-style change is not a change but the value is; object literals are keyed
 * as sorted `key=value` pairs, so property order and whitespace do not matter
 * while a changed or removed value does.
 */
function canonArg(a) {
  if (ts.isStringLiteral(a) || ts.isNoSubstitutionTemplateLiteral(a)) {
    return JSON.stringify(a.text);
  }
  if (ts.isObjectLiteralExpression(a)) {
    const pairs = [];
    for (const pr of a.properties) {
      if (ts.isPropertyAssignment(pr)) {
        pairs.push(CANON(pr.name.getText()) + "=" + canonArg(pr.initializer));
      } else {
        pairs.push(CANON(pr.getText()));
      }
    }
    pairs.sort();
    return "{" + pairs.join(", ") + "}";
  }
  return "<" + CANON(a.getText()) + ">";
}

const calleeText = (call) => CANON(call.expression.getText());
const isMatchMediaCallee = (txt) => txt === "matchMedia" || /(?:^|\.)matchMedia$/.test(txt);

/**
 * Width conditions declared inside an already-AST-located argument, canonical
 * form `(min-width: 1024px)`. Regex on located argument text only — equivalent
 * to a syntax-aware match here because the argument's shape is known.
 */
const COND_RE = /\(\s*(min|max)-width\s*:\s*([0-9.]+)(px|rem)\s*\)/g;
function conditionsIn(text) {
  const out = [];
  let m;
  COND_RE.lastIndex = 0;
  while ((m = COND_RE.exec(text)) !== null) {
    out.push("(" + m[1] + "-width: " + m[2] + m[3] + ")");
  }
  return out;
}

/* --------------------------------------------------- collect call sites -- */

const files = walk(SRC, []).sort();
const sites = [];
const factories = [];
const parseErrors = [];

for (const f of files) {
  const src = fs.readFileSync(f, "utf8");
  const rel = path.relative(tree, f);
  const kind = f.endsWith(".tsx") ? ts.ScriptKind.TSX : ts.ScriptKind.TS;

  // A syntax error makes the AST unreliable. A false PASS is the one outcome
  // worse than FAIL, so this is a hard failure, not a warning.
  let diags = [];
  try {
    diags =
      ts.transpileModule(src, {
        reportDiagnostics: true,
        fileName: f,
        compilerOptions: { target: ts.ScriptTarget.ESNext, jsx: ts.JsxEmit.Preserve },
      }).diagnostics || [];
  } catch (e) {
    diags = [{ category: ts.DiagnosticCategory.Error, messageText: String(e.message) }];
  }
  const errs = diags.filter((d) => d.category === ts.DiagnosticCategory.Error);
  if (errs.length) {
    parseErrors.push({
      file: rel,
      count: errs.length,
      first: ts.flattenDiagnosticMessageText(errs[0].messageText, " "),
    });
  }

  const sf = ts.createSourceFile(f, src, ts.ScriptTarget.Latest, true, kind);

  // pass 1 — identifiers bound to a `X.matchMedia(...)` factory call
  const aliases = new Set();
  const collectAlias = (node) => {
    if (ts.isVariableDeclaration(node) && ts.isIdentifier(node.name) && node.initializer) {
      const init = node.initializer;
      if (ts.isCallExpression(init) && isMatchMediaCallee(calleeText(init))) {
        aliases.add(node.name.text);
      }
    }
    ts.forEachChild(node, collectAlias);
  };
  collectAlias(sf);

  // pass 2 — the sites themselves
  const visit = (node) => {
    if (ts.isCallExpression(node)) {
      const cal = calleeText(node);
      const line = sf.getLineAndCharacterOfPosition(node.getStart(sf)).line + 1;

      if (isMatchMediaCallee(cal)) {
        if (node.arguments.length === 0) {
          factories.push({ file: rel, symbol: symbolOf(node), method: cal, line });
        } else {
          const args = canonArg(node.arguments[0]);
          sites.push({
            file: rel,
            symbol: symbolOf(node),
            method: cal,
            args,
            conditions: conditionsIn(args),
            line,
          });
        }
      } else if (ts.isPropertyAccessExpression(node.expression)) {
        const prop = node.expression.name.text;
        if (prop === "add" || prop === "addAll") {
          const obj = node.expression.expression;
          const viaAlias = ts.isIdentifier(obj) && aliases.has(obj.text);
          const viaDirect = ts.isCallExpression(obj) && isMatchMediaCallee(calleeText(obj));
          if (viaAlias || viaDirect) {
            const conds = node.arguments[0];
            let args = "<no-conditions-object>";
            if (conds && ts.isObjectLiteralExpression(conds)) {
              args =
                "{" +
                conds.properties
                  .filter((pr) => ts.isPropertyAssignment(pr))
                  .map((pr) => CANON(pr.name.getText()) + "=" + canonArg(pr.initializer))
                  .sort()
                  .join(", ") +
                "}";
            } else if (conds) {
              args = canonArg(conds);
            }
            sites.push({
              file: rel,
              symbol: symbolOf(node),
              method: "gsap.matchMedia()." + prop,
              args,
              conditions: conditionsIn(args),
              line,
            });
          }
        }
      }
    }
    ts.forEachChild(node, visit);
  };
  visit(sf);
}

/* -------------------------------------------------------------- inventory -- */

function keyOf(o) {
  return [o.file, o.symbol, o.method, o.args].join("\u0000");
}

function loadInventory() {
  if (!fs.existsSync(INVENTORY_PATH)) die(2, "inventory not found: " + INVENTORY_PATH);
  const raw = fs.readFileSync(INVENTORY_PATH);
  let doc;
  try {
    doc = JSON.parse(raw.toString("utf8"));
  } catch (e) {
    die(2, "inventory is not valid JSON: " + e.message);
  }

  const conditions = doc.conditions;
  if (!Array.isArray(conditions) || conditions.length === 0) {
    die(2, "inventory has no `conditions` block; the requirement side would be vacuous");
  }
  const condIds = new Map();
  for (const c of conditions) {
    for (const k of ["id", "condition", "total", "why"]) {
      if (c[k] === undefined) die(2, "condition entry missing `" + k + "`: " + JSON.stringify(c));
    }
    if (!Number.isInteger(c.total) || c.total < 1) {
      die(2, "condition `total` must be a positive integer: " + c.id);
    }
    if (condIds.has(c.id)) die(2, "duplicate condition id: " + c.id);
    condIds.set(c.id, c);
  }

  const entries = doc.entries;
  if (!Array.isArray(entries) || entries.length === 0) {
    die(2, "inventory has no entries; an empty inventory would be vacuous");
  }
  const seenId = new Set();
  const seenKey = new Map();
  const perEntryCond = new Map();
  for (const e of entries) {
    for (const k of ["id", "file", "symbol", "method", "args", "count", "conditions"]) {
      if (e[k] === undefined) die(2, "inventory entry missing `" + k + "`: " + JSON.stringify(e));
    }
    if (!Number.isInteger(e.count) || e.count < 1) {
      die(2, "inventory entry `count` must be a positive integer: " + e.id);
    }
    if (!Array.isArray(e.conditions) || e.conditions.length === 0) {
      die(2, "inventory entry must claim at least one condition id: " + e.id);
    }
    if (seenId.has(e.id)) die(2, "duplicate inventory id: " + e.id);
    seenId.add(e.id);
    const k2 = keyOf(e);
    if (seenKey.has(k2)) {
      die(2, "inventory entries " + seenKey.get(k2) + " and " + e.id + " share one key");
    }
    seenKey.set(k2, e.id);
    for (const cid of e.conditions) {
      if (!condIds.has(cid)) die(2, "entry " + e.id + " claims unknown condition id " + cid);
      perEntryCond.set(cid, (perEntryCond.get(cid) || []).concat(e.id));
    }
    // the entry must actually declare the conditions it claims
    const declared = new Set(conditionsIn(e.args));
    for (const cid of e.conditions) {
      const want = condIds.get(cid).condition;
      if (!declared.has(want)) {
        die(
          2,
          "entry " + e.id + " claims " + cid + " (" + want + ") but its `args` do not declare it"
        );
      }
    }
  }
  for (const [cid] of condIds) {
    if (!perEntryCond.has(cid)) {
      die(2, "condition " + cid + " is named by the requirement but no inventory entry claims it");
    }
  }

  return {
    doc,
    entries,
    conditions,
    condIds,
    perEntryCond,
    sha256: crypto.createHash("sha256").update(raw).digest("hex"),
  };
}

const inv = loadInventory();

/* -------------------------------------------------------------- classify -- */

const foundByKey = new Map();
for (const s of sites) {
  const k = keyOf(s);
  if (!foundByKey.has(k)) foundByKey.set(k, { sample: s, lines: [] });
  foundByKey.get(k).lines.push(s.line);
}
const invByKey = new Map();
for (const e of inv.entries) invByKey.set(keyOf(e), e);

const findings = [];
const okEntries = [];
const deficit = [];

/* PASS (I) — exact key match; count compare (D3 excess here, D1 candidate) */
for (const [k, e] of invByKey) {
  const g = foundByKey.get(k);
  const n = g ? g.lines.length : 0;
  if (n === e.count) {
    okEntries.push({ id: e.id, found: n });
  } else if (n > e.count) {
    findings.push({
      dimension: DIM.excess,
      entry: e.id,
      detail:
        "expected " + e.count + " occurrence(s), found " + n + " (lines " +
        g.lines.slice().sort((a, b) => a - b).join(", ") +
        "); occurrence beyond the approved count at line " + Math.max.apply(null, g.lines),
    });
  } else {
    deficit.push({ entry: e, found: n });
  }
}

/* PASS (I) continued — pair each deficit with an unmatched site (D4) */
const claimed = new Set();
function takeUnmatched(pred) {
  for (const [k, g] of foundByKey) {
    if (invByKey.has(k) || claimed.has(k)) continue;
    if (pred(g.sample)) return { key: k, group: g };
  }
  return null;
}

for (const d of deficit) {
  const e = d.entry;
  let hit = takeUnmatched((s) => s.file === e.file && s.method === e.method && s.args === e.args);
  if (hit) {
    claimed.add(hit.key);
    findings.push({
      dimension: DIM.changed,
      entry: e.id,
      detail:
        "enclosing symbol changed: approved `" + e.symbol + "` → now `" +
        hit.group.sample.symbol + "` at line " + hit.group.sample.line,
    });
    continue;
  }
  hit = takeUnmatched((s) => s.file === e.file && s.method === e.method);
  if (hit) {
    claimed.add(hit.key);
    findings.push({
      dimension: DIM.changed,
      entry: e.id,
      detail:
        "arguments changed at line " + hit.group.sample.line + ": approved " + e.args +
        " → now " + hit.group.sample.args,
    });
    continue;
  }
  hit = takeUnmatched((s) => s.file === e.file && s.symbol === e.symbol && s.args === e.args);
  if (hit) {
    claimed.add(hit.key);
    findings.push({
      dimension: DIM.changed,
      entry: e.id,
      detail:
        "call method changed at line " + hit.group.sample.line + ": approved `" + e.method +
        "` → now `" + hit.group.sample.method + "`",
    });
    continue;
  }
  findings.push({
    dimension: DIM.missing,
    entry: e.id,
    detail: "no matching site; " + d.found + " of " + e.count + " occurrence(s) present",
  });
}

/* PASS (I) continued — anything still unmatched in the tree is unexpected (D2) */
for (const [k, g] of foundByKey) {
  if (invByKey.has(k) || claimed.has(k)) continue;
  findings.push({
    dimension: DIM.unexpected,
    detail:
      "no inventory entry for " + g.sample.file + " | " + g.sample.symbol + " | " +
      g.sample.method + " | " + g.sample.args + " (line " + g.lines.join(", ") + ")",
  });
}

/* PASS (II) — requirement-keyed, the independent reading.
   Kept SEPARATE from pass (I): a condition-count mismatch is not a missing or
   unexpected call SITE, and folding the two would let one defect print twice
   under two different dimension labels. */
const condCount = new Map();
for (const s of sites) {
  for (const c of s.conditions) condCount.set(c, (condCount.get(c) || 0) + 1);
}
const requiredConds = new Set(inv.conditions.map((c) => c.condition));
const reqRows = [];
const reqFindings = [];
for (const c of inv.conditions) {
  const got = condCount.get(c.condition) || 0;
  const pass = got === c.total;
  reqRows.push({ id: c.id, condition: c.condition, want: c.total, got, outcome: pass ? "PASS" : "FAIL" });
  // a count mismatch is already visible in the row above; only conditions the
  // ROWS cannot express get their own finding line
}
const unnamed = [...condCount.keys()].filter((c) => !requiredConds.has(c));

/* Inventory self-consistency, checked statically and with NO tree involved: the
   count budgets of the entries claiming a condition must sum to that condition's
   requirement total. This is the one place the two passes can truly contradict each
   other, and it is a property of the INVENTORY FILE alone. */
const consistency = [];
for (const c of inv.conditions) {
  const claimants = inv.entries.filter((e) => e.conditions.includes(c.id));
  const budget = claimants.reduce((a, e) => a + e.count, 0);
  consistency.push({ id: c.id, budget, want: c.total, ok: budget === c.total,
                     holders: claimants.map((e) => e.id) });
}
const inconsistent = consistency.filter((k) => !k.ok);
const passIFailed = findings.length > 0 || parseErrors.length > 0;
const passIIFailed =
  reqRows.some((r) => r.outcome === "FAIL") || unnamed.length > 0 || inconsistent.length > 0;

/* ------------------------------------- clauses carried over from AC-41, unchanged */

const clauses = [];

// (a) Tailwind screens unmodified — a config token, not a call site.
let screensHit = null;
for (const e of fs.readdirSync(tree, { withFileTypes: true })) {
  if (e.isFile() && /^tailwind\.config\./.test(e.name)) {
    if (/(^|[^a-z])screens\s*:/.test(fs.readFileSync(path.join(tree, e.name), "utf8"))) {
      screensHit = e.name;
    }
  }
}
const globalsCss = path.join(tree, "src", "app", "globals.css");
if (!screensHit && fs.existsSync(globalsCss)) {
  if (/(^|[^a-z])screens\s*:/.test(fs.readFileSync(globalsCss, "utf8"))) {
    screensHit = "src/app/globals.css";
  }
}
clauses.push(
  screensHit
    ? { name: "Tailwind screens not customised", outcome: "FAIL", detail: "found `screens:` in " + screensHit }
    : { name: "Tailwind screens not customised", outcome: "PASS", detail: "no `screens:` override" }
);

// (b) hero keeps 100svh — a class string; there is no call site to key.
let svh = 0;
for (const f of files) {
  const m = fs.readFileSync(f, "utf8").match(/100svh/g);
  if (m) svh += m.length;
}
clauses.push(
  svh > 0
    ? { name: "hero keeps 100svh", outcome: "PASS", detail: svh + " occurrence(s)" }
    : { name: "hero keeps 100svh", outcome: "FAIL", detail: "not found in src/" }
);

/* ------------------------------------------------------------------ report */

const clauseFailed = clauses.some((c) => c.outcome === "FAIL");
const failed = passIFailed || passIIFailed || clauseFailed;

if (suggest) {
  process.stdout.write("# candidate inventory entries for " + tree + "\n");
  process.stdout.write("# copy by hand; this mode never writes the inventory\n");
  for (const [, g] of foundByKey) {
    const s = g.sample;
    process.stdout.write(
      JSON.stringify({
        id: "<name>",
        file: s.file,
        symbol: s.symbol,
        method: s.method,
        args: s.args,
        count: g.lines.length,
        conditions: [],
      }) + "\n"
    );
  }
  process.exit(failed ? 1 : 0);
}

if (asJson) {
  process.stdout.write(
    JSON.stringify(
      {
        tree,
        typescript: { from: loaded.from, version: ts.version },
        inventory: {
          path: INVENTORY_PATH,
          sha256: inv.sha256,
          entries: inv.entries.length,
          conditions: inv.conditions.length,
        },
        scanned: { files: files.length, sites: sites.length, factories: factories.length },
        parseErrors,
        passI: { failed: passIFailed, findings, okEntries },
        passII: { failed: passIIFailed, rows: reqRows, findings: reqFindings },
        consistency,
        clauses,
        verdict: failed ? "FAIL" : "PASS",
      },
      null,
      2
    ) + "\n"
  );
  process.exit(failed ? 1 : 0);
}

const pad = (s, n) => String(s).padEnd(n);
const out = [];
out.push("AC-41 (inventory-keyed) against " + tree);
out.push("  parser            : typescript " + ts.version + "  (" + loaded.from + ")");
out.push("  inventory         : " + INVENTORY_PATH);
out.push("  inventory sha256  : " + inv.sha256);
out.push("  inventory entries : " + inv.entries.length + "  ·  requirement conditions: " + inv.conditions.length);
out.push("  files scanned     : " + files.length + " .ts/.tsx under src/");
out.push("  qualifying sites  : " + sites.length + "  (factories, zero-arg matchMedia: " + factories.length + ")");
out.push("");
out.push("  sites found (file | symbol | method | arguments @ line):");
if (!sites.length) out.push("    (none)");
const ordered = sites
  .slice()
  .sort((a, b) =>
    (a.file + String(a.line).padStart(8, "0")).localeCompare(b.file + String(b.line).padStart(8, "0"))
  );
for (const s of ordered) {
  out.push("    " + s.file + " | " + s.symbol + " | " + s.method + " | " + s.args + " @ L" + s.line);
}
out.push("");

out.push("  pass (I) site-keyed — D1 missing / D2 unexpected / D3 excess / D4 changed");
for (const p of parseErrors) {
  out.push(
    "  [" + pad("parse", 13) + "] FAIL  " + p.file + ": " + p.count +
      " syntax error(s) — AST unreliable, refusing to judge call sites (" + p.first + ")"
  );
}
if (!passIFailed) {
  out.push("  [" + pad("D1-D4", 13) + "] PASS  every entry matched exactly; no unexpected site");
}
for (const f of findings) {
  out.push(
    "  [" + pad(f.dimension, 13) + "] FAIL  " + (f.entry ? "entry " + f.entry + ": " : "") + f.detail
  );
}
for (const o of okEntries) {
  out.push("  [" + pad("entry", 13) + "] ok    " + o.id + " (" + o.found + " occurrence(s))");
}
out.push("");
out.push("  pass (II) condition-keyed — the same tree, read independently, ignoring the inventory keys");
for (const r of reqRows) {
  out.push(
    "  [" + pad("req", 13) + "] " + pad(r.outcome, 4) + "  " + r.id + " " + r.condition +
      " — required exactly " + r.want + ", found " + r.got
  );
}
out.push(
  "  [" + pad("req", 13) + "] " + pad(unnamed.length ? "FAIL" : "PASS", 4) +
    "  no condition in the tree that the requirement does not name" +
    (unnamed.length ? " — " + unnamed.join(", ") : "")
);
out.push("");
out.push("  inventory self-consistency (static, no tree involved) — entry budgets vs requirement totals");
for (const k of consistency) {
  out.push(
    "  [" + pad("budget", 13) + "] " + pad(k.ok ? "PASS" : "FAIL", 4) + "  " + k.id +
      " — entries [" + k.holders.join(", ") + "] permit " + k.budget + ", requirement says " + k.want
  );
}
out.push(
  "  [" + pad("cross-check", 13) + "] " + pad(inconsistent.length ? "FAIL" : "PASS", 4) +
    "  no entry budget can silently disagree with the requirement"
);
for (const f of reqFindings) {
  out.push("  [" + pad("cross-check", 13) + "] FAIL  " + f);
}
if (findings.some((f) => f.dimension === DIM.changed) && !passIIFailed) {
  out.push(
    "  [" + pad("note", 13) + "] ----  D4 fired but pass (II) passed: a change of enclosing symbol," +
      " method or\n                   argument shape can leave every condition COUNT correct. That is why" +
      " D4 exists\n                   as its own dimension and why the inventory key is structural, not a count."
  );
}
out.push("");
for (const c of clauses) {
  out.push("  [" + pad("clause", 13) + "] " + pad(c.outcome, 4) + " " + c.name + " — " + c.detail);
}
out.push("");
out.push("AC-41 (inventory-keyed): " + (failed ? "FAIL" : "PASS"));
process.stdout.write(out.join("\n") + "\n");
process.exit(failed ? 1 : 0);
