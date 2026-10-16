<x-calc.page
    title="Effective Nuclear Charge Calculator - SolveKit"
    description="Free effective nuclear charge calculator: Zeff and shielding constant for any electron using Slater's rules."
    lede="Work out the effective nuclear charge felt by an electron with Slater's rules."
    about="Zeff = Z − S, where the shielding constant S comes from Slater's rules (1930). Electrons are grouped as (1s)(2s,2p)(3s,3p)(3d)(4s,4p)(4d)(4f)… Others in the same group shield 0.35 each (0.30 in 1s). For s and p electrons, each electron one shell lower shields 0.85 and deeper ones 1.00; for d and f electrons, all electrons in lower groups shield 1.00. Slater's rules are a standard model; computed values such as Clementi–Raimondi differ slightly."
    :calc="['engine' => 'chem-general', 'tool' => 'zeff', 'fields' => ['element', 'orbital'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'z', 'configuration'])]]"
    :how-to="[
        ['name' => 'Pick the element', 'text' => 'Its NIST ground-state configuration is used.'],
        ['name' => 'Pick the electron', 'text' => 'The outermost one, or any occupied orbital.'],
    ]"
    :faqs="[
        ['question' => 'What is the Zeff of a zinc 4s electron?', 'answer' => '4.35 by Slater\'s rules (Z 30 − S 25.65).'],
        ['question' => 'Why does Zeff rise across a period?', 'answer' => 'Protons are added faster than the extra shielding, so outer electrons are pulled in harder.'],
        ['question' => 'Are Slater\'s rules exact?', 'answer' => 'They are a simple model; quantum calculations give slightly different values.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="element" label="Element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Zn" />
        <x-calc.select name="orbital" label="Electron in" :options="['valence' => 'Outermost electron', '1-0' => '1s', '2-0' => '2s', '2-1' => '2p', '3-0' => '3s', '3-1' => '3p', '3-2' => '3d', '4-0' => '4s', '4-1' => '4p', '4-2' => '4d', '4-3' => '4f', '5-0' => '5s', '5-1' => '5p', '5-2' => '5d', '5-3' => '5f', '6-0' => '6s', '6-1' => '6p', '6-2' => '6d', '6-3' => '6f', '7-0' => '7s', '7-1' => '7p', '7-2' => '7d', '7-3' => '7f']" selected="valence" />
    </div>

    <x-calc.result label="Effective nuclear charge" />

    <x-calc.options :examples="[
        'Zinc 4s' => ['element' => 'Zn', 'orbital' => '4-0'],
        'Zinc 3d' => ['element' => 'Zn', 'orbital' => '3-2'],
        'Nitrogen 2p' => ['element' => 'N', 'orbital' => 'valence'],
        'Sodium 3s' => ['element' => 'Na', 'orbital' => 'valence'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shielding' => ['label' => 'Shielding constant S'],
            'z' => ['label' => 'Atomic number Z'],
            'configuration' => ['label' => 'Configuration'],
        ]" />
        <x-calc.quick-ref heading="Shielding by group" name="breakdown" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Zeff = Z − S</li>
            <li>same group 0.35 (1s 0.30)</li>
            <li>s, p: n − 1 shell 0.85, lower 1.00</li>
            <li>d, f: lower groups 1.00</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
