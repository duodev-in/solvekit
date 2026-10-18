<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/**
 * Looks up calculators across every calculator section (Conversions, Biology & Nature, Chemistry, Construction).
 */
class CalculatorCatalog
{
    /**
     * Calculator sections: config file, display title and index route.
     *
     * @var array<string, array{config: string, title: string, index: string}>
     */
    public const SECTIONS = [
        'conversion' => ['config' => 'conversion', 'title' => 'Conversion Tools', 'index' => 'conversion.index'],
        'biology' => ['config' => 'biology', 'title' => 'Biology & Nature', 'index' => 'biology.index'],
        'chemistry' => ['config' => 'chemistry', 'title' => 'Chemistry', 'index' => 'chemistry.index'],
        'construction' => ['config' => 'construction', 'title' => 'Construction', 'index' => 'construction.index'],
    ];

    /**
     * Finds the calculator served by a route, with its section and category.
     *
     * @return array{section: array{config: string, title: string, index: string}, tool: array<string, mixed>, category: array<string, mixed>|null}|null
     */
    public function forRoute(?string $routeName): ?array
    {
        foreach (self::SECTIONS as $section) {
            $tool = collect(config("{$section['config']}.calculators", []))
                ->first(fn (array $tool) => ($tool['route_name'] ?? null) === $routeName);

            if ($tool) {
                $category = collect(config("{$section['config']}.categories", []))->firstWhere('slug', $tool['category_slug'] ?? null);

                return ['section' => $section, 'tool' => $tool, 'category' => $category];
            }
        }

        return null;
    }

    /**
     * Other calculators in the same category, for the Related tools card.
     *
     * @param  array<string, mixed>  $tool
     * @return Collection<int, array<string, mixed>>
     */
    public function related(array $section, array $tool, int $limit = 4): Collection
    {
        return collect(config("{$section['config']}.calculators", []))
            ->filter(fn (array $other) => ($other['category_slug'] ?? null) === ($tool['category_slug'] ?? false)
                && ($other['route_name'] ?? null) !== ($tool['route_name'] ?? null)
                && Route::has($other['route_name'] ?? ''))
            ->take($limit)
            ->values();
    }
}
