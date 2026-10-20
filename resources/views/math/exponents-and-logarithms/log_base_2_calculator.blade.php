<x-calc.page
    title="Log Base 2 Calculator - SolveKit"
    description="Free log base 2 calculator: log₂(x), exact for powers of two, with the bits needed."
    lede="Find the binary logarithm."
    about="log₂(x) answers how many times you double 1 to reach x: log₂(1024) = 10. It counts bits (a number below 2ⁿ fits in n bits), halving steps in binary search and octaves in music."
    :calc="['engine' => 'mt-explog', 'tool' => 'log', 'fields' => ['x', 'base']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is log₂(1024)?', 'answer' => '10.'],
        ['question' => 'And log₂(100)?', 'answer' => '6.643856189775.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number x" value="1024" type="text" inputmode="decimal" />
        <x-calc.field name="base" label="Base b" value="2" type="text" help="Type e for the natural log" inputmode="decimal" />
    </div>

    <x-calc.result label="Logarithm" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '1024', 'base' => '2'],
        'Hundred' => ['x' => '100', 'base' => '2'],
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
