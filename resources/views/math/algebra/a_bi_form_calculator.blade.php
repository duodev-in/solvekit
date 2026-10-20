<x-calc.page
    title="a+bi Form Calculator - SolveKit"
    description="Free a + bi form calculator: write any complex number result in standard rectangular form a + bi."
    lede="Write a complex number as a + bi."
    about="Standard (rectangular) form a + bi separates the real part a and the imaginary part b. Multiply out brackets and replace i² with −1 to reach it."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1', 'op', 'z2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Write (2 + 3i)(4 − i) in a + bi form.', 'answer' => '11 + 10i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="z1" label="First number" value="2 + 3i" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="*" />
        <x-calc.field name="z2" label="Second number" value="4 - i" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '2 + 3i', 'op' => '*', 'z2' => '4 - i'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Argand diagram" name="argand" />
        <x-calc.rows heading="Details" :rows="[
            'rect' => ['label' => 'Rectangular a + bi'],
            'polar' => ['label' => 'Polar r∠θ'],
            'trig' => ['label' => 'Trigonometric'],
            'exp' => ['label' => 'Exponential'],
            'conj' => ['label' => 'Conjugate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(a + bi)(c + di) = (ac − bd) + (ad + bc)i</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
