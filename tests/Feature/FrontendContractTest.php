<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Guards for behaviour that only exists in the browser bundle.
 *
 * The focus trap, the video pause control and the reduced-motion pause are all
 * client-side, so PHPUnit cannot exercise them — the browser sweep did. What a
 * test can do is fail loudly when the code that implements them is deleted in a
 * refactor, which is the failure mode that matters: nobody notices a missing
 * focus trap until a keyboard user is stuck.
 *
 * These assert on source presence, deliberately. They are cheap, they run in the
 * normal suite, and they do not pretend to be a substitute for the browser pass
 * recorded in docs/qa-report.md.
 */
class FrontendContractTest extends TestCase
{
    private function source(string $path): string
    {
        $full = resource_path($path);

        $this->assertFileExists($full, "{$path} is missing");

        return (string) File::get($full);
    }

    public function test_the_mobile_menu_traps_focus(): void
    {
        $src = $this->source('js/components/layout/Header.tsx');

        // A modal that lets Tab escape is worse than no modal: aria-modal="true"
        // promises the rest of the page is unreachable.
        $this->assertStringContainsString('aria-modal', $src);
        $this->assertStringContainsString('preventDefault', $src);
        $this->assertStringContainsString('shiftKey', $src, 'the trap must handle Shift+Tab');
        $this->assertStringContainsString('tabindex="-1"', $src, 'the panel itself must be focusable to receive focus on open');
    }

    public function test_the_hero_video_has_a_pause_control(): void
    {
        $src = $this->source('js/components/sections/Hero.tsx');

        // WCAG 2.2.2: anything that moves for more than five seconds
        // automatically needs a mechanism to pause it.
        $this->assertStringContainsString('el.pause()', $src);
        $this->assertStringContainsString('aria-pressed', $src);
        $this->assertStringContainsString('prefers-reduced-motion', $src);

        // autoPlay on the element would restart it regardless of the effect.
        $this->assertStringNotContainsString('autoPlay', $src, 'autoplay is controlled by the effect, not the attribute');
    }

    public function test_reduced_motion_is_honoured_in_css(): void
    {
        $css = $this->source('css/app.css');

        $this->assertStringContainsString('prefers-reduced-motion: reduce', $css);
    }

    public function test_the_language_switcher_does_not_link_unavailable_locales(): void
    {
        $src = $this->source('js/components/layout/Nav.tsx');

        // Unavailable locales render as <span aria-disabled>, never an href to a
        // URL that would redirect the visitor back to English.
        $this->assertStringContainsString('aria-disabled', $src);
        $this->assertStringContainsString('lang.available', $src);
    }
}
