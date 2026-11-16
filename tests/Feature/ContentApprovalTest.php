<?php

namespace Tests\Feature;

use App\Support\Approvals;
use Tests\TestCase;

/**
 * The approval gate for third-party content.
 *
 * These tests exist because the failure they catch is silent: an unapproved
 * customer name rendering on a public page looks like nothing is wrong. The
 * gate must fail closed — every test below approves nothing, which is the
 * real state of the material today.
 */
class ContentApprovalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Start from the shipped config every time. A test that quietly relied
        // on an approval recorded in config/approvals.php would pass while the
        // live page published a name nobody cleared.
        $this->assertSame(
            [],
            Approvals::customers(),
            'config/approvals.php ships with every customer unapproved.'
        );
    }

    public function test_no_customer_name_is_approved_in_the_shipped_config(): void
    {
        $this->assertSame([], Approvals::customers());
        $this->assertSame([], Approvals::testimonials());
        $this->assertSame([], config('approvals.signed_off'));
    }

    public function test_unapproved_customer_names_do_not_render(): void
    {
        $response = $this->get('/en/metal-part-users');
        $response->assertOk();

        foreach (['Panasonic', 'Apple', 'Dell', 'Nokia', 'Foster Electric', 'Valeo'] as $name) {
            $response->assertDontSee($name, false);
        }
    }

    public function test_unapproved_testimonial_quotes_do_not_render(): void
    {
        $response = $this->get('/en/metal-part-users');
        $response->assertOk();

        // The quote bodies are the real risk: attributing an award to a company
        // that has not given permission is a claim about that company.
        $response->assertDontSee('Zero Reject', false);
        $response->assertDontSee('Service excellence acknowledgment', false);
    }

    public function test_withheld_page_states_the_alternative_rather_than_rendering_an_empty_list(): void
    {
        $response = $this->get('/en/metal-part-users');

        // A silently empty section is indistinguishable from a broken one, and
        // a reader would conclude UMI has no customers.
        $response->assertSee('available on request', false);
    }

    public function test_approving_a_customer_publishes_it(): void
    {
        // Proves the gate is a gate and not a deletion: with approval, the name
        // reaches the page. Without this, the tests above would pass even if the
        // component had been gutted.
        config()->set('approvals.customers', [
            ['name' => 'Foster Electric', 'relationship' => 'direct', 'approved' => true],
        ]);

        $this->assertSame([['name' => 'Foster Electric', 'relationship' => 'direct']], Approvals::customers());
        $this->get('/en/metal-part-users')->assertSee('Foster Electric', false);
    }

    public function test_a_testimonial_from_an_unapproved_company_is_withheld_even_when_marked_approved(): void
    {
        // The stricter gate wins. Endorsing a company whose name we may not
        // publish is incoherent, so approval of the quote alone is not enough.
        config()->set('approvals.testimonials', [
            ['name' => 'Foster Electric', 'period' => '2013–2015', 'approved' => true],
        ]);

        $this->assertSame([], Approvals::testimonials());
    }

    public function test_indirect_brands_are_separated_from_direct_customers(): void
    {
        config()->set('approvals.customers', [
            ['name' => 'Foster Electric', 'relationship' => 'direct', 'approved' => true],
            ['name' => 'Apple', 'relationship' => 'indirect', 'approved' => true],
        ]);

        $this->assertSame(['Foster Electric', 'Apple'], array_column(Approvals::customers(), 'name'));

        $response = $this->get('/en/metal-part-users');

        // Apple is reached through a contract manufacturer; the page must say so
        // rather than listing it beside direct customers.
        $response->assertSee('End products our parts reach', false);
        $response->assertSee('does not supply these brands directly', false);
    }

    public function test_withheld_count_reports_what_the_gate_is_holding_back(): void
    {
        // Ten direct, nine indirect — but the count is derived, not hardcoded,
        // so adding a customer to config does not silently break the note.
        $total = count((array) config('approvals.customers'));

        $this->assertSame($total, Approvals::withheldCount('customers'));
        $this->assertTrue(Approvals::hasWithheld('customers'));
    }

    public function test_no_locale_publishes_unapproved_names(): void
    {
        // English is the served locale today, but the drafts must not leak the
        // list either — and the day a locale is signed off it inherits the gate.
        foreach (['en'] as $locale) {
            $response = $this->get("/{$locale}/metal-part-users");
            $response->assertOk();
            $response->assertDontSee('Panasonic', false);
            $response->assertDontSee('Kyocera', false);
        }
    }

    public function test_the_source_list_still_exists_so_approval_is_a_config_change(): void
    {
        // The names are kept in config, not deleted from the project. If this
        // ever fails, the customer list was lost and approving one later would
        // mean re-typing it from memory.
        $names = array_column(config('approvals.customers'), 'name');

        $this->assertCount(19, $names);
        $this->assertContains('Foster Electric', $names);
        $this->assertContains('Apple', $names);
    }
}
