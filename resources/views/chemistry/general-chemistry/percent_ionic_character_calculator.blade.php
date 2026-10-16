<x-calc.page
    title="Percent Ionic Character Calculator - SolveKit"
    description="Free percent ionic character calculator: Pauling and Hannay–Smyth ionic character of a bond from electronegativity."
    lede="Estimate how ionic a bond is from the electronegativity difference."
    about="Pauling related ionic character to the electronegativity difference: % = (1 − e^(−Δχ²/4)) × 100. Hannay and Smyth (1946) gave 16Δχ + 3.5Δχ². Both are models fitted to dipole data, so they give somewhat different numbers."
    :calc="['engine' => 'chem-general', 'tool' => 'ionic_character', 'fields' => ['mode', 'element_a', 'element_b', 'delta'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'electronegativity'])]]"
    :how-to="[
        ['name' => 'Pick two elements', 'text' => 'Or type the difference.'],
    ]"
    :faqs="[
        ['question' => 'How ionic is H–Cl?', 'answer' => 'About 21% by Pauling\'s formula (Δχ = 0.96).'],
        ['question' => 'Is any bond 100% ionic?', 'answer' => 'No; even CsF keeps some covalent character.'],
        ['question' => 'Why do the two formulas differ?', 'answer' => 'They are fitted to different data sets.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['elements' => 'Two elements', 'delta' => 'Δχ value']" selected="elements" />

    <div data-show-when="mode:elements">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="element_a" label="First element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="H" />
            <x-calc.select name="element_b" label="Second element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Cl" />
        </div>
    </div>

    <div data-show-when="mode:delta" hidden>
        <x-calc.field name="delta" label="Electronegativity difference" value="1" min="0" />
    </div>

    <x-calc.result label="Ionic character" />

    <x-calc.options :examples="[
        'H–Cl' => ['mode' => 'elements', 'element_a' => 'H', 'element_b' => 'Cl'],
        'Na–Cl' => ['mode' => 'elements', 'element_a' => 'Na', 'element_b' => 'Cl'],
        'Δχ = 2' => ['mode' => 'delta', 'delta' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hannay' => ['label' => 'Hannay–Smyth'],
            'covalent' => ['label' => 'Covalent character'],
            'delta' => ['label' => 'Δχ'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Pauling: % = (1 − e^(−Δχ²/4)) × 100</li>
            <li>Hannay–Smyth: % = 16Δχ + 3.5Δχ²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
