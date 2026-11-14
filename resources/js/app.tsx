/**
 * Inertia entry point.
 */
import "../css/app.css";

import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import type { ReactNode } from "react";

createInertiaApp({
  resolve: (name: string) => {
    const pages = import.meta.glob("./pages/**/*.tsx");
    const page = pages[`./pages/${name}.tsx`];
    if (!page) {
      throw new Error(`Inertia page not found: ${name}`);
    }
    return page();
  },
  setup({ el, App, props }) {
    createRoot(el as HTMLElement).render(<App {...props} /> as ReactNode);
  },
});
