<?php

namespace App\Services;

/**
 * Trims the reference tables in config/elements.php to what a page needs, so each
 * calculator page carries only the fields its script reads.
 */
class ChemistryData
{
    /**
     * Elements keyed by symbol with the requested fields.
     *
     * @param  list<string>  $fields
     * @return array<string, array<string, mixed>>
     */
    public function elements(array $fields = ['name', 'weight']): array
    {
        return collect(config('elements'))
            ->map(fn (array $element) => array_intersect_key($element, array_flip($fields)))
            ->all();
    }
}
