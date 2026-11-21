/**
 * Inertia entry point.
 *
 * The resolver globs eagerly, matching ssr.tsx, so the client hydrates the same
 * module graph the server rendered.
 */
import "../css/app.css";

import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import type { ReactNode } from "react";

createInertiaApp({
  // Navigation transitions apply to GET visits, not RFQ POST submissions.
  // Inertia v2.3 uses the native View Transitions API where supported and
  // gracefully falls back in other browsers.
  defaults: {
    visitOptions: (_href, options) => ({
      viewTransition: (options.method ?? "get").toString().toLowerCase() === "get"
        && (typeof window === "undefined"
          || !window.matchMedia("(prefers-reduced-motion: reduce)").matches),
    }),
  },
  progress: { color: "#d71920", showSpinner: false },
  resolve: (name: string) => {
    const pages = import.meta.glob("./pages/**/*.tsx", { eager: true });
    const module = pages[`./pages/${name}.tsx`] as { default: () => ReactNode } | undefined;

    if (!module) {
      throw new Error(`Inertia page not found: ${name}`);
    }

    return module;
  },
  setup({ el, App, props }) {
    createRoot(el as HTMLElement).render(<App {...props} /> as ReactNode);
  },
});
