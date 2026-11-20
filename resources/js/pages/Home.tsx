import { Link, usePage } from "@inertiajs/react";
import { ArrowRight, ArrowUpRight, Play, X } from "lucide-react";
import { MockupCrop, type MockupCropKey } from "@/components/media/MockupCrop";
import { useState } from "react";
import { MockupShell } from "@/components/layout/MockupShell";
import { PageHead } from "@/components/layout/PageHead";
import type { PageProps } from "@/types";

const copy = {
  en: {
    eyebrow: "PRECISION METAL STAMPING — BATAM, INDONESIA",
    title: "Precision.\nManufacturing\nexcellence.",
    lead: "Stamping, tooling, welding and assembly engineered for demanding industries.",
    about: "Precision metal stamping,\nengineered in Batam.",
    process: "Our Process", products: "Our Products", facilities: "Our Facilities",
    quality: "Quality and Certifications", factory: "Factory tour", video: "Company profile",
    cta: "Have a part to manufacture?", explore: "Explore Capabilities", view: "View products",
    facilityLink: "View facilities", certLink: "View PDF", download: "Download PDF",
  },
  id: {
    eyebrow: "METAL STAMPING PRESISI — BATAM, INDONESIA",
    title: "Presisi.\nKeunggulan\nmanufaktur.",
    lead: "Stamping, tooling, welding, dan assembly untuk kebutuhan industri.",
    about: "Metal stamping presisi,\ndikembangkan di Batam.",
    process: "Proses Kami", products: "Produk Kami", facilities: "Fasilitas Kami",
    quality: "Kualitas dan Sertifikasi", factory: "Tur pabrik", video: "Profil perusahaan",
    cta: "Ada komponen yang ingin diproduksi?", explore: "Lihat Kapabilitas", view: "Lihat produk",
    facilityLink: "Lihat fasilitas", certLink: "Lihat PDF", download: "Unduh PDF",
  },
  zh: {
    eyebrow: "精密金属冲压 — 印度尼西亚巴淡岛",
    title: "精密。\n卓越\n制造。",
    lead: "面向高要求工业应用的冲压、模具、焊接和装配服务。",
    about: "立足巴淡岛，\n精密金属冲压。",
    process: "制造流程", products: "我们的产品", facilities: "生产设施",
    quality: "质量与认证", factory: "工厂视频", video: "公司简介",
    cta: "有零件需要生产？", explore: "了解制造能力", view: "查看产品",
    facilityLink: "查看设施", certLink: "查看 PDF", download: "下载 PDF",
  },
};

const processIconNames = ["UMI_Engineering.png", "UMI_Tooling.png", "UMI_Stamping.png", "UMI_Inspection.png", "UMI_Assembly.png", "UMI_Delivery.png"];
const productCrops: MockupCropKey[] = ["battery-contacts", "cable-terminals", "mechanical-assembly", "other-metal-parts"];

export default function Home() {
  const { locale, seo, htmlLang, chrome, content } = usePage<PageProps>().props;
  const c = copy[locale];
  const { blocks } = content;
  const [activeFacility, setActiveFacility] = useState(0);
  const [videoOpen, setVideoOpen] = useState(false);
  const facilities = blocks.facilities;
  const selected = facilities[Math.min(activeFacility, Math.max(0, facilities.length - 1))];
  const corporateVideo = content.sections.find(section => section.type === "prose" && section.video)?.video;

  return <MockupShell active="home">
    <PageHead seo={seo} htmlLang={htmlLang} />
    <section className="umi-hero relative isolate overflow-hidden bg-[#071522] text-white">
      <div className="umi-blueprint-lines pointer-events-none absolute inset-0 opacity-25" aria-hidden="true" />
      <div className="relative mx-auto grid min-h-[510px] max-w-[1400px] items-center gap-8 px-5 py-16 sm:px-8 lg:grid-cols-[0.97fr_1.03fr] xl:px-10">
        <div className="relative z-10">
          <p className="mb-4 text-[11px] font-extrabold uppercase tracking-widest text-[#ee3841]">{c.eyebrow}</p>
          <h1 className="whitespace-pre-line text-[clamp(3.4rem,5.3vw,6.5rem)] font-black leading-[0.93] tracking-[-0.06em]">{c.title}</h1>
          <p className="mt-6 max-w-md text-base leading-7 text-[#e0e7ed] sm:text-lg">{c.lead}</p>
          <div className="mt-8 flex flex-wrap gap-3">
            <Link href={"/" + locale + "/contact"} className="umi-btn-red inline-flex items-center gap-2 rounded px-6 py-3.5 text-sm font-bold text-white">{chrome.cta.quote}<ArrowUpRight size={16}/></Link>
            <a href="#umi-process" className="inline-flex items-center gap-2 rounded border border-white/35 px-6 py-3.5 text-sm font-bold text-white hover:bg-white/10">{c.explore}</a>
          </div>
        </div>
        <div className="relative flex h-[290px] items-center justify-center sm:h-[390px] lg:h-[470px]">
          <div className="pointer-events-none absolute inset-5 border border-dashed border-white/15" aria-hidden="true" />
          <div className="pointer-events-none absolute left-8 top-7 h-4 w-4 border-l border-t border-white/40" aria-hidden="true" />
          <div className="pointer-events-none absolute bottom-7 right-8 h-4 w-4 border-b border-r border-white/40" aria-hidden="true" />
          <div className="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(162,190,207,0.16),transparent_62%)]" />
          <MockupCrop crop="hero" alt="Approved precision stamped battery contact with engineering measurement overlays" className="relative z-10 h-full w-full" />
        </div>
      </div>
    </section>

    <section aria-label="Company highlights" className="border-b border-[#e4e8ed] bg-white">
      <div className="mx-auto grid max-w-[1400px] grid-cols-2 px-5 py-7 sm:px-8 lg:grid-cols-4 xl:px-10">
        {blocks.stats.map((stat, i) => <div key={i} className="border-[#e0e4e9] px-4 py-1 first:pl-0 lg:border-r lg:last:border-r-0">
          <strong className="block text-3xl font-black tracking-[-0.05em] lg:text-4xl">{locale === "en" ? ["25+ Years", "3,000 m²", "0.10 mm", "15–160 T"][i] : stat.value}</strong>
          <span className="mt-1 block text-[10px] font-bold uppercase tracking-widest text-[#586778]">{locale === "en" ? ["EST. 2000", "FACTORY", "MIN. THICKNESS", "PRESS RANGE"][i] : stat.label}</span>
        </div>)}
      </div>
    </section>

    <section className="py-16 lg:py-20">
      <div className="mx-auto grid max-w-[1400px] items-center gap-10 px-5 sm:px-8 lg:grid-cols-[0.9fr_1.1fr] xl:px-10">
        <div><div className="umi-mark" /><h2 className="umi-heading whitespace-pre-line">{c.about}</h2>
          <p className="mt-6 text-sm leading-7 text-[#48586a] sm:text-base">
            PT. Uni-Metaltech Industry (UMI) is a precision metal stamping company established in Batam in 2000. The factory operates at Kara Industrial Park, Batam Center.
          </p>
          <p className="mt-4 text-sm font-bold leading-7">
            Precision manufacturing for electrical, electronic and automotive industries, including battery contacts, cable terminals and metal assemblies.
          </p>
        </div>
        <div className="group relative overflow-hidden rounded-lg bg-[#071522]">
          <MockupCrop crop="factory-aerial" alt="Approved aerial view of the UMI factory complex" className="h-[240px] w-full sm:h-[300px] lg:h-[320px]" />
          {corporateVideo && <button onClick={() => setVideoOpen(true)} aria-label={c.video} type="button"
            className="absolute left-1/2 top-1/2 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#071522]/90 text-white ring-4 ring-white/30">
            <Play size={25} fill="currentColor"/>
          </button>}
          <p className="absolute bottom-5 left-5 text-xs font-bold uppercase tracking-widest text-white">{c.factory} · UMI</p>
        </div>
      </div>
    </section>

    <section id="umi-process" className="border-y border-[#e6eaee] bg-[#fafbfc] py-16 lg:py-20">
      <div className="mx-auto max-w-[1400px] px-5 sm:px-8 xl:px-10">
        <div className="mb-10 grid gap-5 lg:grid-cols-2">
          <div><div className="umi-mark"/><h2 className="umi-heading">{c.process}</h2></div>
          <p className="max-w-xl text-sm leading-6 text-[#5a6876]">A fully integrated process from engineering to delivery, focused on precision, consistency and reliable supply.</p>
        </div>
        <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
          {blocks.process.map((stage, index) => {
            const icon = processIconNames[index];
            return <div key={index} className="relative rounded border border-[#e8edf1] bg-white px-5 py-6">
              <span className="inline-flex rounded bg-[#d71920] px-2 py-1 text-xs font-black text-white">{String(index + 1).padStart(2, "0")}</span>
              <img src={"/images/process/" + icon} alt="" aria-hidden="true" loading="lazy" className="mx-auto my-4 h-14 w-16 object-contain" />
              <h3 className="text-center text-xs font-black sm:text-sm">{stage.title}</h3>
              {index < 5 && <ArrowRight size={15} aria-hidden="true" className="absolute -right-4 top-1/2 z-10 hidden text-[#d71920] lg:block" />}
            </div>;
          })}
        </div>
      </div>
    </section>

    <section className="bg-[#f3f5f6] py-16 lg:py-20">
      <div className="mx-auto max-w-[1400px] px-5 sm:px-8 xl:px-10">
        <div className="mb-10 grid gap-5 lg:grid-cols-2">
          <div><div className="umi-mark"/><h2 className="umi-heading">{c.products}</h2></div>
          <p className="max-w-xl text-sm leading-6 text-[#5a6876]">Precision stamped and assembled components for electrical, electronics and automotive applications.</p>
        </div>
        <div className="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
          {blocks.products.slice(0, 4).map((product, productIndex) => <article key={product.key} className="overflow-hidden rounded-lg border border-[#dde3e8] bg-white shadow-sm">
            <Link href={"/" + locale + "/products"} className="block overflow-hidden bg-[#e9edef]"><MockupCrop crop={productCrops[productIndex]} alt={"Approved mockup image: " + product.title} className="h-52 w-full" /></Link>
            <div className="p-5"><h3 className="text-lg font-black">{product.title}</h3><p className="mt-2 line-clamp-3 min-h-[4.5rem] text-sm leading-6 text-[#546376]">{product.description}</p>
              <Link href={"/" + locale + "/products"} className="mt-5 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-[#d71920]">{c.view}<ArrowRight size={16}/></Link>
            </div>
          </article>)}
        </div>
      </div>
    </section>

    <section className="bg-[#071522] py-16 text-white lg:py-20">
      <div className="mx-auto max-w-[1400px] px-5 sm:px-8 xl:px-10">
        <div className="mb-9 flex flex-wrap items-end justify-between gap-6">
          <div><div className="umi-mark"/><h2 className="umi-heading">{c.facilities}</h2><p className="mt-3 max-w-xl text-sm text-white/65">Production, tooling and inspection equipment supporting an integrated manufacturing operation.</p></div>
          <span className="text-[10px] font-bold uppercase tracking-widest text-white/50">Manufacturing · Tool Room · Quality Control</span>
        </div>
        <div className="grid grid-cols-2 border-y border-white/25 lg:grid-cols-4" role="tablist" aria-label={c.facilities}>
          {facilities.map((item, index) => <button type="button" role="tab" aria-controls="umi-facility-panel" aria-selected={activeFacility === index}
            key={item.key} onClick={() => setActiveFacility(index)}
            className={"border-r border-white/20 px-4 py-5 text-left transition-colors last:border-r-0 " + (activeFacility === index ? "border-b-4 border-b-[#d71920] bg-[#102d43]" : "hover:bg-white/10")}>
            <span className="block text-sm font-black text-[#ee3841]">{String(index + 1).padStart(2, "0")}</span>
            <span className="mt-1 block text-sm font-bold">{item.title}</span>
          </button>)}
        </div>
        {selected && <div id="umi-facility-panel" role="tabpanel" className="mt-8 grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
          {activeFacility === 0 ? <MockupCrop crop="production-line" alt="Approved AIDA and SEYI press production line photograph" className="h-[340px] w-full rounded-lg lg:h-[420px]" /> : <img src={selected.image} alt={selected.title} className="h-[340px] w-full rounded-lg object-cover lg:h-[420px]" loading="lazy"/>}
          <div className="flex flex-col justify-center">
            <p className="text-xs font-extrabold uppercase tracking-widest text-[#ee3841]">{String(activeFacility + 1).padStart(2, "0")} / {c.facilities}</p>
            <h3 className="mt-3 text-3xl font-black">{selected.title}</h3>
            <p className="mt-5 text-sm leading-7 text-white/70">{selected.summary}</p>
            <ul className="mt-5 space-y-3">{selected.specs.slice(0, 5).map((spec, i) => <li key={i} className="border-l-2 border-[#d71920] pl-4 text-sm text-white/80">{spec}</li>)}</ul>
            <Link href={"/" + locale + "/facilities"} className="mt-7 inline-flex items-center gap-2 text-sm font-bold text-[#fa5158]">{c.facilityLink}<ArrowUpRight size={17}/></Link>
          </div>
        </div>}
      </div>
    </section>

    <section className="py-16 lg:py-20">
      <div className="mx-auto max-w-[1400px] px-5 sm:px-8 xl:px-10">
        <div className="umi-mark"/><h2 className="umi-heading">{c.quality}</h2>
        <p className="mt-3 max-w-3xl text-sm leading-6 text-[#566578]">{blocks.quality.labelling}</p>
        <div className="mt-9 grid gap-6 md:grid-cols-2">
          {blocks.certifications.map((certificate, i) => <article key={i} className="rounded-lg border border-[#e0e5e9] p-5 md:p-7">
            <p className="text-xs font-bold text-[#d71920]">{certificate.name}</p><h3 className="mt-1 text-xl font-black">{certificate.title}</h3>
            <div className="mt-5 flex min-h-[205px] items-center justify-center overflow-hidden rounded border border-[#e6eaf0] bg-[#fafafa]">
              <object data={certificate.document + "#page=1&toolbar=0&navpanes=0"} type="application/pdf" aria-label={"Original certification PDF: " + certificate.name} className="h-[260px] w-full">
                <p className="p-6 text-sm text-[#566578]">Preview requires a PDF-capable browser. Use View PDF below.</p>
              </object>
            </div>
            <p className="mt-4 text-xs leading-6 text-[#697786]">{certificate.description}</p>
            {certificate.document && <div className="mt-5 flex flex-wrap gap-2">
              <a href={certificate.document} target="_blank" rel="noopener noreferrer" className="rounded border border-[#aab7c4] px-4 py-3 text-xs font-bold">{c.certLink}</a>
              <a href={certificate.document} download className="umi-btn-red rounded px-4 py-3 text-xs font-bold text-white">{c.download}</a>
            </div>}
          </article>)}
        </div>
      </div>
    </section>

    <section className="bg-[#071522] py-9 text-white"><div className="mx-auto flex max-w-[1400px] flex-wrap items-center justify-between gap-6 px-5 sm:px-8 xl:px-10">
      <h2 className="text-2xl font-black sm:text-3xl">{c.cta}</h2>
      <Link className="umi-btn-red inline-flex items-center gap-2 rounded px-6 py-3.5 text-sm font-bold" href={"/" + locale + "/contact"}>{chrome.cta.team}<ArrowRight size={17}/></Link>
      <a href={"mailto:" + blocks.contact.email} className="text-xs text-white/75">{blocks.contact.email}</a>
    </div></section>

    {videoOpen && corporateVideo && <div role="dialog" aria-modal="true" aria-label={c.video} className="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-5">
      <button type="button" onClick={() => setVideoOpen(false)} aria-label="Close video" className="absolute right-5 top-5 text-white"><X size={28}/></button>
      <video controls autoPlay playsInline preload="metadata" src={corporateVideo} className="max-h-[85vh] w-full max-w-5xl"/>
    </div>}
  </MockupShell>;
}
