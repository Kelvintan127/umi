import { usePage } from "@inertiajs/react";
import { AppShell } from "@/components/layout/AppShell";
import { PageHead } from "@/components/layout/PageHead";
import { Hero } from "@/components/sections/Hero";
import { Band, SectionHeading } from "@/components/sections/Band";
import { ContactDetails } from "@/components/sections/Cards";
import { ContactForm } from "@/components/sections/ContactForm";
import type { PageProps } from "@/types";

/**
 * Contact page: the two real locations, the direct contact routes, and the
 * inquiry form. Distinct from ContentPage because the form is a client
 * component with its own state, not content driven by a section list.
 */
export default function Contact() {
  const { content, locale, chrome, breadcrumbs, seo, htmlLang, form, flash } = usePage<PageProps>().props;
  const contact = content.blocks.contact;

  return (
    <AppShell>
      <PageHead seo={seo} htmlLang={htmlLang} />

      <Hero
        hero={content.hero}
        locale={locale}
        ctaLabels={{ quote: chrome.cta.quote, capabilities: chrome.cta.capabilities }}
        breadcrumbs={breadcrumbs}
        breadcrumbLabel={chrome.aria.breadcrumb}
      />

      <Band tone="white" ariaLabelledBy="locations-heading">
        <SectionHeading
          eyebrow={chrome.contactPage.locationsEyebrow}
          title={chrome.contactPage.locationsTitle}
          id="locations-heading"
        />
        <div className="mt-14">
          <ContactDetails
            contact={contact}
            labels={{
              email: chrome.contactPage.email,
              phone: chrome.contactPage.phone,
              location: chrome.contactPage.location,
              map: chrome.contactPage.viewMap,
            }}
          />
        </div>
      </Band>

      <ContactForm
        locale={locale}
        labels={form}
        contact={contact}
        flash={flash}
      />
    </AppShell>
  );
}
