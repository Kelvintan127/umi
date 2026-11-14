/**
 * Inertia entry point.
 *
 * ponytail: the @inertiajs/react import is deferred behind a dynamic import so
 * `tsc --noEmit` and `vite build` do not hard-fail before node_modules exists.
 * Delete the guard and use a static import the moment the packages are
 * installed (AC-39 resolves them); the guard exists only to keep the repo
 * type-checkable while the registry is unreachable.
 */
import "../css/app";

async function boot() {
  const { createInertiaApp } = await import("@inertiajs/react");
  const { createRoot } = await import("react-dom/client");

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
      createRoot(el).render(<App {...props} />);
    },
  });
}

void boot();
