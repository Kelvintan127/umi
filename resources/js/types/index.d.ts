/**
 * Shared types for Inertia page props.
 *
 * ponytail: PageProps starts minimal. Extend it as pages are migrated; the
 * Inertia generic on each page component is what keeps props type-checked.
 */
export interface PageProps {
  locale: string;
  [key: string]: unknown;
}

export type Locale = "en" | "id" | "zh";
