<x-calc.page
    title="Complex Number Calculator - SolveKit"
    description="Free complex number calculator: add, subtract, multiply and divide complex numbers, with rectangular, polar and exponential forms and an Argand diagram."
    lede="Calculate with complex numbers."
    about="A complex number a + bi has a real part a and an imaginary part b, with i² = −1. Multiply like brackets and replace i² by −1; divide by multiplying top and bottom by the conjugate. Every complex number also has a modulus r and an argument θ: z = r(cos θ + i sin θ) = re^(iθ). Also known as imaginary number calculator and polar form calculator."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1', 'op', 'z2']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is (3 + 4i)(1 − 2i)?', 'answer' => '11 − 2i.'],
        ['question' => 'And (3 + 4i) ÷ (1 − 2i)?', 'answer' => '−1 + 2i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="z1" label="First number" value="3 + 4i" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="*" />
        <x-calc.field name="z2" label="Second number" value="1 − 2i" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '3 + 4i', 'op' => '*', 'z2' => '1 - 2i'],
        'Divide' => ['z1' => '3 + 4i', 'op' => '/', 'z2' => '1 - 2i'],
        'Add' => ['z1' => '2.5 - i', 'op' => '+', 'z2' => '-1 + 3i'],
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
