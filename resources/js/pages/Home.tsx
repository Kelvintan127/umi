/**
 * The homepage is a registry page like any other: its copy lives in
 * lang/en/pages.php under `home` and ContentPage already switches to the
 * hero-less variant when pageKey is `home`. Re-exporting keeps one renderer
 * instead of two that drift.
 */
export { default } from "./ContentPage";
