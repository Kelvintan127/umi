/**
 * Shared types for Inertia page props.
 *
 * These mirror App\Support\PageProps exactly. The Inertia generic on each page
 * component is what keeps the two sides honest: a prop the controller stops
 * sending becomes a type error here, not a runtime `undefined`.
 */

export type Locale = "en" | "id" | "zh";

export interface NavItem {
  key: string;
  path: string;
  label: string;
}

export interface LanguageOption {
  code: Locale;
  label: string;
  htmlLang: string;
  url: string;
  /** False when this locale has no signed-off copy for the current page. */
  available: boolean;
  current: boolean;
}

export interface Brand {
  mark: string;
  company: string;
  short: string;
}

export interface Chrome {
  nav: NavItem[];
  brand: Brand;
  cta: Record<string, string>;
  ctaBlock: { title: string; lead: string };
  contactPage: {
    locationsEyebrow: string;
    locationsTitle: string;
    email: string;
    phone: string;
    location: string;
    viewMap: string;
  };
  aria: Record<string, string>;
  footer: {
    blurb: string;
    company: string;
    resources: string;
    rights: string;
    privacy: string;
    terms: string;
    links: Record<string, Record<string, string>>;
  };
  languages: LanguageOption[];
  /** Labels for the language block, including the pending-sign-off message. */
  language: {
    label: string;
    en: string;
    id: string;
    zh: string;
    unavailable: string;
  };
}

export interface FormLabels {
  title: string;
  intro: string;
  fields: {
    name: string;
    company: string;
    email: string;
    phone: string;
    inquiryType: string;
    message: string;
  };
  placeholders: Record<string, string>;
  inquiryTypes: Record<string, string>;
  submit: string;
  submitting: string;
  successTitle: string;
  successBody: string;
  successAgain: string;
  errorsTitle: string;
  consent: string;
  privacy: string;
}

export interface Alternate {
  code: Locale;
  htmlLang: string;
  url: string;
  available: boolean;
}

export interface Seo {
  title: string;
  description: string;
  canonical: string;
  og: {
    type: string;
    site_name: string;
    image: string;
    url: string;
  };
  alternates: Alternate[];
  /** Absolute URL for the x-default alternate; always the default locale. */
  xDefault: string;
  jsonLd: Record<string, unknown>;
}

export interface Breadcrumb {
  label: string;
  url: string;
}

export interface SiteInfo {
  name: string;
  company: string;
  founded: string;
  language: Record<string, string>;
}

/* ---- content blocks (lang/{locale}/site.php) ---- */

export interface Capability {
  title: string;
  category: string;
  description: string;
  image: string;
}

export interface Industry {
  title: string;
  description: string;
  image: string;
}

export interface ProcessStage {
  title: string;
  description: string;
}

export interface QualityPrinciple {
  title: string;
  description: string;
}

export interface Certification {
  name: string;
  title: string;
  description: string;
  image: string;
}

export interface Stat {
  value: string;
  label: string;
}

export interface Product {
  key: string;
  title: string;
  description: string;
  image: string;
}

export interface Facility {
  key: string;
  title: string;
  summary: string;
  specs: string[];
  image: string;
}

export interface GalleryItem {
  title: string;
  label: string;
  image: string;
}

export interface NewsItem {
  date: string;
  title: string;
  excerpt: string;
}

export interface ContactBlock {
  batam: {
    label: string;
    lines: string[];
    phone: string;
    fax: string;
    map: string;
  };
  jakarta: { label: string; lines: string[]; map: string };
  email: string;
  phone: string;
  location: string;
}

export interface MetalPartUsers {
  intro: string;
  /** Cleared for publication. Empty until config/approvals.php approves a name. */
  users: string[];
  /** Customers UMI invoices directly. */
  direct: string[];
  /** End-product brands reached through a contract manufacturer, not direct customers. */
  indirect: string[];
  testimonials: { name: string; period: string; quote: string }[];
  customers_heading: string;
  brands_heading: string;
  brands_intro: string;
  withheld_note: string;
  /** True when the gate is holding names back, so the page can say so. */
  withheld: boolean;
  withheld_count: number;
  note: string;
}

export interface ContentBlocks {
  capabilities: Capability[];
  industries: Industry[];
  products: Product[];
  facilities: Facility[];
  certifications: Certification[];
  quality: { principles: QualityPrinciple[]; labelling: string };
  process: ProcessStage[];
  stats: Stat[];
  policy: { heading: string; intro: string; items: string[] };
  gallery: GalleryItem[];
  news: NewsItem[];
  users: MetalPartUsers;
  contact: ContactBlock;
}

/* ---- page content (lang/{locale}/pages.php) ---- */

export interface Hero {
  eyebrow?: string;
  title?: string;
  lead?: string;
  note?: string;
  video?: string;
  video_mobile?: string;
  poster?: string;
}

export interface Section {
  type: string;
  heading?: string;
  paragraphs?: string[];
  image?: string;
  note?: string;
  /** Name of a ContentBlocks entry a section renders from. */
  source?: string;
  /** Restrict a `specs` section to one facility key. */
  only?: string;
  /** Prefix for per-card links (products overview -> detail pages). */
  link_base?: string;
  items?: { title: string; summary?: string; specs?: string[] }[];
  clauses?: { heading: string; body: string[] }[];
}

export interface Content {
  hero: Hero;
  sections: Section[];
  blocks: ContentBlocks;
}

export interface PageProps {
  pageKey: string;
  locale: Locale;
  htmlLang: string;
  dir: string;
  path: string;
  content: Content;
  chrome: Chrome;
  seo: Seo;
  breadcrumbs: Breadcrumb[];
  site: SiteInfo;
  form: FormLabels;
  /** Present only after a successful POST /contact redirect. */
  flash?: { inquiry?: { ok: boolean; queued: boolean; id?: number; message: string } };
  errors?: Record<string, string>;
  /**
   * Inertia v2 constrains the page-props generic to `PageProps`, which carries
   * an index signature. Keeping it here lets `usePage<PageProps>()` type-check
   * without loosening any of the fields above.
   */
  [key: string]: unknown;
}
