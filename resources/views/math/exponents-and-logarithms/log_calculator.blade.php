<x-calc.page
    title="Log Calculator (Logarithm) - SolveKit"
    description="Free log calculator: logarithm of any positive number to any base (10, e, 2 or your own), exact when the answer is rational."
    lede="Find a logarithm."
    about="The logarithm log_b(x) is the power you raise b to in order to get x: log₁₀(1000) = 3 because 10³ = 1000. Any base works through the change-of-base formula log_b(x) = ln x ÷ ln b. Logs of zero and negative numbers are undefined (in the real numbers)."
    :calc="['engine' => 'mt-explog', 'tool' => 'log', 'fields' => ['x', 'base']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is log₁₀(1000)?', 'answer' => '3.'],
        ['question' => 'What is log₃(20)?', 'answer' => '2.726833027861.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number x" value="1000" type="text" inputmode="decimal" />
        <x-calc.field name="base" label="Base b" value="10" type="text" help="Type e for the natural log" inputmode="decimal" />
    </div>

    <x-calc.result label="Logarithm" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '1000', 'base' => '10'],
        'Base 3' => ['x' => '20', 'base' => '3'],
        'Fraction' => ['x' => '1/8', 'base' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ln' => ['label' => 'Natural log ln'],
            'log10' => ['label' => 'Common log log₁₀'],
            'log2' => ['label' => 'Binary log log₂'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>log_b(x) = ln x ÷ ln b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
