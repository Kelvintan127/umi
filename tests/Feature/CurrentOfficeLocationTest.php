<?php

namespace Tests\Feature;

use Tests\TestCase;

/** Official public office presence: Batam factory only. */
class CurrentOfficeLocationTest extends TestCase
{
    public function test_public_translations_have_no_retired_jakarta_office_claims(): void
    {
        foreach (['en','id','zh'] as $locale) {
            foreach (['pages','site','seo','forms'] as $namespace) {
                $source = require lang_path($locale.'/'.$namespace.'.php');
                $text = json_encode($source, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $this->assertIsString($text);
                $this->assertDoesNotMatchRegularExpression(
                    '/jakarta|jababeka|kantor\s+penjualan|sales[\s-]*office|雅加达|销售办事处|销售办公室/ui',
                    $text,
                    'Outdated office location in '.$locale.'/'.$namespace,
                );
            }
        }
    }

    public function test_organization_structured_data_lists_only_batam(): void
    {
        $response = $this->get('/en');
        $response->assertOk();
        $data = $response->viewData('page');
        $this->assertIsArray($data);

        $props = $data['props'] ?? [];
        $locations = $props['seo']['jsonLd']['location'] ?? null;
        $this->assertIsArray($locations);
        $this->assertCount(1, $locations);
        $this->assertStringContainsString('Batam', json_encode($locations[0], JSON_UNESCAPED_UNICODE));
        $this->assertStringNotContainsString('Jakarta', json_encode($props, JSON_UNESCAPED_UNICODE));
    }
}
