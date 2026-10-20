<x-calc.page
    title="Cosh Calculator - SolveKit"
    description="Free cosh calculator: the hyperbolic cosine of x, with the other hyperbolic functions and the inverse."
    lede="Evaluate cosh x."
    about="cosh x = (eˣ + e⁻ˣ)/2 is the shape of a hanging chain (catenary). It is even and never below 1."
    :calc="['engine' => 'mt-alg2', 'tool' => 'special', 'fields' => ['x', 'which'], 'fn' => 'hyper']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is cosh(1)?', 'answer' => '1.5430806348152.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="x" value="1" step="any" />
        <x-calc.select name="which" label="Function" :options="['sinh' => 'sinh', 'cosh' => 'cosh', 'tanh' => 'tanh', 'coth' => 'coth', 'sech' => 'sech', 'csch' => 'csch']" selected="cosh" />
    </div>

    <x-calc.result label="Value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 1, 'which' => 'cosh'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'sinh' => ['label' => 'sinh x'],
            'cosh' => ['label' => 'cosh x'],
            'tanh' => ['label' => 'tanh x'],
            'others' => ['label' => 'coth, sech, csch'],
            'inverse' => ['label' => 'Inverse functions'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sinh x = (eˣ − e⁻ˣ)/2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
