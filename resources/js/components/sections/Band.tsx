import type { ReactNode } from "react";
import { Container } from "../layout/Container";
import { useReveal } from "@/hooks/useReveal";
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

  const tones = {
    white: "bg-white text-ink",
    light: "bg-band-light text-ink",
    ink: "bg-ink text-white",
  } as const;

  return (
    <Tag
      id={id}
      aria-labelledby={ariaLabelledBy}
      className={cn("py-20 md:py-28", tones[tone], className)}
    >
      <Container>
        <div ref={reveal ? ref : undefined} {...(reveal ? props : {})} className={reveal ? "reveal" : undefined}>
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
    <div className={cn("max-w-3xl", align === "center" && "mx-auto text-center")}>
      {eyebrow ? (
        <p
          className={cn(
            "text-xs font-semibold uppercase tracking-[0.2em]",
            tone === "white" ? "text-red" : "text-red",
          )}
        >
          {eyebrow}
        </p>
      ) : null}

      {title ? (
        <h2
          id={id}
          className={cn(
            "mt-4 text-3xl font-black leading-[1.05] tracking-tight sm:text-4xl lg:text-5xl",
            tone === "white" ? "text-white" : "text-ink",
          )}
        >
          {title}
        </h2>
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
