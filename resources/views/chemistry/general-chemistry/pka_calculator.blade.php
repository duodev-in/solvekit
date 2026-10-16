<x-calc.page
    title="pKa Calculator - SolveKit"
    description="Free pKa calculator: convert Ka and pKa, or find pKa from a buffer pH or the pH of a weak acid solution, with pKb and Kb."
    lede="Convert Ka and pKa, or work out pKa from a pH measurement."
    about="pKa = −log₁₀ Ka. From a buffer, pKa = pH − log([A⁻]/[HA]). From the pH of a weak acid of known concentration, the calculation uses the full charge balance including water, not the “x is small” shortcut. pKb = pKw − pKa, with pKw = 13.995 at 25 °C (IAPWS)."
    :calc="['engine' => 'chem-general', 'tool' => 'pka', 'fields' => ['mode', 'ka', 'pka_value', 'ph', 'base', 'acid', 'concentration']]"
    :how-to="[
        ['name' => 'Pick what you know', 'text' => 'Ka, pKa, a buffer pH or an acid\'s pH.'],
        ['name' => 'Enter the values', 'text' => 'Concentrations in mol/L.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert Ka to pKa?', 'answer' => 'pKa = −log₁₀(Ka); for Ka = 1.8 × 10⁻⁵, pKa = 4.74.'],
        ['question' => 'What does a low pKa mean?', 'answer' => 'A stronger acid; each unit lower is ten times stronger.'],
        ['question' => 'How are pKa and pKb related?', 'answer' => 'pKa + pKb = pKw, which is 13.995 at 25 °C.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['ka' => 'Ka', 'pka' => 'pKa', 'ratio' => 'Buffer pH', 'solution' => 'Acid pH']" selected="ka" />

    <div data-show-when="mode:ka">
        <x-calc.field name="ka" label="Ka" value="1.8e-05" min="0" />
    </div>

    <div data-show-when="mode:pka" hidden>
        <x-calc.field name="pka_value" label="pKa" value="4.76" />
    </div>

    <div data-show-when="mode:ratio,solution" hidden>
        <x-calc.field name="ph" label="Measured pH" value="4.76" min="0" max="14" />
    </div>

    <div data-show-when="mode:ratio" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="base" label="Base [A⁻]" value="0.1" min="0" suffix="M" />
            <x-calc.field name="acid" label="Acid [HA]" value="0.1" min="0" suffix="M" />
        </div>
    </div>

    <div data-show-when="mode:solution" hidden>
        <x-calc.field name="concentration" label="Acid concentration" value="0.1" min="0" suffix="M" />
    </div>

    <x-calc.result label="pKa" />

    <x-calc.options :examples="[
        'Acetic acid Ka' => ['mode' => 'ka', 'ka' => 1.8e-05],
        'Buffer at pH 7.2' => ['mode' => 'ratio', 'ph' => 7.2, 'base' => 0.2, 'acid' => 0.1],
        '0.1 M acid at pH 2.87' => ['mode' => 'solution', 'ph' => 2.87, 'concentration' => 0.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ka' => ['label' => 'Ka'],
            'pkb' => ['label' => 'pKb of the conjugate base'],
            'kb' => ['label' => 'Kb'],
            'pkw' => ['label' => 'pKw used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pKa = −log₁₀ Ka</li>
            <li>buffer: pKa = pH − log([A⁻] ÷ [HA])</li>
            <li>weak acid: Ka = [H⁺]([H⁺] − [OH⁻]) ÷ (C − [H⁺] + [OH⁻])</li>
            <li>pKb = pKw − pKa</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
