import { Band, SectionHeading } from "./Band";
import type {
  Certification,
  ContentBlocks,
  GalleryItem,
  NewsItem,
  ProcessStage,
  Stat,
} from "@/types";

/**
 * The shape Specs renders. Wider than Facility on purpose: a page may declare
 * its spec groups inline in pages.php instead of reusing the facility list.
 */
export interface SpecItem {
  key: string;
  title: string;
  summary: string;
  specs: string[];
  image: string;
}

/** Numbered headline figures. Sourced from lang/{locale}/site.php `stats`. */
export function Stats({ stats }: { stats: Stat[] }) {
  return (
    <Band tone="ink">
      <dl className="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
        {stats.map((stat) => (
          <div key={stat.label}>
            <dt className="sr-only">{stat.label}</dt>
            <dd>
              <span className="block text-4xl font-black tracking-tight text-white sm:text-5xl">
                {stat.value}
              </span>
              <span className="mt-3 block text-sm leading-6 text-white/60">{stat.label}</span>
            </dd>
          </div>
        ))}
      </dl>
    </Band>
  );
}

/** The six-stage workflow. */
export function Process({ stages, heading }: { stages: ProcessStage[]; heading?: string }) {
  return (
    <Band tone="white">
      <SectionHeading title={heading} />
      <ol className="mt-14 grid gap-px overflow-hidden border border-ink/10 bg-ink/10 sm:grid-cols-2 lg:grid-cols-3">
        {stages.map((stage, index) => (
          <li key={stage.title} className="bg-white p-8">
            <span className="text-xs font-semibold tabular-nums tracking-[0.2em] text-red">
              {String(index + 1).padStart(2, "0")}
            </span>
            <h3 className="mt-4 text-lg font-bold tracking-tight">{stage.title}</h3>
            <p className="mt-3 text-sm leading-6 text-ink/60">{stage.description}</p>
          </li>
        ))}
      </ol>
    </Band>
  );
}

/** Equipment groups: title, summary, spec list, image. */
export function Specs({ items, heading }: { items: SpecItem[]; heading?: string }) {
  const headingId = "specs-heading";

  return (
    <Band tone="light" ariaLabelledBy={heading ? headingId : undefined}>
      <SectionHeading title={heading} id={headingId} />

      <div className="mt-14 space-y-16">
        {items.map((facility) => (
          <section key={facility.key} aria-labelledby={`facility-${facility.key}`}>
            <div className="grid gap-8 lg:grid-cols-2 lg:gap-14">
              <div>
                <h3 id={`facility-${facility.key}`} className="text-2xl font-black tracking-tight">
                  {facility.title}
                </h3>
                <p className="mt-4 text-sm leading-7 text-ink/60">{facility.summary}</p>

                {facility.specs.length > 0 ? (
                  <ul className="mt-6 space-y-2.5">
                    {facility.specs.map((spec) => (
                      <li key={spec} className="flex gap-3 text-sm leading-6 text-ink/75">
                        <span aria-hidden="true" className="mt-2.5 h-1 w-3 shrink-0 bg-red" />
                        {spec}
                      </li>
                    ))}
                  </ul>
                ) : null}
              </div>

              {facility.image ? (
                <div className="aspect-[4/3] overflow-hidden bg-band-lighter">
                  <img
                    src={facility.image}
                    alt={facility.title}
                    loading="lazy"
                    decoding="async"
                    className="h-full w-full object-cover"
                  />
                </div>
              ) : null}
            </div>
          </section>
        ))}
      </div>
    </Band>
  );
}

/** Certification cards. The `labelling` note is rendered whenever it is set. */
export function Certifications({
  items,
  labelling,
  heading,
}: {
  items: Certification[];
  labelling?: string;
  heading?: string;
}) {
  const headingId = "certifications-heading";

  return (
    <Band tone="white" ariaLabelledBy={heading ? headingId : undefined}>
      <SectionHeading title={heading} id={headingId} />

      <ul className="mt-14 grid gap-6 lg:grid-cols-3">
        {items.map((cert) => (
          <li key={cert.name} className="flex flex-col border border-ink/10 p-8">
            <p className="text-xs font-semibold uppercase tracking-[0.2em] text-red">{cert.name}</p>
            <h3 className="mt-4 text-lg font-bold tracking-tight">{cert.title}</h3>
            <p className="mt-3 flex-1 text-sm leading-6 text-ink/60">{cert.description}</p>

            {cert.image ? (
              <a
                href={cert.image}
                className="group mt-6 block"
                target="_blank"
                rel="noreferrer"
              >
                <span className="block aspect-[3/4] overflow-hidden border border-ink/10 bg-band-lighter">
                  <img
                    src={cert.image}
                    alt={`${cert.name} certificate`}
                    loading="lazy"
                    decoding="async"
                    className="h-full w-full object-contain transition-transform duration-500 group-hover:scale-[1.02]"
                  />
                </span>
                <span className="mt-3 inline-block text-sm font-semibold text-ink underline decoration-red decoration-2 underline-offset-4 group-hover:text-red">
                  View certificate
                  <span className="sr-only"> — {cert.name}</span>
                </span>
              </a>
            ) : null}
          </li>
        ))}
      </ul>

      {labelling ? (
        <p className="mt-10 max-w-3xl border-l-2 border-red pl-5 text-sm leading-6 text-ink/60">
          {labelling}
        </p>
      ) : null}
    </Band>
  );
}

/** The published quality and environmental policy, as an ordered commitment list. */
export function Policy({
  policy,
  heading,
}: {
  policy: ContentBlocks["policy"];
  heading?: string;
}) {
  return (
    <Band tone="white">
      <SectionHeading title={heading ?? policy.heading} />
      <p className="mt-8 text-base text-ink/60">{policy.intro}</p>

      <ol className="mt-10 grid gap-px border border-ink/10 bg-ink/10 md:grid-cols-2">
        {policy.items.map((item, index) => (
          <li key={item} className="flex gap-5 bg-white p-7">
            <span className="text-sm font-semibold tabular-nums text-red">
              {String(index + 1).padStart(2, "0")}
            </span>
            <p className="text-sm leading-6 text-ink/75">{item}</p>
          </li>
        ))}
      </ol>
    </Band>
  );
}

/** Factory gallery grid. */
export function Gallery({ items, heading }: { items: GalleryItem[]; heading?: string }) {
  return (
    <Band tone="light" ariaLabelledBy={heading ? "gallery-heading" : undefined}>
      <SectionHeading title={heading} id="gallery-heading" />

      <ul className="mt-14 grid gap-4 sm:grid-cols-2">
        {items.map((item, index) => (
          <li key={`${item.title}-${index}`} className={index === 0 ? "sm:col-span-2" : undefined}>
            <figure className="group relative overflow-hidden bg-band-lighter">
              <img
                src={item.image}
                alt={item.title}
                loading="lazy"
                decoding="async"
                className={`w-full object-cover transition-transform duration-500 group-hover:scale-[1.03] ${
                  index === 0 ? "aspect-[21/9]" : "aspect-[4/3]"
                }`}
              />
              <figcaption className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink/85 to-transparent p-6">
                <span className="block text-xs font-semibold uppercase tracking-[0.18em] text-white/70">
                  {item.label}
                </span>
                <span className="mt-1 block text-lg font-bold text-white">{item.title}</span>
              </figcaption>
            </figure>
          </li>
        ))}
      </ul>
    </Band>
  );
}

/** News items. Dates are shown as published, not reformatted into a false precision. */
export function News({ items, heading }: { items: NewsItem[]; heading?: string }) {
  return (
    <Band tone="white" ariaLabelledBy={heading ? "news-heading" : undefined}>
      <SectionHeading title={heading} id="news-heading" />

      <ul className="mt-14 divide-y divide-ink/10 border-y border-ink/10">
        {items.map((item, index) => (
          <li key={`${item.title}-${index}`} className="grid gap-3 py-8 md:grid-cols-[8rem_1fr]">
            <p className="text-sm font-semibold tabular-nums text-red">{item.date}</p>
            <div>
              <h3 className="text-lg font-bold tracking-tight">{item.title}</h3>
              <p className="mt-2 text-sm leading-6 text-ink/60">{item.excerpt}</p>
            </div>
          </li>
        ))}
      </ul>
    </Band>
  );
}
