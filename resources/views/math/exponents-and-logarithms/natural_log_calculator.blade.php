<x-calc.page
    title="Natural Log Calculator - SolveKit"
    description="Free natural log calculator: ln(x), the logarithm to base e, with log₁₀ and log₂."
    lede="Find the natural logarithm."
    about="The natural logarithm ln x is the log to base e ≈ 2.71828. ln e = 1, ln 1 = 0 and ln(ab) = ln a + ln b. It appears wherever growth is continuous, in calculus (d/dx ln x = 1/x) and in compound interest."
    :calc="['engine' => 'mt-explog', 'tool' => 'log', 'fields' => ['x', 'base']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is ln(10)?', 'answer' => '2.302585092994.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number x" value="10" type="text" inputmode="decimal" />
        <x-calc.field name="base" label="Base b" value="e" type="text" help="Type e for the natural log" inputmode="decimal" />
    </div>

    <x-calc.result label="Logarithm" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '10', 'base' => 'e'],
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
