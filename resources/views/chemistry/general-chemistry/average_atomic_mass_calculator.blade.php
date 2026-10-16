<x-calc.page
    title="Average Atomic Mass Calculator - SolveKit"
    description="Free average atomic mass calculator: weighted average of isotope masses and abundances, or any element from NIST isotope data."
    lede="Calculate an element's average atomic mass from its isotopes."
    about="The average atomic mass is the abundance-weighted mean of the isotope masses. Enter your own isotopes (mass and percent or fraction, one per line), or pick an element to use NIST isotope masses and natural abundances."
    :calc="['engine' => 'chem-general', 'tool' => 'average_atomic_mass', 'fields' => ['mode', 'isotopes', 'element'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'symbol', 'isotopes'])]]"
    :how-to="[
        ['name' => 'Enter each isotope', 'text' => 'Mass then abundance, e.g. 34.96885 75.76.'],
        ['name' => 'Or pick an element', 'text' => 'Uses NIST natural abundances.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate average atomic mass?', 'answer' => 'Multiply each isotope mass by its abundance as a fraction and add them up.'],
        ['question' => 'Why is chlorine 35.45?', 'answer' => 'About 76% is chlorine-35 and 24% chlorine-37.'],
        ['question' => 'What if abundances do not add to 100%?', 'answer' => 'The result shows the total and a version scaled to 100%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Isotopes from" :options="['custom' => 'My data', 'element' => 'An element']" selected="custom" />

    <div data-show-when="mode:custom">
        <x-calc.textarea name="isotopes" label="Isotope mass and abundance, one per line" value="34.96885 75.76
36.96590 24.24" help="Abundance as a percent or a fraction" rows="4" />
    </div>

    <div data-show-when="mode:element" hidden>
        <x-calc.select name="element" label="Element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Cl" />
    </div>

    <x-calc.result label="Average atomic mass" />

    <x-calc.options :examples="[
        'Chlorine (my data)' => ['mode' => 'custom', 'isotopes' => '34.96885 75.76
36.96590 24.24'],
        'Copper (NIST)' => ['mode' => 'element', 'element' => 'Cu'],
        'Magnesium (NIST)' => ['mode' => 'element', 'element' => 'Mg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Abundances add up to'],
            'normalised' => ['label' => 'Scaled to 100%'],
        ]" />
        <x-calc.quick-ref heading="Each isotope" name="contributions" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>average = Σ mass × abundance</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
