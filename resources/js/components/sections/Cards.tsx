import { Link } from "@inertiajs/react";
import { ArrowRight, ArrowUpRight } from "lucide-react";
import { Band, SectionHeading } from "./Band";
import type { Capability, ContactBlock, Product } from "@/types";
import { cn } from "@/lib/utils";

/** Text and image cards. Used for capabilities, products, industries, quality principles. */
export function Cards({
  items,
  heading,
  locale,
  linkBase,
}: {
  items: (Capability | Product | { title: string; description: string; image?: string })[];
  heading?: string;
  locale: string;
  linkBase?: string;
}) {
  const headingId = "cards-heading";

  return (
    <Band tone="light" ariaLabelledBy={heading ? headingId : undefined}>
      <SectionHeading title={heading} id={headingId} />

      <ul
        className={cn(
          "mt-14 grid gap-6 sm:grid-cols-2",
          items.length > 2 && "lg:grid-cols-2",
        )}
      >
        {items.map((item, index) => {
          const image = "image" in item ? item.image : undefined;
          const slug = "key" in item && typeof item.key === "string" ? item.key : undefined;
          const category = "category" in item ? item.category : undefined;

          return (
            <li key={`${item.title}-${index}`}>
              <article className="group flex h-full flex-col border border-ink/10 bg-white">
                {image ? (
                  <div className="relative aspect-[16/10] overflow-hidden bg-band-lighter">
                    <img
                      src={image}
                      alt={item.title}
                      loading="lazy"
                      decoding="async"
                      className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                    />
                  </div>
                ) : null}

                <div className="flex flex-1 flex-col p-7">
                  {category ? (
                    <p className="text-xs font-semibold uppercase tracking-[0.18em] text-red">
                      {category}
                    </p>
                  ) : null}

                  <h3 className="mt-3 text-xl font-bold tracking-tight">{item.title}</h3>
                  <p className="mt-3 flex-1 text-sm leading-6 text-ink/60">{item.description}</p>

                  {linkBase && slug ? (
                    <Link
                      href={`/${locale}/${linkBase}/${slug}`}
                      className="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-ink transition-colors hover:text-red"
                    >
                      {item.title}
                      <ArrowRight size={16} aria-hidden="true" />
                      <span className="sr-only">— {item.title}</span>
                    </Link>
                  ) : null}
                </div>
              </article>
            </li>
          );
        })}
      </ul>
    </Band>
  );
}

/** Two-location contact block, used by the contact page and its CTA. */
export function ContactDetails({
  contact,
  labels,
  locale,
  ctaLabel,
}: {
  contact: ContactBlock;
  labels: { email: string; phone: string; location: string; map: string };
  locale: string;
  ctaLabel: string;
}) {
  return (
    <div className="grid gap-10 md:grid-cols-2">
      <section aria-labelledby="office-batam">
        <h2 id="office-batam" className="text-sm font-semibold uppercase tracking-[0.16em] text-red">
          {contact.batam.label}
        </h2>

        <address className="mt-4 not-italic text-sm leading-6 text-ink/70">
          {contact.batam.lines.map((line) => (
            <span key={line} className="block">
              {line}
            </span>
          ))}

          <a href={`tel:${contact.batam.phone.replace(/\s/g, "")}`} className="mt-3 block hover:text-red">
            {labels.phone}: {contact.batam.phone}
          </a>

          <span className="block">Fax: {contact.batam.fax}</span>
        </address>

        <a
          href={contact.batam.map}
          target="_blank"
          rel="noreferrer noopener"
          className="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-ink transition-colors hover:text-red"
        >
          {labels.map}
          <span className="sr-only">({contact.batam.label})</span>
        </a>
      </section>

      <section aria-labelledby="contact-direct" className="flex flex-col items-start">
        <h2 id="contact-direct" className="text-sm font-semibold uppercase tracking-[0.16em] text-red">
          {labels.email}
        </h2>
        <a href={`mailto:${contact.email}`} className="mt-4 block text-sm hover:text-red">
          {contact.email}
        </a>
        <a href={`tel:${contact.phone.replace(/\s/g, "")}`} className="mt-2 block text-sm hover:text-red">
          {contact.phone}
        </a>
        <p className="mt-2 text-sm text-ink/60">{contact.location}</p>
        <Link
          href={`/${locale}/contact`}
          className="mt-6 inline-flex items-center gap-2 bg-red px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-red-hover"
        >
          {ctaLabel}
          <ArrowUpRight size={16} aria-hidden="true" />
        </Link>
      </section>
    </div>
  );
}
