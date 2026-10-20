<x-calc.page
    title="e Calculator | eˣ | e Raised to Power of x - SolveKit"
    description="Free e calculator: eˣ (e raised to the power x) for any x, with e⁻ˣ and the series."
    lede="Raise e to a power."
    about="e ≈ 2.718281828 is the base of natural growth: eˣ is the only function equal to its own derivative. Continuous compounding uses it (A = Pe^(rt)), and e^(iπ) = −1 links it to π."
    :calc="['engine' => 'mt-explog', 'tool' => 'exp_e', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is e²?', 'answer' => '7.3890560989307.'],
    ]"
>
    <x-calc.field name="x" label="Exponent x" value="2" step="any" />

    <x-calc.result label="eˣ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 2],
        'Negative' => ['x' => -1],
        'One' => ['x' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'inverse' => ['label' => 'Check with ln'],
            'reciprocal' => ['label' => 'e⁻ˣ'],
            'series' => ['label' => 'Series'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>eˣ = Σ xⁿ/n!</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
