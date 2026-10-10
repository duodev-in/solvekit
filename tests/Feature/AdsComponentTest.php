<?php

namespace Tests\Feature;

use App\Models\User;
use App\View\Components\Ads;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdsComponentTest extends TestCase
{
    use RefreshDatabase;

    private const LOADER_URL = 'pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1701186115041469';

    public function test_ads_are_not_rendered_when_adsense_is_disabled(): void
    {
        config(['services.adsense.enabled' => false, 'services.adsense.preview' => false]);

        $response = $this->get($this->firstToolUrl());

        $response->assertOk();
        $response->assertDontSee(self::LOADER_URL, false);
        $response->assertDontSee('data-ad-unit', false);
    }

    public function test_tool_page_renders_display_in_article_and_multiplex_units_with_a_single_loader(): void
    {
        $this->enableAds();

        $response = $this->get($this->firstToolUrl());

        $response->assertOk();
        $this->assertSame(1, substr_count($response->getContent(), self::LOADER_URL));
        $response->assertSee('data-ad-slot="3525776996"', false);
        $response->assertSee('data-ad-slot="5880477598"', false);
        $response->assertSee('data-ad-slot="6195252491"', false);
        $response->assertSee('data-ad-layout="in-article"', false);
        $response->assertSee('data-ad-format="autorelaxed"', false);
    }

    public function test_loader_script_is_placed_in_the_document_head(): void
    {
        $this->enableAds();

        $content = $this->get($this->firstToolUrl())->getContent();

        $this->assertLessThan(strpos($content, '</head>'), strpos($content, self::LOADER_URL));
    }

    public function test_conversion_index_and_home_render_feed_and_multiplex_units(): void
    {
        $this->enableAds();

        foreach ([route('conversion.index'), url('/')] as $url) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee('data-ad-slot="3685559099"', false);
            $response->assertSee('data-ad-layout-key="-fb+5w+4e-db+86"', false);
            $response->assertSee('data-ad-slot="6195252491"', false);
        }
    }

    public function test_contact_and_feature_request_pages_do_not_render_ads(): void
    {
        $this->enableAds();

        foreach ([route('contact.create'), route('feature-request.create')] as $url) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertDontSee(self::LOADER_URL, false);
            $response->assertDontSee('data-ad-unit', false);
        }
    }

    public function test_ads_are_hidden_for_admin_roles(): void
    {
        $this->enableAds();

        foreach (['superadmin', 'developer'] as $roleName) {
            $user = User::factory()->create();
            $user->assignRole(Role::findOrCreate($roleName, 'web'));

            $response = $this->actingAs($user)->get($this->firstToolUrl());

            $response->assertOk();
            $response->assertDontSee(self::LOADER_URL, false);
            $response->assertDontSee('data-ad-unit', false);
        }
    }

    public function test_ads_are_shown_to_signed_in_users_without_admin_roles(): void
    {
        $this->enableAds();

        $response = $this->actingAs(User::factory()->create())->get($this->firstToolUrl());

        $response->assertOk();
        $response->assertSee(self::LOADER_URL, false);
    }

    public function test_preview_mode_renders_placeholders_without_loading_adsense(): void
    {
        config(['services.adsense.enabled' => false, 'services.adsense.preview' => true]);

        $response = $this->get($this->firstToolUrl());

        $response->assertOk();
        $response->assertSee('data-ad-unit', false);
        $response->assertDontSee(self::LOADER_URL, false);
        $response->assertDontSee('data-ad-slot=', false);
    }

    public function test_unsupported_ad_type_is_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Ads(type: 'banner');
    }

    private function enableAds(): void
    {
        config([
            'services.adsense.enabled' => true,
            'services.adsense.preview' => false,
            'services.adsense.client' => 'ca-pub-1701186115041469',
        ]);
    }

    private function firstToolUrl(): string
    {
        $routeName = collect(config('conversion.calculators', []))->pluck('route_name')->filter()->first();

        return route($routeName);
    }
}
