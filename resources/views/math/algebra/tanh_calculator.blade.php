<x-calc.page
    title="Tanh Calculator - SolveKit"
    description="Free tanh calculator: the hyperbolic tangent of x, with the other hyperbolic functions and the inverse."
    lede="Evaluate tanh x."
    about="tanh x = sinh x/cosh x runs from −1 to 1 and is used as an activation function in neural networks."
    :calc="['engine' => 'mt-alg2', 'tool' => 'special', 'fields' => ['x', 'which'], 'fn' => 'hyper']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is tanh(1)?', 'answer' => '0.76159415595576.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="x" value="1" step="any" />
        <x-calc.select name="which" label="Function" :options="['sinh' => 'sinh', 'cosh' => 'cosh', 'tanh' => 'tanh', 'coth' => 'coth', 'sech' => 'sech', 'csch' => 'csch']" selected="tanh" />
    </div>

    <x-calc.result label="Value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 1, 'which' => 'tanh'],
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
