import { useLayoutEffect, useRef } from "react";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { usePrefersReducedMotion } from "./useReveal";

gsap.registerPlugin(ScrollTrigger);

/**
 * Adds a small scroll-linked parallax effect to media inside a section.
 * The hook is client-only and reverts its context on unmount or navigation.
 */
export function useGsapScrollMotion<T extends HTMLElement = HTMLDivElement>() {
  const ref = useRef<T | null>(null);
  const reducedMotion = usePrefersReducedMotion();

  useLayoutEffect(() => {
    const root = ref.current;
    if (!root || reducedMotion) return;

    const context = gsap.context(() => {
      gsap.utils.toArray<HTMLElement>("img[data-gsap-parallax]", root).forEach((image) => {
        gsap.fromTo(
          image,
          { yPercent: -4 },
          {
            yPercent: 4,
            ease: "none",
            scrollTrigger: {
              trigger: image,
              start: "top bottom",
              end: "bottom top",
              scrub: 0.8,
            },
          },
        );
      });
    }, root);

    return () => context.revert();
  }, [reducedMotion]);

  return ref;
}
