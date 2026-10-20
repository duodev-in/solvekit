<x-calc.page
    title="Graphing Inequalities on a Number Line Calculator - SolveKit"
    description="Free number line inequality calculator: solve a linear inequality or compound inequality and draw it on a number line."
    lede="Graph an inequality on a number line."
    about="Solve as for an equation, but flip the sign when multiplying or dividing by a negative number. On the number line, an open circle means the endpoint is excluded (< or >) and a closed one that it is included (≤ or ≥)."
    :calc="['engine' => 'mt-algebra', 'tool' => 'linear_ineq', 'fields' => ['ineq']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Graph −1 ≤ x − 2 < 4.', 'answer' => '[1, 6).'],
    ]"
>
    <x-calc.field name="ineq" label="Inequality" value="-1 <= x - 2 < 4" type="text" inputmode="text" />

    <x-calc.result label="Interval notation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ineq' => '-1 <= x - 2 < 4'],
        'Flip' => ['ineq' => '3 - 2x >= 5'],
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
            <li>flip the sign for negatives</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
