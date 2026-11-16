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
