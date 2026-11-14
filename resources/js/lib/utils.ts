import { clsx, type ClassValue } from "clsx";
import { twMerge } from "tailwind-merge";

/**
 * Ported from the reference src/lib/utils.ts unchanged, so every ported
 * component keeps its exact class-merge semantics.
 */
export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}
