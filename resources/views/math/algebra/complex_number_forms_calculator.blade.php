<x-calc.page
    title="Complex Number Forms Calculator - SolveKit"
    description="Free complex number forms calculator: convert between rectangular, polar, trigonometric and exponential forms."
    lede="Convert a complex number between forms."
    about="The same complex number can be written as a + bi (rectangular), r∠θ (polar), r(cos θ + i sin θ) (trigonometric) or re^(iθ) (exponential), with r = √(a² + b²) and θ = atan2(b, a)."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1'], 'op' => 'form', 'show' => 'polar']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 1 + i in polar form?', 'answer' => '1.414213562 ∠ 45°.'],
    ]"
>
    <x-calc.field name="z1" label="Complex number" value="1 + i" type="text" inputmode="text" />

    <x-calc.result label="Polar form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '1 + i'],
        'Negative' => ['z1' => '-3 - 3i'],
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
            <li>r = √(a² + b²), θ = atan2(b, a)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
