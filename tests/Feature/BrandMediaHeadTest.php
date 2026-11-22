<?php

namespace Tests\Feature;

use Tests\TestCase;

class BrandMediaHeadTest extends TestCase
{
    public function test_browser_icon_references_existing_company_logo_not_empty_placeholder(): void
    {
        $response=$this->get('/en');
        $response->assertOk();
        $response->assertSee('rel="icon" type="image/png" href="/images/logo.png"',false);
        $response->assertSee('rel="apple-touch-icon" href="/images/logo.png"',false);
        $this->assertFileExists(public_path('images/logo.png'));
        $this->assertGreaterThan(0,filesize(public_path('images/logo.png')));
    }

    public function test_original_precision_hero_image_is_present(): void
    {
        $this->assertFileExists(public_path('images/hero/precision-metal-component.webp'));
        $this->assertGreaterThan(10000,filesize(public_path('images/hero/precision-metal-component.webp')));
    }
}
