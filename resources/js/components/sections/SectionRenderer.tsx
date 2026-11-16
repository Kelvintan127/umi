/**
 * Section renderer. Maps the `type` of a page section (data from
 * lang/{locale}/pages.php) to a component.
 *
 * Page structure therefore lives in the content files, and adding a section to
 * a page is a content edit — not a component change. An unknown type renders a
 * visible error band instead of silently dropping content.
 */
import type { Content, Section } from "@/types";
import { Cards } from "./Cards";
import { Prose, ContactCta, Legal, Testimonials, Users } from "./Content";
import {
  Certifications,
  Gallery,
  News,
  Policy,
  Process,
  Specs,
  Stats,
} from "./Blocks";

export function SectionRenderer({
  sections,
  content,
  locale,
  cta,
}: {
  sections: Section[];
  content: Content;
  locale: string;
  cta: { title: string; lead: string; label: string };
}) {
  return (
    <>
      {sections.map((section, index) => {
        const key = `${section.type}-${index}`;
        const blocks = content.blocks;

        switch (section.type) {
          case "prose":
            return (
              <Prose
                key={key}
                heading={section.heading}
                paragraphs={section.paragraphs ?? []}
                image={section.image}
                note={section.note}
              />
            );

          case "cards": {
            const items =
              section.source === "capabilities"
                ? blocks.capabilities
                : section.source === "industries"
                  ? blocks.industries
                  : section.source === "products"
                    ? blocks.products
                    : section.source === "quality.principles"
                      ? blocks.quality.principles
                      : [];

            return (
              <Cards
                key={key}
                items={items}
                heading={section.heading}
                locale={locale}
                linkBase={section.link_base}
              />
            );
          }

          case "specs": {
            const items = section.only
              ? blocks.facilities.filter((facility) => facility.key === section.only)
              : section.source === "facilities"
                ? blocks.facilities
                : (section.items ?? []).map((item, i) => ({
                    key: `inline-${i}`,
                    title: item.title,
                    summary: item.summary ?? "",
                    specs: item.specs ?? [],
                    image: "",
                  }));

            return <Specs key={key} items={items} heading={section.heading} />;
          }

          case "certifications":
            return (
              <Certifications
                key={key}
                items={blocks.certifications}
                labelling={blocks.quality.labelling}
                heading={section.heading}
              />
            );

          case "policy":
            return <Policy key={key} policy={blocks.policy} />;

          case "stats":
            return <Stats key={key} stats={blocks.stats} />;

          case "process":
            return <Process key={key} stages={blocks.process} heading={section.heading} />;

          case "gallery":
            return <Gallery key={key} items={blocks.gallery} heading={section.heading} />;

          case "news":
            return <News key={key} items={blocks.news} heading={section.heading} />;

          case "users":
            return <Users key={key} users={blocks.users} />;

          case "testimonials":
            return <Testimonials key={key} items={blocks.users.testimonials} />;

          case "legal":
            return <Legal key={key} clauses={section.clauses ?? []} />;

          case "cta":
            return (
              <ContactCta
                key={key}
                locale={locale}
                title={cta.title}
                lead={cta.lead}
                ctaLabel={cta.label}
                email={blocks.contact.email}
                phone={blocks.contact.phone}
              />
            );

          default:
            return (
              <section key={key} className="border-y border-red/40 bg-red/5 px-5 py-10">
                <p className="mx-auto max-w-[1400px] text-sm font-semibold text-red">
                  Unknown section type: {section.type}
                </p>
              </section>
            );
        }
      })}
    </>
  );
}
