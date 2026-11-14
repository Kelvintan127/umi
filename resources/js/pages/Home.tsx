import { Head } from "@inertiajs/react";

export default function Home({ locale }: { locale: string }) {
  return (
    <>
      <Head title="UMI Stamping" />
      <main>
        <h1>UMI Stamping</h1>
        <p data-testid="locale">locale: {locale}</p>
      </main>
    </>
  );
}
