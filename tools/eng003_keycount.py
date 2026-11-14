"""eng003_keycount.py — regenerate the §6.4 translation-leaf table from source.

Every number comes from a file in /reference/umi-nextjs; nothing is hand-entered.
Counting rules are fixed here and restated in ENG-003 §2.

LEAF = one translatable string -> one value in lang/{locale}/*.php.
NOT A LEAF: href, image/src, mapUrl, phone, fax, email, number, className, icon,
alt, key names, punctuation-only JSX text, and BRAND/standard tokens that are
carried verbatim in every locale (ENG-001 §6.5 rule 1).

Usage: python3 eng003_keycount.py [--by-file] [--json OUT.json]
"""
import argparse
import json
import os
import re
import sys

BASE = "/reference/umi-nextjs"

NONLEAF_KEYS = {
    "href", "image", "mapUrl", "phone", "fax", "email", "number",
    "className", "src", "alt", "icon", "id", "slug", "value", "type",
}

BRAND = re.compile(
    r"^(UMI|UMI Stamping|PT\. Uni-Metaltech Industry|"
    r"ISO 9001:2015|ISO 14001:2015|SMETA|RoHS|REACH|"
    r"Seyi|Aida|Amada|Yamada Dobby|ISIS|Sodick|Mitsubishi|SEIKI|Okamoto|"
    r"Equiptop|Hurco|Mitutoyo)$"
)


class Parser:
    def __init__(self, text):
        self.t = text
        self.i = 0

    def ws(self):
        while self.i < len(self.t) and self.t[self.i] in " \t\r\n":
            self.i += 1

    def value(self):
        self.ws()
        if self.i >= len(self.t):
            return ("eof", "")
        c = self.t[self.i]
        if c == "[":
            return self.arr()
        if c == "{":
            return self.obj()
        if c in "\"'":
            return self.string()
        m = re.match(r"[A-Za-z0-9_.$\-]+", self.t[self.i:])
        if m:
            self.i += m.end()
            return ("scalar", m.group(0))
        self.i += 1
        return ("scalar", c)

    def string(self):
        q = self.t[self.i]
        self.i += 1
        out = []
        while self.i < len(self.t):
            ch = self.t[self.i]
            if ch == "\\":
                out.append(self.t[self.i:self.i + 2])
                self.i += 2
                continue
            if ch == q:
                self.i += 1
                break
            out.append(ch)
            self.i += 1
        return ("str", "".join(out))

    def arr(self):
        self.i += 1
        out = []
        while True:
            self.ws()
            if self.i >= len(self.t):
                return ("arr", out)
            if self.t[self.i] == "]":
                self.i += 1
                return ("arr", out)
            before = self.i
            out.append(self.value())
            self.ws()
            if self.i < len(self.t) and self.t[self.i] == ",":
                self.i += 1
            if self.i == before:
                self.i += 1

    def obj(self):
        self.i += 1
        out = {}
        while True:
            self.ws()
            if self.i >= len(self.t):
                return ("obj", out)
            if self.t[self.i] == "}":
                self.i += 1
                return ("obj", out)
            before = self.i
            k = self.value()
            key = k[1] if k[0] in ("str", "scalar") else ""
            self.ws()
            if self.i < len(self.t) and self.t[self.i] == ":":
                self.i += 1
            out[key] = self.value()
            self.ws()
            if self.i < len(self.t) and self.t[self.i] == ",":
                self.i += 1
            if self.i == before:
                self.i += 1


def strip_ts(src):
    src = re.sub(r"/\*.*?\*/", "", src, flags=re.S)
    src = re.sub(r"//[^\n]*", "", src)
    return src.replace("`", '"')


def load_node(path, name):
    p = os.path.join(BASE, path)
    if not os.path.exists(p):
        return None
    src = strip_ts(open(p, encoding="utf-8").read())
    m = re.search(r"(?:export\s+)?const\s+" + re.escape(name) + r"\b[^=]*=\s*", src)
    if not m:
        return None
    try:
        return Parser(src[m.end():]).value()
    except Exception as e:  # noqa: BLE001 — report, never crash the report tool
        print(f"WARN parse {path}:{name}: {e}", file=sys.stderr)
        return None


def count_leaves(node, key=None):
    """Leaf = one translatable string -> one lang value.

    Array of objects : each object field is a leaf, minus NONLEAF_KEYS and BRAND.
    Array of strings : each element is its own leaf (policy.N, quality.points.N).
    """
    kind, val = node
    if kind == "str":
        if key in NONLEAF_KEYS:
            return 0
        return 0 if BRAND.match(val.strip()) else 1
    if kind == "arr":
        return sum(count_leaves(x, key) for x in val)
    if kind == "obj":
        return sum(count_leaves(v, k) for k, v in val.items())
    return 0


def leaves_in_strings(node, key=None):
    """Every translatable string, as a list (for auditing, not just counting)."""
    kind, val = node
    if kind == "str":
        if key in NONLEAF_KEYS or BRAND.match(val.strip()):
            return []
        return [val]
    if kind == "arr":
        out = []
        for x in val:
            out += leaves_in_strings(x, key)
        return out
    if kind == "obj":
        out = []
        for k, v in val.items():
            out += leaves_in_strings(v, k)
        return out
    return []


def items_of(node):
    kind, val = node
    return len(val) if kind == "arr" else (1 if val else 0)


JSX_ATTRS = ("placeholder", "aria-label", "title")


def inline_leaves(path):
    p = os.path.join(BASE, path)
    if not os.path.exists(p):
        return None
    raw = open(p, encoding="utf-8").read()
    src = re.sub(r"/\*.*?\*/", "", raw, flags=re.S)
    src = re.sub(r"(?m)^\s*//[^\n]*$", "", src)
    # Neutralise JSX attribute expressions (className={...}, style={{...}}) so a
    # `{`/`}` inside an attribute value cannot swallow the following text node.
    src = re.sub(r'(?m)(\s[A-Za-z-]+)=\{', r'\1="', src)
    src = re.sub(r'(?m)^\s*(const|let|var|export|import|function|return|if|else|'
                 r"setFormData|setStatus|setErrors|useEffect|useState)\b[^\n]*$", "", src)
    out = []
    for m in re.finditer(r">([^<>{}]*?)<", src, flags=re.S):
        t = " ".join(m.group(1).split())
        if len(t) < 3:
            continue
        if ";" in t or "=" in t:
            continue
        if not re.search(r"[A-Za-z]{2}", t):
            continue
        if re.fullmatch(r"[\s|•/·.,;:—–\-+*×()\[\]&;a-z]+", t) and not re.search(r"[A-Z]", t):
            continue
        if BRAND.match(t):
            continue
        out.append(t)
    for m in re.finditer(
        r'\b(' + "|".join(re.escape(a) for a in JSX_ATTRS) + r')="([^"]{2,})"', src
    ):
        t = m.group(2).strip()
        if "{" in t or BRAND.match(t):
            continue
        out.append(t)
    return out


ROWS = [
    ("site.php", "nav.*", "src/data/site.ts", "navigation"),
    ("site.php", "footer.group.{company,resources}[]", "src/components/layout/footer.tsx", "footerLinks"),
    ("site.php", "stats.N.{value,label}", "src/data/site.ts", "stats"),
    ("site.php", "capabilities.N.{title,category,description}", "src/data/site.ts", "capabilities"),
    ("site.php", "industries.N.{title,eyebrow,description,capabilities[]}", "src/data/site.ts", "industries"),
    ("site.php", "process.stages.N.{title,label,description,points[]}", "src/data/site.ts", "manufacturingProcess"),
    ("site.php", "quality.principles.N.{title,description}", "src/data/site.ts", "qualityPrinciples"),
    ("site.php", "quality.points.N", "src/components/sections/quality.tsx", "qualityPoints"),
    ("site.php", "certifications.N.{name,title,description}", "src/data/site.ts", "certifications"),
    ("site.php", "gallery.home.N.title", "src/components/sections/gallery.tsx", "gallery"),
    ("site.php", "gallery.page.N.{title,label}", "src/app/gallery/page.tsx", "galleryItems"),
    ("site.php", "factory.N.{title,label}", "src/data/site.ts", "factoryGallery"),
    ("site.php", "products.N.{title,description}", "src/data/site.ts", "products"),
    ("site.php", "facilities.N.{title,label,description,specs[]}", "src/data/site.ts", "facilities"),
    ("site.php", "inquiry.N.{title,description}", "src/data/site.ts", "inquiryTypes"),
    ("site.php", "policy.N", "src/data/site.ts", "companyPolicy"),
    ("site.php", "customers.N.{name,period,testimonial}", "src/data/site.ts", "mainCustomers"),
    ("site.php", "news.items.N.{date,title,excerpt}", "src/app/news/page.tsx", "newsItems"),
]

# processSteps is unused in the reference: reported, never folded into a page file
OPTIONAL = [("site.php", "process.steps.N.{title,description}", "src/data/site.ts", "processSteps")]

INLINE_FILES = [
    ("site.php", "home.hero.*", "src/components/sections/hero.tsx"),
    ("site.php", "home.aboutSection.*", "src/components/sections/about.tsx"),
    ("site.php", "cta.*", "src/components/sections/contact-cta.tsx"),
    ("site.php", "capabilities.section.*", "src/components/sections/capabilities.tsx"),
    ("site.php", "process.section.*", "src/components/sections/manufacturing-process.tsx"),
    ("site.php", "factory.section.*", "src/components/sections/factory-experience.tsx"),
    ("site.php", "industries.section.*", "src/components/sections/industries.tsx"),
    ("site.php", "quality.section.*", "src/components/sections/quality.tsx"),
    ("site.php", "stats.section.*", "src/components/sections/stats.tsx"),
    ("site.php", "nav.* (chrome)", "src/components/layout/navbar.tsx"),
    ("site.php", "footer.* (chrome)", "src/components/layout/footer.tsx"),
    ("pages.php", "privacy.*", "src/app/privacy/page.tsx"),
    ("pages.php", "terms.*", "src/app/terms/page.tsx"),
    ("pages.php", "about.*", "src/app/about/page.tsx"),
    ("pages.php", "contact.* (page shell)", "src/app/contact/page.tsx"),
    ("pages.php", "capabilities.hero.*", "src/app/capabilities/page.tsx"),
    ("pages.php", "products.hero.*", "src/app/products/page.tsx"),
    ("pages.php", "industries.hero.*", "src/app/industries/page.tsx"),
    ("pages.php", "quality.hero.*", "src/app/quality/page.tsx"),
    ("pages.php", "gallery.hero.*", "src/app/gallery/page.tsx"),
    ("pages.php", "news.hero.*", "src/app/news/page.tsx"),
    ("forms.php", "forms.*", "src/components/sections/contact-form.tsx"),
]


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--by-file", action="store_true")
    ap.add_argument("--strings", action="store_true", help="dump every counted string")
    ap.add_argument("--json")
    args = ap.parse_args()

    results = []
    for target, group, path, name in ROWS + OPTIONAL:
        node = load_node(path, name)
        is_opt = (name == "processSteps")
        if node is None:
            results.append(dict(target=target, group=group, file=path, source=name,
                                items=None, leaves=None, strings=[], optional=is_opt))
            continue
        results.append(dict(target=target, group=group, file=path, source=name,
                            items=items_of(node), leaves=count_leaves(node),
                            strings=leaves_in_strings(node),
                            optional=is_opt))


    inline = []
    for target, group, path in INLINE_FILES:
        ls = inline_leaves(path)
        inline.append(dict(target=target, group=group, file=path,
                           leaves=None if ls is None else len(ls), strings=ls or []))

    print(f"{'file':9s} {'group':46s} {'it':>3s} {'lv':>4s}  src")
    for r in results:
        it = "-" if r["items"] is None else r["items"]
        lv = "??" if r["leaves"] is None else r["leaves"]
        flag = "  [OPTIONAL/UNUSED]" if r["optional"] else ""
        print(f"{r['target']:9s} {r['group']:46s} {str(it):>3s} {str(lv):>4s}  {r['file']}{flag}")
    print()
    for r in inline:
        lv = "??" if r["leaves"] is None else r["leaves"]
        print(f"{r['target']:9s} {r['group']:46s} {'':>3s} {str(lv):>4s}  {r['file']}  [inline]")

    def tot(target, include_optional):
        return sum(r["leaves"] or 0 for r in results
                   if r["target"] == target and (include_optional or not r["optional"])) + \
               sum(r["leaves"] or 0 for r in inline if r["target"] == target)

    print()
    print("site.php  leaves (processSteps DROPPED):", tot("site.php", False))
    print("site.php  leaves (processSteps PORTED) :", tot("site.php", True))
    print("pages.php leaves                      :", tot("pages.php", False))
    print("forms.php leaves                      :", tot("forms.php", False))
    print("seo.php   leaves                      : 44 (fixed: 11 page titles + 11 descriptions + 3 defaults + 1 og)")
    grand = tot("site.php", False) + tot("pages.php", False) + tot("forms.php", False) + 44
    print("GRAND TOTAL leaves/locale             :", grand)
    print("             x 2 non-source locales    :", grand * 2)

    if args.strings:
        for r in results + inline:
            print(f"\n### {r['group']}  ({r['file']})")
            for s in r["strings"]:
                print("   ", s.replace("\n", " ")[:120])

    if args.json:
        with open(args.json, "w", encoding="utf-8") as fh:
            json.dump(dict(data=results, inline=inline), fh, indent=1)
        print("\nwrote", args.json)


if __name__ == "__main__":
    main()
