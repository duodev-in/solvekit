<x-calc.page
    title="Inequality to Interval Notation Calculator - SolveKit"
    description="Free inequality to interval notation calculator: solve a linear inequality and write the answer in interval notation."
    lede="Convert an inequality to interval notation."
    about="Interval notation uses brackets for included endpoints and parentheses for excluded ones and for ±∞: x ≥ 2 is [2, ∞), −3 < x ≤ 5 is (−3, 5], and x ≠ 1 is (−∞, 1) ∪ (1, ∞)."
    :calc="['engine' => 'mt-algebra', 'tool' => 'linear_ineq', 'fields' => ['ineq']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Write 2x + 3 < 7 in interval notation.', 'answer' => '(−∞, 2).'],
    ]"
>
    <x-calc.field name="ineq" label="Inequality" value="2x + 3 < 7" type="text" inputmode="text" />

    <x-calc.result label="Interval notation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ineq' => '2x + 3 < 7'],
        'Not equal' => ['ineq' => 'x != 1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Number line" name="line" />
        <x-calc.rows heading="Details" :rows="[
            'interval' => ['label' => 'Interval notation'],
            'builder' => ['label' => 'Set-builder notation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>[ ] included, ( ) excluded</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
