import type { ReactNode } from "react";
import { cn } from "@/lib/utils";

/**
 * The one horizontal rhythm on the site. Every band uses it, so container width
 * and gutters can never drift between sections.
 */
export function Container({
  children,
  className,
  as: Tag = "div",
}: {
  children: ReactNode;
  className?: string;
  as?: "div" | "header" | "footer" | "nav" | "section";
}) {
  return (
    <Tag className={cn("mx-auto w-full max-w-[1400px] px-5 sm:px-8 lg:px-12", className)}>
      {children}
    </Tag>
  );
}
