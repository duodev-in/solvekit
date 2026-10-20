<x-calc.page
    title="Complex Conjugate Calculator - SolveKit"
    description="Free complex conjugate calculator: the conjugate of a + bi, and the product z·z̄ = |z|²."
    lede="Find the complex conjugate."
    about="The conjugate of a + bi is a − bi: the reflection in the real axis. Multiplying a number by its conjugate gives the real number a² + b², which is how complex division works."
    :calc="['engine' => 'mt-alg2', 'tool' => 'complex', 'fields' => ['z1', 'op', 'z2'], 'op' => 'conj']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the conjugate of 3 − 4i?', 'answer' => '3 + 4i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="z1" label="First number" value="3 - 4i" type="text" inputmode="text" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="*" />
        <x-calc.field name="z2" label="Second number" value="1 − 2i" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['z1' => '3 - 4i', 'op' => '*', 'z2' => '1 - 2i'],
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
