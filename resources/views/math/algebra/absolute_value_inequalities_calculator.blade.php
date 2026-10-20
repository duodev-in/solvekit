<x-calc.page
    title="Absolute Value Inequalities Calculator - SolveKit"
    description="Free absolute value inequalities calculator: solve |ax + b| < c, ≤, > or ≥, with interval notation and a number line."
    lede="Solve an absolute value inequality."
    about="|u| < c means −c < u < c (a single interval); |u| > c means u < −c or u > c (two rays). The solution is given in interval and set-builder notation and drawn on a number line."
    :calc="['engine' => 'mt-algebra', 'tool' => 'abs_inequality', 'fields' => ['ineq']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve |2x − 3| < 7.', 'answer' => '(−2, 5).'],
        ['question' => 'Solve |x + 1| ≥ 2.', 'answer' => '(−∞, −3] ∪ [1, ∞).'],
    ]"
>
    <x-calc.field name="ineq" label="Inequality" value="|2x - 3| < 7" type="text" inputmode="text" />

    <x-calc.result label="Solution set" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ineq' => '|2x - 3| < 7'],
        'Greater' => ['ineq' => '|x + 1| >= 2'],
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
            <li>|u| < c ⇔ −c < u < c</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
