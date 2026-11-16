/**
 * Inertia SSR entry.
 *
 * Without this the first byte is an empty <div id="app"> plus a JSON payload:
 * the meta tags, headings and body text only exist after the bundle runs. For a
 * corporate site whose SEO metadata is a requirement that is not acceptable, so
 * the app renders on the server and the client hydrates it.
 */
import { createInertiaApp } from "@inertiajs/react";
import createServer from "@inertiajs/react/server";
import ReactDOMServer from "react-dom/server";
import type { ReactNode } from "react";

// The renderer port comes from the environment so staging can run its own copy
// alongside development. Inertia defaults to 13714 when this is not a number.
const port = Number.parseInt(process.env.INERTIA_SSR_PORT ?? "", 10);

createServer(
  (page) =>
    createInertiaApp({
      page,
      render: ReactDOMServer.renderToString,
      resolve: (name: string) => {
        const pages = import.meta.glob("./pages/**/*.tsx", { eager: true });
        const module = pages[`./pages/${name}.tsx`] as { default: () => ReactNode } | undefined;

        if (!module) {
          throw new Error(`Inertia page not found: ${name}`);
        }

        return module;
      },
      setup: ({ App, props }) => <App {...props} />,
    }),
  Number.isNaN(port) ? undefined : port,
);
