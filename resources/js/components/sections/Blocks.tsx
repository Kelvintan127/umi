import { useEffect, useState } from "react";
import { ArrowRight, ArrowUpRight, X } from "lucide-react";
import { Link } from "@inertiajs/react";
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

/** Same restrained four-stat strip used on the approved homepage. */
export function Stats({ stats }: { stats: Stat[] }) {
  return (
    <Band tone="white">
      <dl className="umi-interior-stats grid grid-cols-2 border-y border-[#dae2e9] lg:grid-cols-4">
        {stats.map((stat, index) => (
          <div key={stat.label} className="border-r border-[#dce3e9] px-4 py-5 last:border-r-0 sm:px-7">
            <dt className="order-2 mt-2 text-[11px] font-extrabold uppercase tracking-[.12em] text-[#506273]">{stat.label}</dt>
            <dd className="order-1 text-[clamp(2rem,3.2vw,3.65rem)] font-black leading-none tracking-[-.055em] text-[#071522]">{stat.value}</dd>
            <span className="mt-4 block h-[3px] w-10 bg-[#d71920]" aria-hidden="true" />
          </div>
        ))}
      </dl>
    </Band>
  );
}

/** Original six factory-process illustrations, not substitute Lucide icons. */
export function Process({ stages, heading }: { stages: ProcessStage[]; heading?: string }) {
  const icons = [
    "UMI_Engineering.png", "UMI_Tooling.png", "UMI_Stamping.png",
    "UMI_Inspection.png", "UMI_Assembly.png", "UMI_Delivery.png",
  ];
  return (
    <Band tone="light" ariaLabelledBy={heading ? "umi-process-section" : undefined}>
      <SectionHeading title={heading} id="umi-process-section" />
      <ol className="umi-interior-process mt-8 grid grid-cols-2 gap-x-3 gap-y-9 sm:grid-cols-3 lg:grid-cols-6 lg:gap-x-5">
        {stages.map((stage, index) => (
          <li key={stage.title} className="relative min-w-0 px-2 text-center">
            <span className="mx-auto inline-flex rounded-sm bg-[#d71920] px-2.5 py-1 text-[11px] font-extrabold tabular-nums text-white">
              {String(index + 1).padStart(2, "0")}
            </span>
            <img src={"/images/process/"+(icons[index] ?? icons[0])} alt=""
              aria-hidden="true" loading="lazy" width="96" height="96"
              className="mx-auto my-3 h-[82px] w-[96px] object-contain"/>
            <h3 className="text-base font-black tracking-[-.025em] text-[#071522]">{stage.title}</h3>
            <p className="mt-2 text-xs font-medium leading-5 text-[#536477]">{stage.description}</p>
            {index<stages.length-1 && <ArrowRight size={18} aria-hidden="true"
              className="absolute -right-4 top-[50%] hidden text-[#9aaab8] lg:block"/>}
          </li>
        ))}
      </ol>
    </Band>
  );
}

/** Dark, image-led industrial equipment layout shared with Home Facilities. */
export function Specs({ items, heading }: { items: SpecItem[]; heading?: string }) {
  return (
    <Band tone="ink" ariaLabelledBy={heading ? "umi-specs-heading" : undefined}>
      <SectionHeading title={heading} id="umi-specs-heading" tone="white"/>
      <div className="umi-interior-facility-list mt-9 space-y-12">
        {items.map((facility, index) => {
          const hasImage = Boolean(facility.image);
          return (
            <section key={facility.key}
              aria-labelledby={"facility-"+facility.key}
              className="umi-interior-spec-item border-t border-white/20 pt-7 first:border-t-0 first:pt-0">
              <div className={hasImage ? "grid items-start gap-7 lg:grid-cols-[minmax(0,1.6fr)_minmax(0,1fr)]" : "max-w-4xl"}>
                {hasImage && <div className="overflow-hidden rounded-md border border-white/15 bg-[#102738]">
                  <img src={facility.image} alt={"UMI equipment: " + facility.title} loading="lazy" decoding="async" className="h-[295px] w-full object-contain bg-[#102738] sm:h-[370px] lg:h-[430px]"/>
                </div>}
                <div className="min-w-0 pt-1">
                  <h3 id={"facility-"+facility.key}
                    className="flex flex-wrap items-baseline gap-x-3 gap-y-1 text-[clamp(1.6rem,2.2vw,2.25rem)] font-black uppercase leading-[1.12] tracking-[-.035em]">
                    <span className="tabular-nums text-[#f14b52]">{String(index+1).padStart(2,"0")}</span>
                    <span>{facility.title}</span>
                  </h3>
                  {facility.summary && <p className="mt-5 text-base font-medium leading-[1.55] text-white/85">{facility.summary}</p>}
                  {facility.specs.length>0 && <ul className="mt-6 space-y-3">
                    {facility.specs.map((spec,idx) => <li key={idx} className="flex gap-3 text-sm font-semibold leading-6 text-white/90">
                      <span aria-hidden="true" className="mt-[.68rem] h-[3px] w-4 shrink-0 bg-[#f1454d]"/>
                      <span>{spec}</span>
                    </li>)}
                  </ul>}
                </div>
              </div>
            </section>
          );
        })}
      </div>
    </Band>
  );
}

/** Authentic first-page renders of the original UMI PDFs; no blank PDF iframe cards. */
export function Certifications({
  items, labelling, heading,
}: {
  items: Certification[];
  labelling?: string;
  heading?: string;
}) {
  const [selected,setSelected]=useState<Certification|null>(null);
  useEffect(()=>{
    if(!selected)return;
    const onKeyDown=(event:KeyboardEvent)=>{if(event.key==="Escape")setSelected(null);};
    const before=document.body.style.overflow;
    document.addEventListener("keydown",onKeyDown);
    document.body.style.overflow="hidden";
    return ()=>{document.removeEventListener("keydown",onKeyDown);document.body.style.overflow=before;};
  },[selected]);

  return (
    <Band tone="white" ariaLabelledBy={heading ? "umi-cert-heading" : undefined}>
      <SectionHeading title={heading} id="umi-cert-heading"/>
      <ul className="mt-8 grid gap-5 md:grid-cols-2">
        {items.map(cert=>{
          const preview=cert.name.includes("9001")
            ? "/images/certifications/preview-iso-9001.jpg"
            : "/images/certifications/preview-iso-14001.jpg";
          return <li key={cert.name} className="umi-interior-certificate flex min-w-0 flex-col p-5 sm:p-7">
            <span className="text-xs font-extrabold uppercase tracking-[.13em] text-[#d71920]">{cert.name}</span>
            <h3 className="mt-1 text-xl font-black leading-tight tracking-[-.03em] text-[#071522] sm:text-2xl">{cert.title}</h3>
            <button type="button" onClick={()=>setSelected(cert)}
              aria-label={"Preview "+cert.name+" certificate"}
              className="group mt-5 flex h-[310px] w-full items-center justify-center overflow-hidden rounded border border-[#dfe5eb] bg-[#f8fafb] sm:h-[365px]">
              <img src={preview} alt={cert.name+" original certificate first page"}
                width={700} height={990} loading="lazy"
                className="h-full w-full object-contain transition-transform duration-300 group-hover:scale-[1.025]"/>
            </button>
            <p className="mt-4 flex-1 text-sm font-medium leading-6 text-[#536273]">{cert.description}</p>
            {cert.document && <div className="mt-5 flex flex-wrap gap-3">
              <a href={cert.document} target="_blank" rel="noopener noreferrer"
                className="inline-flex items-center gap-2 rounded border border-[#b3c0cc] px-4 py-3 text-xs font-extrabold text-[#071522] hover:border-[#d71920]">
                View PDF<ArrowUpRight size={15} aria-hidden="true"/>
              </a>
              <a href={cert.document} download
                className="umi-btn-red inline-flex items-center gap-2 rounded px-4 py-3 text-xs font-extrabold text-white">
                Download PDF<ArrowRight size={15} aria-hidden="true"/>
              </a>
            </div>}
          </li>;
        })}
      </ul>
      {labelling && <p className="mt-7 max-w-4xl border-l-[3px] border-[#d71920] pl-4 text-sm leading-6 text-[#506273]">{labelling}</p>}
      {selected && <div role="dialog" aria-modal="true" aria-labelledby="cert-dialog-title"
        className="fixed inset-0 z-[100] flex items-center justify-center bg-[#071522]/90 p-4"
        onMouseDown={e=>{if(e.currentTarget===e.target)setSelected(null);}}>
        <div className="flex h-[min(90vh,900px)] w-full max-w-5xl flex-col rounded-md bg-white shadow-2xl">
          <div className="flex items-center justify-between border-b border-[#dae1e8] px-5 py-4">
            <h2 id="cert-dialog-title" className="text-sm font-black">{selected.name+" — "+selected.title}</h2>
            <button type="button" onClick={()=>setSelected(null)} aria-label="Close certificate preview"
              className="flex h-10 w-10 items-center justify-center rounded hover:bg-[#edf0f3]">
              <X size={20} aria-hidden="true"/>
            </button>
          </div>
          <iframe src={selected.document} title={selected.name+" original PDF"} className="min-h-0 flex-1"/>
        </div>
      </div>}
    </Band>
  );
}

/** Published quality and environmental policy; copy remains data-driven. */
export function Policy({policy,heading}:{
  policy:ContentBlocks["policy"];heading?:string;
}) {
  return <Band tone="light">
    <SectionHeading title={heading ?? policy.heading}/>
    <p className="mt-6 text-base font-medium leading-7 text-[#506273]">{policy.intro}</p>
    <ol className="mt-7 grid gap-4 md:grid-cols-2">
      {policy.items.map((item,index)=>
        <li key={item} className="flex items-start gap-4 rounded border border-[#dce3e9] bg-white p-5 sm:p-6">
          <span className="w-10 shrink-0 border-b-[3px] border-[#d71920] pb-2 text-2xl font-black tabular-nums text-[#d71920]">
            {String(index+1).padStart(2,"0")}
          </span>
          <p className="text-sm font-semibold leading-7 text-[#35495b]">{item}</p>
        </li>)}
    </ol>
  </Band>;
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
                data-gsap-parallax="true"
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
