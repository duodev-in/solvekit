<x-calc.page
    title="Set Builder Calculator - SolveKit"
    description="Free set builder calculator: write the solution of an inequality in set-builder notation, with interval notation and a number line."
    lede="Write a set in set-builder notation."
    about="Set-builder notation describes a set by a rule: {x | x > 2} is read “the set of x such that x is greater than 2”. It is equivalent to the interval (2, ∞)."
    :calc="['engine' => 'mt-algebra', 'tool' => 'linear_ineq', 'fields' => ['ineq'], 'mode' => 'builder']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Write −3 < 2x + 1 ≤ 9 in set-builder notation.', 'answer' => '{x | −2 < x ≤ 4}.'],
    ]"
>
    <x-calc.field name="ineq" label="Inequality" value="-3 < 2x + 1 <= 9" type="text" inputmode="text" />

    <x-calc.result label="Set-builder notation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ineq' => '-3 < 2x + 1 <= 9'],
        'Ray' => ['ineq' => 'x > 2'],
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
            <li>{x | condition}</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
