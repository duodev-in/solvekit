<x-calc.page
    title="Divide Complex Numbers Calculator - SolveKit"
    description="Free divide complex numbers calculator: (a + bi) ÷ (c + di) using the conjugate."
    lede="Divide complex numbers."
    about="Multiply top and bottom by the conjugate of the denominator: (a + bi)/(c + di) = (a + bi)(c − di)/(c² + d²)."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1', 'op', 'z2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is (5 + 5i) ÷ (1 + 2i)?', 'answer' => '3 − i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="z1" label="First number" value="5 + 5i" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="/" />
        <x-calc.field name="z2" label="Second number" value="1 + 2i" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '5 + 5i', 'op' => '/', 'z2' => '1 + 2i'],
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
