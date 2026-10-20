<x-calc.page
    title="Complex Number to Rectangular Form Calculator - SolveKit"
    description="Free complex number to rectangular form calculator: a + bi from the modulus and argument."
    lede="Convert to rectangular form."
    about="From polar form, a = r cos θ and b = r sin θ. Enter the number in any form the calculator reads (such as 1.4142 + 1.4142i or a product) to see a + bi."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1', 'op', 'z2'], 'op' => 'form', 'show' => 'rect']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 2(cos 45° + i sin 45°) in rectangular form?', 'answer' => '1.414213562 + 1.414213562i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="z1" label="First number" value="1.4142135623731 + 1.4142135623731i" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="form" />
        <x-calc.field name="z2" label="Second number" value="1 − 2i" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '1.4142135623731 + 1.4142135623731i', 'op' => 'form', 'z2' => '1 - 2i'],
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
