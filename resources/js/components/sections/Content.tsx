import { Link } from "@inertiajs/react";
import { ArrowUpRight } from "lucide-react";
import { Band, SectionHeading } from "./Band";
import type { MetalPartUsers } from "@/types";

/**
 * "Our Metal Part Users" — the customer list, gated by config/approvals.php.
 *
 * Naming a customer publicly needs that customer's permission. Until someone
 * confirms it, `users`, `direct` and `indirect` arrive empty and the section
 * says the list is available on request rather than rendering an empty grid
 * that reads as a design fault. Direct customers and end-product brands are
 * rendered as separate groups: a part supplied to a contract manufacturer
 * reaches a brand UMI does not sell to, and merging the two implies a
 * relationship that does not exist.
 */
export function Users({ users }: { users: MetalPartUsers }) {
  const hasAny = users.users.length > 0;

  // The intro is now a single sentence, so the old split-into-heading-and-body
  // trick would leave an empty paragraph behind.
  const sentences = users.intro.split(".").map((s) => s.trim()).filter(Boolean);
  const heading = sentences.length > 0 ? `${sentences[0]}.` : "";
  const body = sentences.slice(1).join(". ");

  return (
    <Band tone="white" ariaLabelledBy="users-heading">
      <SectionHeading eyebrow="Our metal part users" title={heading} id="users-heading" />
      {body ? (
        <p className="mt-6 max-w-3xl text-base leading-7 text-ink/60">{body}</p>
      ) : null}

      {hasAny ? (
        <>
          {users.direct.length > 0 ? (
            <>
              <h3 className="mt-14 text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">
                {users.customers_heading}
              </h3>
              <ul className="mt-5 grid gap-px border border-ink/10 bg-ink/10 sm:grid-cols-2 lg:grid-cols-3">
                {users.direct.map((name) => (
                  <li key={name} className="bg-white px-6 py-5 text-sm font-semibold tracking-tight">
                    {name}
                  </li>
                ))}
              </ul>
            </>
          ) : null}

          {users.indirect.length > 0 ? (
            <>
              <h3 className="mt-14 text-xs font-semibold uppercase tracking-[0.2em] text-ink/50">
                {users.brands_heading}
              </h3>
              {users.brands_intro ? (
                <p className="mt-4 max-w-3xl text-sm leading-6 text-ink/60">{users.brands_intro}</p>
              ) : null}
              <ul className="mt-5 grid gap-px border border-ink/10 bg-ink/10 sm:grid-cols-2 lg:grid-cols-3">
                {users.indirect.map((name) => (
                  <li key={name} className="bg-white px-6 py-5 text-sm font-semibold tracking-tight">
                    {name}
                  </li>
                ))}
              </ul>
            </>
          ) : null}
        </>
      ) : (
        <p className="mt-12 max-w-3xl text-base leading-7 text-ink/60">
          {users.withheld_note}
        </p>
      )}

      {users.note ? (
        <p className="mt-10 max-w-3xl border-l-2 border-red pl-5 text-sm leading-6 text-ink/60">
          {users.note}
        </p>
      ) : null}
    </Band>
  );
}

/** Quoted customer acknowledgements, with their published period. */
export function Testimonials({
  items,
  heading,
}: {
  items: MetalPartUsers["testimonials"];
  heading?: string;
}) {
  return (
    <Band tone="ink" ariaLabelledBy={heading ? "testimonials-heading" : undefined}>
      <SectionHeading tone="white" title={heading ?? "What others say about us"} id="testimonials-heading" />

      <ul className="mt-14 grid gap-6 md:grid-cols-2">
        {items.map((item) => (
          <li key={item.name} className="border border-white/15 p-8">
            <p className="text-xs font-semibold uppercase tracking-[0.2em] text-red">{item.period}</p>
            <blockquote className="mt-5 text-lg font-medium leading-8 text-white/90">
              {item.quote}
            </blockquote>
            <p className="mt-6 text-sm text-white/50">{item.name}</p>
          </li>
        ))}
      </ul>
    </Band>
  );
}

/** Closing call to action, present at the end of every content page. */
export function ContactCta({
  locale,
  title,
  lead,
  ctaLabel,
  email,
  phone,
}: {
  locale: string;
  title: string;
  lead: string;
  ctaLabel: string;
  email: string;
  phone: string;
}) {
  return (
    <Band tone="ink">
      <div className="grid gap-10 lg:grid-cols-[1.4fr_1fr] lg:items-end">
        <div>
          <h2 className="text-3xl font-black leading-[1.05] tracking-tight text-white sm:text-4xl lg:text-5xl">
            {title}
          </h2>
          <p className="mt-6 max-w-xl text-base leading-7 text-white/60">{lead}</p>
        </div>

        <div className="lg:justify-self-end">
          <Link
            href={`/${locale}/contact`}
            className="group inline-flex items-center gap-3 bg-red px-7 py-4 text-sm font-semibold text-white transition-colors hover:bg-red-hover"
          >
            {ctaLabel}
            <ArrowUpRight
              size={18}
              aria-hidden="true"
              className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
            />
          </Link>

          <address className="mt-6 not-italic text-sm text-white/50">
            <a href={`mailto:${email}`} className="block hover:text-white">
              {email}
            </a>
            <a href={`tel:${phone.replace(/\s/g, "")}`} className="mt-1 block hover:text-white">
              {phone}
            </a>
          </address>
        </div>
      </div>
    </Band>
  );
}

/** Legal clauses (privacy, terms). */
export function Legal({
  clauses,
}: {
  clauses: { heading: string; body: string[] }[];
}) {
  return (
    <Band tone="white">
      <ol className="max-w-3xl space-y-12">
        {clauses.map((clause, index) => (
          <li key={clause.heading}>
            <h2 className="text-xl font-bold tracking-tight">
              <span className="mr-3 tabular-nums text-red">{index + 1}.</span>
              {clause.heading}
            </h2>
            {clause.body.map((paragraph) => (
              <p key={paragraph} className="mt-4 text-sm leading-7 text-ink/70">
                {paragraph}
              </p>
            ))}
          </li>
        ))}
      </ol>
    </Band>
  );
}

/** Text + image prose section, with the optional provenance note. */
export function Prose({
  heading,
  paragraphs,
  image,
  video,
  note,
}: {
  heading?: string;
  paragraphs: string[];
  image?: string;
  video?: string;
  note?: string;
}) {
  return (
    <Band tone="white" ariaLabelledBy={heading ? "prose-heading" : undefined}>
      <div className="grid gap-10 lg:grid-cols-2 lg:gap-16">
        <div>
          <SectionHeading title={heading} id="prose-heading" />
          <div className="mt-8 space-y-5">
            {paragraphs.map((paragraph) => (
              <p key={paragraph} className="text-base leading-8 text-ink/70">
                {paragraph}
              </p>
            ))}
          </div>

          {note ? (
            <p className="mt-8 border-l-2 border-red pl-5 text-sm leading-6 text-ink/60">{note}</p>
          ) : null}
        </div>

        {video ? (
          <div className="aspect-[4/3] overflow-hidden bg-band-lighter lg:aspect-auto lg:min-h-[22rem]">
            <video
              controls
              preload="metadata"
              className="h-full w-full object-cover"
              aria-label={heading}
            >
              <source src={video} type="video/mp4" />
            </video>
          </div>
        ) : image ? (
          <div className="aspect-[4/3] overflow-hidden bg-band-lighter lg:aspect-auto lg:min-h-[22rem]">
            <img
              src={image}
              alt={heading}
              loading="lazy"
              decoding="async"
              className="h-full w-full object-cover"
            />
          </div>
        ) : null}
      </div>
    </Band>
  );
}
