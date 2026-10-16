<x-calc.page
    title="Electronegativity Calculator - SolveKit"
    description="Free electronegativity calculator: Pauling electronegativity difference between two elements, bond type and percent ionic character."
    lede="Compare the electronegativity of two elements and classify their bond."
    about="Electronegativity is how strongly an atom attracts bonding electrons. Values are on the Pauling scale (fluorine 3.98). The bond-type cut-offs (0.4 and 1.7) are a common teaching convention, and real bonds lie on a continuum."
    :calc="['engine' => 'chem-general', 'tool' => 'electronegativity', 'fields' => ['element_a', 'element_b'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'symbol', 'electronegativity'])]]"
    :how-to="[
        ['name' => 'Pick two elements', 'text' => 'The order does not matter.'],
    ]"
    :faqs="[
        ['question' => 'Which element is most electronegative?', 'answer' => 'Fluorine, at 3.98 on the Pauling scale.'],
        ['question' => 'What Δχ makes a bond ionic?', 'answer' => 'Above about 1.7 by the usual convention, e.g. NaCl at 2.23.'],
        ['question' => 'Why do noble gases have no value?', 'answer' => 'Most form no bonds, so no Pauling value is defined for helium, neon or argon.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="element_a" label="First element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Na" />
        <x-calc.select name="element_b" label="Second element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Cl" />
    </div>

    <x-calc.result label="Electronegativity difference" />

    <x-calc.options :examples="[
        'Na–Cl' => ['element_a' => 'Na', 'element_b' => 'Cl'],
        'C–H' => ['element_a' => 'C', 'element_b' => 'H'],
        'O–H' => ['element_a' => 'O', 'element_b' => 'H'],
        'H–F' => ['element_a' => 'H', 'element_b' => 'F'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'a' => ['label' => 'First element'],
            'b' => ['label' => 'Second element'],
            'ionic' => ['label' => 'Ionic character'],
            'more' => ['label' => 'Electrons shift towards'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Δχ = |χA − χB| (Pauling)</li>
            <li>nonpolar < 0.4 ≤ polar ≤ 1.7 < ionic</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
