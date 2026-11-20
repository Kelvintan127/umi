import { useMemo } from "react";

/**
 * Precision-scale artwork from the approved UMI reference.
 * The reference labels 0 through 140 in 10-unit increments.
 * Drawing in SVG preserves thin, sharp ticks on HiDPI displays.
 *
 * The strip deliberately uses a fixed 10px/unit design grid instead of
 * distorting the tick spacing to fill a narrow mobile viewport.
 */
export interface EngineeringRulerProps {
  orientation?: "horizontal" | "vertical";
  density?: number;
  majorEvery?: number;
  labelEvery?: number;
  color?: string;
  background?: string;
  accent?: string;
  height?: number;
  showLabels?: boolean;
  markers?: readonly number[];
  className?: string;
}

export function EngineeringRuler({
  orientation = "horizontal",
  density = 10,
  majorEvery = 10,
  labelEvery = 10,
  color = "#d1d9e1",
  background = "#071522",
  accent = "#d71920",
  height = 30,
  showLabels = true,
  markers = [10, 70, 110],
  className = "",
}: EngineeringRulerProps) {
  const units = 140;
  const span = units * density;
  const coordinate = (n: number) => n * density;
  const isVertical = orientation === "vertical";
  const ticks = useMemo(() => Array.from({ length: units + 1 }, (_, n) => ({
    n,
    x: coordinate(n),
    major: n % majorEvery === 0,
    medium: n % Math.max(1, Math.round(majorEvery / 2)) === 0,
  })), [density, majorEvery]);
  const labels = ticks.filter(t => t.n % labelEvery === 0);

  const art = (
    <svg
      width={isVertical ? height : span}
      height={isVertical ? span : height}
      viewBox={isVertical ? "0 0 30 1400" : "0 0 1400 30"}
      preserveAspectRatio="none"
      aria-hidden="true"
      focusable="false"
      className="block"
    >
      <g transform={isVertical ? "translate(30 0) rotate(90)" : undefined}>
        {ticks.map(t => (
          <line key={t.n} x1={t.x} x2={t.x}
            y1={t.major ? 17 : t.medium ? 21 : 25} y2={30}
            stroke={color} strokeOpacity={t.major ? 0.86 : 0.42}
            strokeWidth={t.major ? 1.2 : 0.65} />
        ))}
        {showLabels && labels.map(t => (
          <text key={t.n} x={Math.max(3,Math.min(span - 22,t.x))}
            y={11} fill={color} fontSize={11} fontWeight={600}
            letterSpacing=".45">{t.n}</text>
        ))}
        {markers.filter(n=>n>=0 && n<=140).map(n=>(
          <path key={n} d={"M"+(coordinate(n)-4)+" 17 L"+coordinate(n)+" 10 L"+(coordinate(n)+4)+" 17Z"} fill={accent} />
        ))}
      </g>
    </svg>
  );

  return (
    <div className={"umi-engineering-ruler overflow-hidden " + className}
      style={{
        backgroundColor: background,
        width: isVertical ? height : "100%",
        height: isVertical ? span : height,
      }}
      aria-hidden="true">
      {art}
    </div>
  );
}
