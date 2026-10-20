<x-calc.page
    title="Average Rate of Change Calculator - SolveKit"
    description="Free average rate of change calculator: (f(b) − f(a)) ÷ (b − a) for any function, exact for polynomials and rational functions."
    lede="Find the average rate of change."
    about="The average rate of change of f between a and b is the slope of the secant line, (f(b) − f(a)) ÷ (b − a). For f(x) = x² + 3x from 1 to 4 it is (28 − 4) ÷ 3 = 8."
    :calc="['engine' => 'mt-coord', 'tool' => 'rate_change', 'fields' => ['fx', 'a', 'b']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the average rate of change of x² + 3x from 1 to 4?', 'answer' => '8.'],
    ]"
>
    <x-calc.field name="fx" label="f(x)" value="x^2 + 3x" type="text" inputmode="text" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="From x = a" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="To x = b" value="4" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Average rate of change" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fx' => 'x^2 + 3x', 'a' => '1', 'b' => '4'],
        'Root' => ['fx' => 'sqrt(x)', 'a' => '1', 'b' => '4'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'fa' => ['label' => 'f(a)'],
            'fb' => ['label' => 'f(b)'],
            'secant' => ['label' => 'Secant line'],
            'decimal' => ['label' => 'Decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(f(b) − f(a)) ÷ (b − a)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
