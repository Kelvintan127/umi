/**
 * Approved mockup media, shown as reference-accurate crops while the
 * high-resolution originals are pending. The source is the user-supplied
 * 534 × 1600 full-page screenshot: these crops are low resolution.
 *
 * The crop uses SVG viewBox rather than a CSS approximation, so each crop
 * retains its original geometry without duplicating labels or navigation.
 */
import type { SVGProps } from "react";

export type MockupCropKey =
  | "hero"
  | "factory-aerial"
  | "battery-contacts"
  | "cable-terminals"
  | "mechanical-assembly"
  | "other-metal-parts"
  | "production-line"
  | "certificate-quality"
  | "certificate-environment"
  | "batam-map";

const cropBoxes: Record<MockupCropKey, [number, number, number, number]> = {
  hero: [258, 54, 267, 184],
  "factory-aerial": [258, 321, 261, 103],
  "battery-contacts": [15, 605, 122, 82],
  "cable-terminals": [143, 605, 124, 82],
  "mechanical-assembly": [270, 605, 126, 82],
  "other-metal-parts": [401, 605, 120, 82],
  "production-line": [21, 899, 303, 188],
  "certificate-quality": [26, 1200, 226, 147],
  "certificate-environment": [286, 1200, 225, 147],
  "batam-map": [37, 1041, 954, 233],
};

export function MockupCrop({
  crop,
  alt,
  ...props
}: Omit<SVGProps<SVGSVGElement>, "children"> & { crop: MockupCropKey; alt: string }) {
  const [x, y, w, h] = cropBoxes[crop];
  const contactSource = crop === "batam-map";
  return (
    <svg
      {...props}
      viewBox={x + " " + y + " " + w + " " + h}
      preserveAspectRatio="xMidYMid slice"
      role="img"
      aria-label={alt}
    >
      <title>{alt}</title>
      <image
        href={contactSource ? "/design-reference/mockup-contact.jpg" : "/design-reference/mockup-home.jpg"}
        x={0}
        y={0}
        width={contactSource ? 1024 : 534}
        height={contactSource ? 1536 : 1600}
        preserveAspectRatio="none"
      />
    </svg>
  );
}
