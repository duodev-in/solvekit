<x-calc.page
    title="Negative Log Calculator - SolveKit"
    description="Free negative log calculator: −log₁₀(x), as used for pH, pKa and pOH."
    lede="Find the negative logarithm."
    about="The negative logarithm −log₁₀(x) turns tiny concentrations into everyday numbers: a hydrogen-ion concentration of 1 × 10⁻⁷ mol/L gives pH 7. Each unit is a factor of 10."
    :calc="['engine' => 'mt-explog', 'tool' => 'log', 'fields' => ['x'], 'base' => '10', 'negative' => true]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is −log(3.2 × 10⁻⁶)?', 'answer' => '5.49485002168.'],
    ]"
>
    <x-calc.field name="x" label="Number x" value="0.0000032" type="text" help="Accepts E notation such as 3.2e-6" inputmode="decimal" />

    <x-calc.result label="−log₁₀(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '0.0000032'],
        'Neutral' => ['x' => '1e-7'],
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
            <li>p(x) = −log₁₀(x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
