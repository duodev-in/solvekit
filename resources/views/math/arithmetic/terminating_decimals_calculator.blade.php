<x-calc.page
    title="Terminating Decimals Calculator - SolveKit"
    description="Free terminating decimals calculator: whether a fraction gives a terminating or repeating decimal, and why."
    lede="Does the decimal terminate?"
    about="In lowest terms, a fraction terminates exactly when its denominator's only prime factors are 2 and 5: 7/40 = 0.175 terminates (40 = 2³ × 5), but 7/30 = 0.2(3) repeats because of the factor 3."
    :calc="['engine' => 'mt-frac', 'tool' => 'terminating', 'fields' => ['value']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Does 7/40 terminate?', 'answer' => 'Terminating: 0.175 (3 decimal places).'],
    ]"
>
    <x-calc.field name="value" label="Fraction" value="7/40" type="text" inputmode="text" />

    <x-calc.result label="Terminating or repeating" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => '7/40'],
        'Repeating' => ['value' => '7/30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal'],
            'denominator' => ['label' => 'Denominator'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>b = 2ᵐ5ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
