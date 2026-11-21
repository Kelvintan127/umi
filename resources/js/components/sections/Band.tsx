import type { ReactNode } from "react";
import { Container } from "../layout/Container";
import { useReveal } from "@/hooks/useReveal";
import { useGsapScrollMotion } from "@/hooks/useGsapScrollMotion";
import { cn } from "@/lib/utils";

/**
 * The site's band primitive: consistent vertical rhythm, optional tint, optional
 * reveal. Every section component wraps its content in this rather than
 * repeating padding numbers.
 */
export function Band({
  children,
  tone = "white",
  reveal = true,
  className,
  id,
  ariaLabelledBy,
  as: Tag = "section",
}: {
  children: ReactNode;
  tone?: "white" | "light" | "ink";
  reveal?: boolean;
  className?: string;
  id?: string;
  ariaLabelledBy?: string;
  as?: "section" | "div";
}) {
  const { ref, props } = useReveal<HTMLDivElement>();
  const motionRef = useGsapScrollMotion<HTMLDivElement>();

  const tones = {
    white: "bg-white text-ink",
    light: "bg-band-light text-ink",
    ink: "bg-ink text-white",
  } as const;

  return (
    <Tag
      id={id}
      aria-labelledby={ariaLabelledBy}
      className={cn("umi-content-band py-20 md:py-28", tones[tone], className)}
    >
      <Container>
        <div
          ref={(node) => {
            if (reveal) ref.current = node;
            motionRef.current = node;
          }}
          {...(reveal ? props : {})}
          className={reveal ? "reveal" : undefined}
        >
          {children}
        </div>
      </Container>
    </Tag>
  );
}

/** Section heading block: eyebrow, title, optional lead. One definition of the scale. */
export function SectionHeading({
  eyebrow,
  title,
  lead,
  tone = "ink",
  align = "left",
  id,
}: {
  eyebrow?: string;
  title?: string;
  lead?: string;
  tone?: "ink" | "white";
  align?: "left" | "center";
  id?: string;
}) {
  if (!title && !lead) return null;

  return (
    <div className={cn("umi-content-section-heading max-w-3xl", align === "center" && "mx-auto text-center")}>
      {eyebrow ? (
        <div className="flex items-center gap-3">
          <span aria-hidden="true" className="h-px w-8 bg-red" />
          <p className="text-xs font-semibold uppercase tracking-[0.2em] text-red">{eyebrow}</p>
        </div>
      ) : null}

      {title ? (
        <>
          <h2
            id={id}
            className={cn(
              "mt-4 text-3xl font-black leading-[1.05] tracking-tight sm:text-4xl lg:text-5xl",
              tone === "white" ? "text-white" : "text-ink",
            )}
          >
            {title}
          </h2>
          <span
            aria-hidden="true"
            className={cn(
              "mt-6 block h-1 w-14 bg-red transition-[width] duration-500 ease-[var(--ease-out-quint)] hover:w-24",
              align === "center" && "mx-auto",
            )}
          />
        </>
      ) : null}

      {lead ? (
        <p
          className={cn(
            "mt-6 text-base leading-7 sm:text-lg sm:leading-8",
            tone === "white" ? "text-white/60" : "text-ink/60",
          )}
        >
          {lead}
        </p>
      ) : null}
    </div>
  );
}
