<x-calc.page
    title="Sigmoid Calculator - SolveKit"
    description="Free sigmoid calculator: the logistic function σ(x) = 1 ÷ (1 + e⁻ˣ), its derivative, and the general logistic curve L ÷ (1 + e^(−k(x − x₀)))."
    lede="Evaluate the sigmoid function."
    about="The sigmoid squashes any number into (0, 1): σ(0) = 0.5, σ(2) = 0.881. Its derivative is σ(1 − σ). It is the activation in logistic regression and the shape of population growth with a ceiling L. Also known as logistic function calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'sigmoid', 'fields' => ['x', 'L', 'k', 'x0']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is σ(2)?', 'answer' => '0.88079707797788.'],
    ]"
>
    <x-calc.field name="x" label="x" value="2" step="any" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="L" label="Maximum L" value="1" step="any" />
        <x-calc.field name="k" label="Steepness k" value="1" step="any" />
        <x-calc.field name="x0" label="Midpoint x₀" value="0" step="any" />
    </div>

    <x-calc.result label="σ(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 2, 'L' => 1, 'k' => 1, 'x0' => 0],
        'Growth' => ['x' => 10, 'L' => 1000, 'k' => 0.5, 'x0' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'value' => ['label' => 'Value'],
            'derivative' => ['label' => 'Derivative'],
            'logit' => ['label' => 'Logit check'],
            'tanh' => ['label' => 'Via tanh'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>σ(x) = 1 ÷ (1 + e⁻ˣ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
