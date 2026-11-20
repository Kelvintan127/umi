import { useMemo } from "react";

/**
 * Approved references use two distinct scales:
 * Home: 0, 10, 20 ... 140; Contact: 0, 50, 100 ... 1400.
 * The instrument renders at native CSS-pixel spacing and clips rather than
 * stretching on small viewports.
 */
export type EngineeringRulerVariant = "home" | "contact" | "facilities";

export interface EngineeringRulerProps {
  variant?: EngineeringRulerVariant;
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
  activeIndex?: number;
  className?: string;
}

export function EngineeringRuler({
  variant = "home",
  orientation = "horizontal",
  density = 10,
  majorEvery,
  labelEvery,
  color = "#ecf1f5",
  background = "#071522",
  accent = "#d71920",
  height,
  showLabels,
  markers,
  activeIndex = 0,
  className = "",
}: EngineeringRulerProps) {
  const facility = variant === "facilities";
  const contact = variant === "contact";
  const barHeight = height ?? (facility ? 32 : 38);
  const major = Math.max(1, majorEvery ?? (contact ? 5 : 10));
  const medium = Math.max(1, Math.floor(major / 2));
  const labelsAt = Math.max(1, labelEvery ?? major);
  const drawLabels = showLabels ?? !facility;
  const start = facility ? 0 : 40;
  const step = Math.max(6, density);
  const width = Math.max(2400, start + step * 220);
  const count = Math.ceil((width - start) / step);
  const markerPositions = markers ?? (facility ? [] : contact ? [96] : [10, 70]);
  const vertical = orientation === "vertical";

  const ticks = useMemo(() => Array.from({length: count + 1}, (_,n) => ({
    n,
    x: start + n * step,
    major: n % major === 0,
    medium: n % medium === 0,
  })), [count, start, step, major, medium]);

  const drawing = (
    <svg width={width} height={barHeight}
      viewBox={"0 0 " + width + " " + barHeight}
      role="presentation" aria-hidden="true" focusable="false"
      style={{display:"block",flexShrink:0,overflow:"visible"}}>
      <line x1={0} x2={width} y1={barHeight-1} y2={barHeight-1}
        stroke={color} strokeOpacity=".45"/>
      {ticks.map(t => <line key={t.n} x1={t.x} x2={t.x}
        y1={barHeight-(t.major ? facility ? 22 : 20 : t.medium ? 14 : 8)}
        y2={barHeight-1} stroke={color}
        strokeOpacity={t.major ? .98 : t.medium ? .78 : .62}
        strokeWidth={t.major ? 1.4 : t.medium ? 1.05 : .8}/>)}
      {drawLabels && ticks.filter(t=>t.major&&t.n % labelsAt===0).map(t=>
        <text key={t.n} x={t.x} y={13}
          textAnchor={t.n===0?"start":"middle"}
          fill={color} fontSize={contact?12:12.5}
          fontFamily="Inter, Arial, sans-serif"
          fontWeight={700} letterSpacing=".2">
          {contact ? t.n * 10 : t.n}
        </text>)}
      {markerPositions.filter(n=>n>=0&&start+n*step<width).map(n=>{
        const x=start+n*step;
        return <path key={n}
          d={"M "+(x-7)+" "+(barHeight-16)+" L "+(x+7)+" "+(barHeight-16)+" L "+x+" "+(barHeight-1)+" Z"}
          fill={accent}/>;
      })}
      {facility && <rect x={Math.max(0,Math.min(3,activeIndex))*330}
        y={0} width={330} height={3} fill={accent}/>}
    </svg>
  );
  return <div
    className={"umi-engineering-ruler " + (facility ? "umi-engineering-ruler--facilities " : "umi-engineering-ruler--header ") + className}
    data-variant={variant} aria-hidden="true"
    style={{height:vertical?width:barHeight,width:vertical?barHeight:"100%",backgroundColor:background,overflow:"hidden"}}>
    {vertical
      ? <div style={{width,height:barHeight,transformOrigin:"top left",transform:"translateX("+barHeight+"px) rotate(90deg)"}}>{drawing}</div>
      : drawing}
  </div>;
}
