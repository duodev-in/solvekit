<x-calc.page
    title="Absolute Value Equation Calculator - SolveKit"
    description="Free absolute value equation calculator: solve |ax + b| = c or |ax + b| = |cx + d| with both cases and the check."
    lede="Solve an absolute value equation."
    about="An absolute value equation |u| = v splits into two cases, u = v and u = −v. Each answer is checked, because cases can give extraneous solutions; |u| = negative has no solution."
    :calc="['engine' => 'mt-algebra', 'tool' => 'abs_equation', 'fields' => ['eq']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve |2x − 3| = 7.', 'answer' => 'x = −2,  x = 5.'],
    ]"
>
    <x-calc.field name="eq" label="Equation" value="|2x - 3| = 7" type="text" inputmode="text" />

    <x-calc.result label="Solutions" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => '|2x - 3| = 7'],
        'Two bars' => ['eq' => '|x - 1| = |2x + 4|'],
        'None' => ['eq' => '|x + 2| = -3'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Number line" name="line" />
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Number of solutions'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|u| = v ⇒ u = ±v</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
