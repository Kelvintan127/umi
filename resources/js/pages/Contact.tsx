import { Link, useForm, usePage } from "@inertiajs/react";
import { ArrowRight, ArrowUpRight, CheckCircle2, Clock3, Mail, MapPin, Phone, ShieldCheck } from "lucide-react";
import { useEffect, useRef, useState, type FormEvent } from "react";
import { MockupShell } from "@/components/layout/MockupShell";
import { PageHead } from "@/components/layout/PageHead";
import type { PageProps } from "@/types";

type InquiryFields = {
  name: string; company: string; email: string; phone: string;
  inquiry_type: string; message: string; consent: boolean;
  website: string; elapsed_ms: number;
};

function QuoteForm({ locale, props }: { locale: string; props: PageProps }) {
  const { form: labels, flash } = props;
  const [sent, setSent] = useState(flash?.inquiry?.ok === true);
  const [material, setMaterial] = useState("");
  const [thickness, setThickness] = useState("");
  const [quantity, setQuantity] = useState("");
  const startedAt = useRef(0);
  useEffect(() => { startedAt.current = Date.now(); }, []);
  const types = Object.entries(labels.inquiryTypes);
  const form = useForm<InquiryFields>({
    name: "", company: "", email: "", phone: "",
    inquiry_type: types[0]?.[0] ?? "new-project", message: "",
    consent: false, website: "", elapsed_ms: 0,
  });
  const submit = (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    form.transform(data => ({
      ...data,
      message: [data.message, material && "Material: " + material, thickness && "Thickness: " + thickness + " mm", quantity && "Annual quantity: " + quantity].filter(Boolean).join("\n"),
      elapsed_ms: startedAt.current ? Date.now() - startedAt.current : 0,
    }));
    form.post("/" + locale + "/contact", {
      preserveScroll: true,
      onSuccess: (page) => {
        const result = (page.props as unknown as PageProps).flash?.inquiry;
        if (result?.ok) setSent(true);
      },
    });
  };
  const field = "mt-2 block w-full rounded border border-[#b6c2cc] bg-white px-4 py-3 text-sm text-[#071522] outline-offset-2 focus:border-[#d71920]";
  const msg = (key: keyof InquiryFields) => form.errors[key] && <p role="alert" className="mt-1 text-xs font-semibold text-[#d71920]">{form.errors[key]}</p>;

  return <div className="rounded-lg border border-[#d8e0e7] bg-white p-5 shadow-sm sm:p-8">
    <div className="umi-mark"/><div className="flex flex-wrap items-center justify-between gap-4">
      <h2 className="umi-heading">{labels.title}</h2><span className="text-[10px] font-bold uppercase tracking-widest text-[#667484]">01 Contact · 02 Project · 03 Send</span>
    </div>
    {sent ? <div role="status" className="mt-8 rounded border border-[#a8caba] bg-[#f0faf5] p-6">
      <CheckCircle2 className="text-[#297f53]"/><h3 className="mt-3 text-xl font-bold">{labels.successTitle}</h3>
      <p className="mt-2 text-sm">{flash?.inquiry?.message ?? labels.successBody}</p>
      <button type="button" className="mt-4 text-sm font-bold text-[#d71920] underline" onClick={() => { setSent(false); form.reset(); }}>{labels.successAgain}</button>
    </div> : <form className="mt-7" onSubmit={submit} noValidate>
      <div className="hidden" aria-hidden="true"><label htmlFor="umi-website">Website</label><input id="umi-website" tabIndex={-1} autoComplete="off" value={form.data.website} onChange={e => form.setData("website", e.target.value)}/></div>
      <h3 className="flex items-center gap-3 border-b border-[#e3e8ec] pb-3 text-lg font-black">
        <span className="rounded bg-[#d71920] px-2 py-1 text-xs text-white">01</span> {locale === "id" ? "Detail kontak" : locale === "zh" ? "联系方式" : "Contact details"}
      </h3>
      <div className="mt-4 grid gap-5 md:grid-cols-2">
        <label className="text-sm font-semibold">{labels.fields.name} *<input autoComplete="name" className={field} value={form.data.name} required onChange={e => form.setData("name", e.target.value)}/>{msg("name")}</label>
        <label className="text-sm font-semibold">{labels.fields.company}<input autoComplete="organization" className={field} value={form.data.company} onChange={e => form.setData("company", e.target.value)}/>{msg("company")}</label>
        <label className="text-sm font-semibold">{labels.fields.email} *<input autoComplete="email" type="email" className={field} value={form.data.email} required onChange={e => form.setData("email", e.target.value)}/>{msg("email")}</label>
        <label className="text-sm font-semibold">{labels.fields.phone}<input autoComplete="tel" className={field} value={form.data.phone} onChange={e => form.setData("phone", e.target.value)}/>{msg("phone")}</label>
      </div>
      <h3 className="mt-8 flex items-center gap-3 border-b border-[#e3e8ec] pb-3 text-lg font-black">
        <span className="rounded bg-[#d71920] px-2 py-1 text-xs text-white">02</span> {locale === "id" ? "Proyek" : locale === "zh" ? "项目" : "Project"}
      </h3>
      <fieldset className="mt-5">
        <legend className="mb-3 text-sm font-semibold">{labels.fields.inquiryType} *</legend>
        <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
          {types.map(([value, label]) => <label key={value} className={"flex cursor-pointer items-center gap-2 rounded border px-3 py-3 text-xs font-semibold " + (form.data.inquiry_type === value ? "border-[#d71920] bg-[#fff2f2] text-[#d71920]" : "border-[#cbd3dc]")}>
            <input type="radio" name="inquiry_type" value={value} checked={form.data.inquiry_type === value} onChange={() => form.setData("inquiry_type", value)} className="accent-[#d71920]"/>{label}
          </label>)}
        </div>
        {msg("inquiry_type")}
      </fieldset>
      <div className="mt-5 grid gap-4 sm:grid-cols-3">
        <label className="text-xs font-bold">Material
          <select value={material} onChange={e => setMaterial(e.target.value)} className={field}>
            <option value="">Select material</option>
            {["Stainless steel", "Copper", "Brass", "Aluminium", "Carbon steel", "Other / to be advised"].map(v => <option key={v} value={v}>{v}</option>)}
          </select>
        </label>
        <label className="text-xs font-bold">Thickness (mm)
          <select value={thickness} onChange={e => setThickness(e.target.value)} className={field}>
            <option value="">Select thickness</option>
            {["0.10", "0.20", "0.30", "0.50", "0.80", "1.00", "1.50", "2.00", "To be advised"].map(v => <option key={v} value={v}>{v}</option>)}
          </select>
        </label>
        <label className="text-xs font-bold">Annual quantity
          <select value={quantity} onChange={e => setQuantity(e.target.value)} className={field}>
            <option value="">Select quantity</option>
            {["Under 10,000", "10,000–50,000", "50,001–100,000", "100,001–500,000", "500,000+", "To be advised"].map(v => <option key={v} value={v}>{v}</option>)}
          </select>
        </label>
      </div>
      <label className="mt-6 block text-sm font-semibold">{labels.fields.message} *<textarea rows={6} className={field} value={form.data.message} required onChange={e => form.setData("message", e.target.value)} placeholder={labels.placeholders.message}/>{msg("message")}</label>
      <div className="mt-6 rounded-lg border border-dashed border-[#aab8c5] bg-[#fafbfc] px-5 py-7 text-center text-sm">
        <p className="font-bold">{locale === "id" ? "Punya gambar teknik?" : locale === "zh" ? "有技术图纸吗？" : "Have technical drawings?"}</p>
        <p className="mt-2 text-xs text-[#5e6e7c]">CAD/PDF file upload requires backend integration. Please mention the drawings in your inquiry or email them to the office.</p>
        <a href={"mailto:" + props.content.blocks.contact.email} className="mt-3 inline-block text-xs font-bold text-[#d71920] underline">{props.content.blocks.contact.email}</a>
      </div>
      <label className="mt-6 flex items-start gap-3 text-sm leading-6">
        <input type="checkbox" required checked={form.data.consent} onChange={e => form.setData("consent", e.target.checked)} className="mt-1 accent-[#d71920]"/>
        <span>{labels.consent}</span>
      </label>{msg("consent")}
      {Object.keys(form.errors).length > 0 && <p className="mt-3 text-sm font-bold text-[#d71920]" role="alert">{labels.errorsTitle}</p>}
      <button type="submit" disabled={form.processing || !form.data.consent}
        className="umi-btn-red mt-7 flex w-full items-center justify-center gap-2 rounded py-4 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-50">
        {form.processing ? labels.submitting : labels.submit}<ArrowRight size={18}/>
      </button>
      <p className="mt-4 text-center text-xs text-[#6e7b89]">{labels.fields.email}: {props.content.blocks.contact.email}</p>
    </form>}
  </div>;
}

export default function Contact() {
  const props = usePage<PageProps>().props;
  const { locale, seo, htmlLang, content } = props;
  const { contact } = content.blocks;
  const [location, setLocation] = useState(0);
  const primary = contact.batam;
  const secondary = (contact as typeof contact & { jakarta?: {label: string; lines: string[]; map?: string} }).jakarta;
  const locations = [
    { label: primary.label, address: primary.lines.join(", "), map: primary.map, query: "Kara Industrial Park Batam Center Indonesia" },
    { label: secondary?.label ?? "Jakarta Sales Office", address: secondary?.lines.join(", ") ?? "Jababeka Industrial Park, Indonesia", map: secondary?.map, query: "Jababeka Industrial Park Cikarang Indonesia" },
  ];
  const selected = locations[location];
  const mapSearch = "https://www.google.com/maps/search/?api=1&query=" + encodeURIComponent(selected.query);
  const headline = locale === "id" ? "Ada komponen yang ingin diproduksi?" : locale === "zh" ? "有零件需要生产？" : "Have a part to manufacture?";
  const intro = locale === "id" ? "Kirim kebutuhan dan gambar teknik Anda. Tim kami akan meninjau kelayakan, tooling, dan harga." : locale === "zh" ? "向我们发送图纸和要求。我们的团队将评估可制造性、模具及报价。" : "Send us your requirements. Our team will review feasibility, tooling and pricing.";

  return <MockupShell active="contact">
    <PageHead seo={seo} htmlLang={htmlLang}/>
    <section className="umi-hero umi-blueprint-lines overflow-hidden bg-[#071522] text-white">
      <div className="mx-auto grid max-w-[1400px] gap-8 px-5 py-14 sm:px-8 lg:grid-cols-2 xl:px-10">
        <div><p className="mb-4 text-xs uppercase tracking-wider text-white/65"><Link href={"/" + locale}>Home</Link> / Contact</p>
          <p className="mb-2 text-xs font-bold uppercase tracking-widest text-[#fa4951]">Contact · Request for quotation</p>
          <h1 className="max-w-xl text-4xl font-black leading-tight tracking-[-0.045em] sm:text-5xl">{headline}</h1>
          <p className="mt-5 max-w-xl text-base leading-7 text-white/80">{intro}</p>
        </div>
        <div className="relative flex min-h-[215px] items-center justify-center text-white/60">
          <svg viewBox="0 0 500 250" className="w-full max-w-lg" role="img" aria-label="Technical drawing of a precision formed metal bracket">
            <g fill="none" stroke="currentColor" strokeWidth="2.2">
              <path d="M55 100Q55 80 75 80H125L145 53H195V35H255V53H314Q333 53 334 75V80H407Q430 80 430 102V152Q430 170 412 170H342V195H287V170H154V191H101V170H77Q55 170 55 147Z"/>
              <circle cx="240" cy="125" r="57"/><circle cx="240" cy="125" r="43"/><circle cx="240" cy="125" r="6"/>
              <rect x="77" y="115" width="17" height="33" rx="8"/><rect x="390" y="115" width="17" height="33" rx="8"/>
              <path strokeDasharray="6 6" opacity=".55" d="M240 20V220M30 125H455"/>
              <path d="M55 36V23H430V36M55 23H430M455 80H475V170H455"/>
            </g>
            <g fill="currentColor" fontSize="15" fontWeight="600"><text x="218" y="17">24.50</text><text x="461" y="125" transform="rotate(90 461 125)">12.00</text></g>
          </svg>
        </div>
      </div>
    </section>
    <section className="py-14 lg:py-18">
      <div className="mx-auto grid max-w-[1400px] items-start gap-6 px-5 sm:px-8 lg:grid-cols-[1.6fr_1fr] xl:px-10">
        <QuoteForm locale={locale} props={props}/>
        <aside className="space-y-4">
          <section className="rounded-lg bg-[#071522] p-6 text-white sm:p-8">
            <p className="text-xs font-black uppercase tracking-widest text-[#ed3841]">HQ / Factory</p>
            <h2 className="mt-2 text-2xl font-black">{primary.label}</h2>
            <p className="mt-5 flex items-start gap-3 text-sm leading-6"><MapPin size={18} className="shrink-0"/>{primary.lines.join(", ")}</p>
            <a className="mt-4 flex items-center gap-3 border-t border-white/20 pt-4 text-sm" href={"tel:" + primary.phone}><Phone size={18}/>{primary.phone}</a>
            <a className="mt-4 flex items-center gap-3 border-t border-white/20 pt-4 text-sm" href={"mailto:" + contact.email}><Mail size={18}/>{contact.email}</a>
            <a href={primary.map || mapSearch} rel="noopener noreferrer" target="_blank" className="mt-5 inline-flex items-center gap-2 text-sm font-black text-[#f44850]">Get directions <ArrowRight size={16}/></a>
          </section>
          <section className="rounded-lg border border-[#d8e0e7] p-6"><div className="umi-mark"/>
            <p className="text-xs font-bold uppercase text-[#d71920]">Sales office</p>
            <h2 className="mt-2 text-xl font-black">{locations[1].label}</h2>
            <p className="mt-4 flex items-start gap-3 text-sm leading-6 text-[#596a7b]"><MapPin size={18}/>{locations[1].address}</p></section>
          <section className="rounded-lg border border-[#d8e0e7] p-6"><div className="umi-mark"/>
            <h2 className="text-xl font-black">Office hours</h2><p className="mt-4 flex items-center gap-3 text-sm text-[#596a7b]"><Clock3 size={18}/>Contact the office to confirm visiting hours</p></section>
          <section className="rounded-lg border border-[#d8e0e7] p-6"><div className="umi-mark"/>
            <h2 className="text-xl font-black">Management systems</h2><p className="mt-4 flex items-center gap-3 text-sm text-[#596a7b]"><ShieldCheck size={18}/>ISO 9001:2015 · Environmental management</p>
            <p className="mt-3 text-xs text-[#798696]">{content.blocks.quality.labelling}</p></section>
        </aside>
      </div>
    </section>
    <section className="bg-[#f6f8fa] py-14 lg:py-18"><div className="mx-auto max-w-[1400px] px-5 sm:px-8 xl:px-10">
      <div className="flex flex-wrap items-end justify-between gap-6"><div><div className="umi-mark"/><h2 className="umi-heading">Find us</h2>
        <p className="mt-2 text-sm text-[#566578]">Batam Factory and Jakarta Sales Office.</p></div>
        <div className="flex border-b border-[#cbd5df]" role="tablist" aria-label="Office locations">
          {locations.map((item, index) => <button type="button" role="tab" aria-controls="umi-map-panel" aria-selected={location === index} key={index}
            onClick={() => setLocation(index)} className={"px-4 py-3 text-sm font-bold " + (location === index ? "border-b-4 border-[#d71920] text-[#d71920]" : "text-[#5c6a77]")}>
            {String(index + 1).padStart(2, "0")} {item.label}</button>)}
        </div>
      </div>
      <div id="umi-map-panel" role="tabpanel" className="relative mt-7 h-[380px] overflow-hidden rounded-lg border border-[#ccd6de] bg-[#dce6eb] lg:h-[430px]">
        <iframe key={selected.query} title={selected.label + " map"} loading="lazy" referrerPolicy="no-referrer-when-downgrade"
          src={"https://maps.google.com/maps?q=" + encodeURIComponent(selected.query) + "&z=13&output=embed"} className="h-full w-full border-0"/>
        <div className="absolute bottom-5 left-5 max-w-[330px] rounded-lg bg-white/95 p-5 shadow-lg backdrop-blur">
          <p className="text-xs font-black uppercase tracking-widest text-[#d71920]">{location === 0 ? "HQ / Factory" : "Sales Office"}</p>
          <h3 className="mt-1 text-lg font-black">{selected.label}</h3>
          <p className="mt-3 flex items-start gap-2 text-xs leading-5 text-[#536171]"><MapPin size={16} className="shrink-0"/>{selected.address}</p>
          <a href={selected.map || mapSearch} target="_blank" rel="noopener noreferrer" className="umi-btn-red mt-4 inline-flex items-center gap-2 rounded px-4 py-3 text-xs font-bold text-white">Get directions<ArrowUpRight size={16}/></a>
        </div>
      </div>
    </div></section>
    <section className="border-y border-[#dce3ea] bg-[#f5f7f9] py-9">
      <div className="mx-auto grid max-w-[1400px] gap-6 px-5 sm:px-8 md:grid-cols-3 xl:px-10">
        {[
          ["01", "What do you need for a quote?", "A drawing or sample, material, thickness and estimated quantity."],
          ["02", "Do you make prototypes?", "Yes, we can discuss prototyping before mass-production tooling."],
          ["03", "Which industries do you serve?", "Electrical, electronics and automotive manufacturers."],
        ].map(([n, title, desc]) => <div key={n} className="flex gap-4 border-[#cad4df] md:border-r md:pr-5 md:last:border-r-0">
          <strong className="text-base font-black text-[#d71920]">{n}</strong>
          <div><h3 className="text-sm font-black">{title}</h3><p className="mt-2 text-xs leading-5 text-[#566578]">{desc}</p></div>
        </div>)}
      </div>
    </section>
    <section className="bg-[#071522] py-9 text-white"><div className="mx-auto flex max-w-[1400px] flex-wrap items-center justify-between gap-6 px-5 sm:px-8 xl:px-10">
      <h2 className="text-2xl font-black sm:text-3xl">{headline}</h2>
      <a href={"mailto:" + contact.email} className="umi-btn-red inline-flex items-center gap-2 rounded px-6 py-3 text-sm font-bold">Talk to Our Team <ArrowRight size={16}/></a>
      <span className="text-sm text-white/70">{contact.email}</span>
    </div></section>
  </MockupShell>;
}
