import { Link, useForm, usePage } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { ArrowUpRight, CheckCircle2 } from "lucide-react";
import { Band, SectionHeading } from "../sections/Band";
import type { ContactBlock, FormLabels, PageProps } from "@/types";

interface FormValues {
  name: string;
  company: string;
  email: string;
  phone: string;
  inquiry_type: string;
  message: string;
  consent: boolean;
  website: string;
  elapsed_ms: number;
}

/**
 * Inquiry form.
 *
 * Anti-spam is server-side (honeypot + submit timing + route throttle); the two
 * hidden inputs here are the client half of it. `elapsed_ms` is measured from
 * first interaction, and a value under 1.2 s is rejected by ContactController —
 * which is why the initial value is a timestamp, not a counter.
 *
 * A 422 is rendered per-field and announced via aria-live; a network failure
 * leaves the typed values intact rather than clearing the form.
 */
export function ContactForm({
  locale,
  labels,
  contact,
  flash,
}: {
  locale: string;
  labels: FormLabels;
  contact: ContactBlock;
  flash?: PageProps["flash"];
}) {
  const [sent, setSent] = useState(flash?.inquiry?.ok === true);

  // When the form became visible, used for the server's minimum-submit-time
  // check. A ref set on mount, not Date.now() in render: a render-time
  // timestamp is recomputed on every keystroke, which would reset the clock and
  // make a real submission look instant.
  const startedAt = useRef(0);
  useEffect(() => {
    startedAt.current = Date.now();
  }, []);

  const form = useForm<FormValues>({
    name: "",
    company: "",
    email: "",
    phone: "",
    inquiry_type: "new-project",
    message: "",
    consent: false,
    website: "",
    elapsed_ms: 0,
  });

  const submit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    form.transform((data) => ({
      ...data,
      elapsed_ms: startedAt.current > 0 ? Math.round(Date.now() - startedAt.current) : 0,
    }));
    form.post(`/${locale}/contact`, {
      preserveScroll: true,
      onSuccess: () => setSent(true),
    });
  };

  if (sent) {
    return (
      <Band tone="light">
        <div className="flex flex-col items-start gap-5 border border-ink/10 bg-white p-10">
          <CheckCircle2 size={32} className="text-red" aria-hidden="true" />
          <h2 className="text-2xl font-black tracking-tight">{labels.successTitle}</h2>
          <p className="max-w-xl text-sm leading-6 text-ink/60">
            {flash?.inquiry?.message ?? labels.successBody}
          </p>
          <button
            type="button"
            onClick={() => {
              setSent(false);
              form.reset();
            }}
            className="mt-2 text-sm font-semibold text-red underline underline-offset-4"
          >
            {labels.successAgain}
          </button>
        </div>
      </Band>
    );
  }

  const fieldClass =
    "mt-2 w-full border border-ink/15 bg-white px-4 py-3 text-sm text-ink placeholder:text-ink/35 focus:border-ink focus:outline-none aria-[invalid=true]:border-red";

  const errorText = (key: keyof FormValues) =>
    form.errors[key] ? <p className="mt-1.5 text-xs font-medium text-red">{form.errors[key]}</p> : null;

  return (
    <Band tone="light" ariaLabelledBy="form-heading">
      <SectionHeading title={labels.title} id="form-heading" />
      <p className="mt-4 text-sm text-ink/60">{labels.intro}</p>

      <form onSubmit={submit} noValidate className="mt-10 max-w-3xl">
        {/* Honeypot: visually hidden and excluded from the a11y tree + tab order. */}
        <div className="sr-only" aria-hidden="true">
          <label htmlFor="website">Website</label>
          <input
            id="website"
            name="website"
            type="text"
            tabIndex={-1}
            autoComplete="off"
            value={form.data.website}
            onChange={(e) => form.setData("website", e.target.value)}
          />
        </div>

        <div className="grid gap-6 sm:grid-cols-2">
          <div>
            <label htmlFor="name" className="text-sm font-medium">
              {labels.fields.name} <span className="text-red">*</span>
            </label>
            <input
              id="name"
              name="name"
              type="text"
              required
              autoComplete="name"
              aria-invalid={Boolean(form.errors.name)}
              aria-describedby={form.errors.name ? "name-error" : undefined}
              placeholder={labels.placeholders.name}
              className={fieldClass}
              value={form.data.name}
              onChange={(e) => form.setData("name", e.target.value)}
            />
            <div id="name-error">{errorText("name")}</div>
          </div>

          <div>
            <label htmlFor="company" className="text-sm font-medium">
              {labels.fields.company}
            </label>
            <input
              id="company"
              name="company"
              type="text"
              autoComplete="organization"
              placeholder={labels.placeholders.company}
              className={fieldClass}
              value={form.data.company}
              onChange={(e) => form.setData("company", e.target.value)}
            />
            {errorText("company")}
          </div>

          <div>
            <label htmlFor="email" className="text-sm font-medium">
              {labels.fields.email} <span className="text-red">*</span>
            </label>
            <input
              id="email"
              name="email"
              type="email"
              required
              autoComplete="email"
              aria-invalid={Boolean(form.errors.email)}
              aria-describedby={form.errors.email ? "email-error" : undefined}
              placeholder={labels.placeholders.email}
              className={fieldClass}
              value={form.data.email}
              onChange={(e) => form.setData("email", e.target.value)}
            />
            <div id="email-error">{errorText("email")}</div>
          </div>

          <div>
            <label htmlFor="phone" className="text-sm font-medium">
              {labels.fields.phone}
            </label>
            <input
              id="phone"
              name="phone"
              type="tel"
              autoComplete="tel"
              placeholder={labels.placeholders.phone}
              className={fieldClass}
              value={form.data.phone}
              onChange={(e) => form.setData("phone", e.target.value)}
            />
            {errorText("phone")}
          </div>

          <div className="sm:col-span-2">
            <label htmlFor="inquiry_type" className="text-sm font-medium">
              {labels.fields.inquiryType} <span className="text-red">*</span>
            </label>
            <select
              id="inquiry_type"
              name="inquiry_type"
              required
              className={fieldClass}
              value={form.data.inquiry_type}
              onChange={(e) => form.setData("inquiry_type", e.target.value)}
            >
              {Object.entries(labels.inquiryTypes).map(([value, label]) => (
                <option key={value} value={value}>
                  {label}
                </option>
              ))}
            </select>
            {errorText("inquiry_type")}
          </div>

          <div className="sm:col-span-2">
            <label htmlFor="message" className="text-sm font-medium">
              {labels.fields.message} <span className="text-red">*</span>
            </label>
            <textarea
              id="message"
              name="message"
              required
              rows={6}
              aria-invalid={Boolean(form.errors.message)}
              aria-describedby={form.errors.message ? "message-error" : undefined}
              placeholder={labels.placeholders.message}
              className={fieldClass}
              value={form.data.message}
              onChange={(e) => form.setData("message", e.target.value)}
            />
            <div id="message-error">{errorText("message")}</div>
          </div>
        </div>

        <div className="mt-6 flex items-start gap-3">
          <input
            id="consent"
            name="consent"
            type="checkbox"
            required
            className="mt-1 h-4 w-4 accent-red"
            checked={form.data.consent}
            onChange={(e) => form.setData("consent", e.target.checked)}
          />
          <label htmlFor="consent" className="text-sm leading-6 text-ink/70">
            {labels.consent}
          </label>
        </div>
        {errorText("consent")}

        <div aria-live="polite" className="mt-6">
          {form.errors.consent === undefined && Object.keys(form.errors).length > 0 ? (
            <p className="text-sm font-medium text-red">{labels.errorsTitle}</p>
          ) : null}
        </div>

        <button
          type="submit"
          disabled={form.processing}
          className="group mt-8 inline-flex items-center gap-2 bg-red px-7 py-4 text-sm font-semibold text-white transition-colors hover:bg-red-hover disabled:cursor-not-allowed disabled:opacity-60"
        >
          {form.processing ? labels.submitting : labels.submit}
          <ArrowUpRight
            size={18}
            aria-hidden="true"
            className="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
          />
        </button>

        <p className="mt-6 text-xs leading-5 text-ink/50">
          {labels.fields.email}:{" "}
          <a href={`mailto:${contact.email}`} className="underline underline-offset-2">
            {contact.email}
          </a>
        </p>

        <p className="mt-2 text-xs leading-5 text-ink/50">
          <Link href={`/${locale}/privacy`} className="underline underline-offset-2">
            {labels.privacy}
          </Link>
        </p>
      </form>
    </Band>
  );
}
