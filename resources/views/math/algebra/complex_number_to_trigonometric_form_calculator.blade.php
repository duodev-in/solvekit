<x-calc.page
    title="Complex Number to Trigonometric Form Calculator - SolveKit"
    description="Free complex number to trigonometric form calculator: r(cos θ + i sin θ) from a + bi."
    lede="Convert to trigonometric form."
    about="Trigonometric form writes z = r(cos θ + i sin θ), which makes powers and roots easy by De Moivre's theorem."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1', 'op', 'z2'], 'op' => 'form', 'show' => 'trig']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 1 + i in trigonometric form?', 'answer' => '1.414213562(cos 0.7853981634 + i sin 0.7853981634).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="z1" label="First number" value="1 + i" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="form" />
        <x-calc.field name="z2" label="Second number" value="1 − 2i" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '1 + i', 'op' => 'form', 'z2' => '1 - 2i'],
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
