<x-calc.page
    title="Polynomial Graphing Calculator - SolveKit"
    description="Free polynomial graphing calculator: graph any polynomial with its roots, turning points, inflection points and end behaviour."
    lede="Graph a polynomial."
    about="The real roots are where the graph crosses the x-axis, the turning points where f′(x) = 0 and the inflection points where f″(x) = 0. A polynomial of degree n has at most n roots and n − 1 turning points; the leading term decides the end behaviour. Also known as polynomial grapher."
    :calc="['engine' => 'mt-coord', 'tool' => 'poly_graph', 'fields' => ['p']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Where does x³ − 3x + 1 cross the x-axis?', 'answer' => '−1.879385242, 0.3472963553, 1.532088886.'],
    ]"
>
    <x-calc.field name="p" label="Polynomial f(x)" value="x^3 - 3x + 1" type="text" inputmode="text" />

    <x-calc.result label="Real roots" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => 'x^3 - 3x + 1'],
        'Quartic' => ['p' => 'x^4 - 5x^2 + 4'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'roots' => ['label' => 'Roots'],
            'yint' => ['label' => 'y-intercept'],
            'turning' => ['label' => 'Turning points'],
            'inflection' => ['label' => 'Inflection points'],
            'end' => ['label' => 'End behaviour'],
            'degree' => ['label' => 'Degree'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f(x) = 0, f′(x) = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
