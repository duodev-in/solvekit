<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use InvalidArgumentException;

class Ads extends Component
{
    /**
     * AdSense markup attributes for each supported ad unit type.
     *
     * @var array<string, array<string, string>>
     */
    public const UNIT_ATTRIBUTES = [
        'display' => [
            'data-ad-format' => 'auto',
            'data-full-width-responsive' => 'true',
        ],
        'in-article' => [
            'data-ad-layout' => 'in-article',
            'data-ad-format' => 'fluid',
        ],
        'feed' => [
            'data-ad-format' => 'fluid',
            'data-ad-layout-key' => '-fb+5w+4e-db+86',
        ],
        'multiplex' => [
            'data-ad-format' => 'autorelaxed',
        ],
    ];

    public function __construct(
        public string $type = 'display',
        public string $placement = 'default',
        public string $label = 'Advertisement',
    ) {
        if (! array_key_exists($type, self::UNIT_ATTRIBUTES)) {
            throw new InvalidArgumentException("Unsupported ad type [{$type}].");
        }
    }

    public function shouldRender(): bool
    {
        if ($this->isHiddenForCurrentUser()) {
            return false;
        }

        return $this->isLive() || $this->isPreview();
    }

    public function isLive(): bool
    {
        return (bool) config('services.adsense.enabled')
            && filled(config('services.adsense.client'))
            && filled($this->adSlot());
    }

    public function isPreview(): bool
    {
        return ! $this->isLive() && (bool) config('services.adsense.preview');
    }

    public function client(): string
    {
        return (string) config('services.adsense.client');
    }

    public function adSlot(): ?string
    {
        $slot = config("services.adsense.slots.{$this->type}");

        return filled($slot) ? (string) $slot : null;
    }

    /**
     * @return array<string, string>
     */
    public function unitAttributes(): array
    {
        return self::UNIT_ATTRIBUTES[$this->type];
    }

    public function render(): View
    {
        return view('components.ads');
    }

    private function isHiddenForCurrentUser(): bool
    {
        $user = auth()->user();
        $hiddenRoles = config('services.adsense.hidden_for_roles', []);

        return $user !== null
            && $hiddenRoles !== []
            && method_exists($user, 'hasAnyRole')
            && $user->hasAnyRole($hiddenRoles);
    }
}
