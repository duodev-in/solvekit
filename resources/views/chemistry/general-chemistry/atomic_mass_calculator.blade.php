<x-calc.page
    title="Atomic Mass Calculator - SolveKit"
    description="Free atomic mass calculator: standard atomic weight of any element and the exact mass, mass defect and binding energy of its natural isotopes."
    lede="Look up the atomic mass of an element or one of its isotopes."
    about="Standard atomic weights are the IUPAC (CIAAW) abridged values, averaged over the natural isotopes. Isotope masses are NIST relative atomic masses. The mass defect is the mass lost when protons and neutrons bind; times 931.494 MeV/u it gives the nuclear binding energy."
    :calc="['engine' => 'chem-general', 'tool' => 'atomic_mass', 'fields' => ['element', 'mode', 'mass_number'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'symbol', 'z', 'weight', 'uncertainty', 'mass_number', 'isotopes'])]]"
    :how-to="[
        ['name' => 'Pick the element', 'text' => 'Its standard atomic weight shows at once.'],
        ['name' => 'Choose one isotope', 'text' => 'For its exact mass and binding energy.'],
    ]"
    :faqs="[
        ['question' => 'What is the difference between atomic mass and atomic weight?', 'answer' => 'Atomic mass is the mass of one atom or isotope; the standard atomic weight is the average over the natural isotopes.'],
        ['question' => 'Why is iron-56 special?', 'answer' => 'It is among the most tightly bound nuclei, at about 8.79 MeV per nucleon.'],
        ['question' => 'Why do some elements show a number in brackets?', 'answer' => 'They have no stable isotopes, so the mass number of the longest-lived isotope is shown, e.g. [97] for technetium.'],
    ]"
>
    <x-calc.select name="element" label="Element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Fe" />

    <x-calc.segmented name="mode" legend="Show" :options="['element' => 'Element', 'isotope' => 'One isotope']" selected="element" />

    <div data-show-when="mode:isotope" hidden>
        <x-calc.field name="mass_number" label="Mass number" value="56" min="1" step="1" />
    </div>

    <x-calc.result label="Atomic mass" />

    <x-calc.options :examples="[
        'Iron' => ['element' => 'Fe', 'mode' => 'element'],
        'Iron-56 isotope' => ['element' => 'Fe', 'mode' => 'isotope', 'mass_number' => 56],
        'Carbon-13' => ['element' => 'C', 'mode' => 'isotope', 'mass_number' => 13],
        'Technetium' => ['element' => 'Tc', 'mode' => 'element'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'molar' => ['label' => 'Molar mass'],
            'z' => ['label' => 'Atomic number'],
            'isotopes_count' => ['label' => 'Natural isotopes'],
            'defect' => ['label' => 'Mass defect'],
            'binding' => ['label' => 'Binding energy'],
            'per_nucleon' => ['label' => 'Per nucleon'],
        ]" />
        <x-calc.quick-ref heading="Natural isotopes (NIST)" name="isotopes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>standard atomic weight: IUPAC CIAAW</li>
            <li>mass defect = Z m(¹H) + N mₙ − m(atom)</li>
            <li>binding energy = mass defect × 931.494 MeV/u</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
