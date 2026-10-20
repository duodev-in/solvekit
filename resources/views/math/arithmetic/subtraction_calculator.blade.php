<x-calc.page
    title="Subtraction Calculator - SolveKit"
    description="Free subtraction calculator: subtract two numbers exactly, including long numbers and decimals."
    lede="Subtract numbers."
    about="Subtraction is done exactly: 1000000000000000001 − 2 = 999999999999999999, and 0.3 − 0.1 = 0.2. Use the long subtraction calculator to see the column method."
    :calc="['engine' => 'mt-arith', 'tool' => 'arith', 'fields' => ['a', 'b'], 'op' => '-']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 1000.5 − 0.75?', 'answer' => '999.75.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Minuend" value="1000.5" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Subtrahend" value="0.75" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Difference" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1000.5', 'b' => '0.75'],
        'Negative' => ['a' => '15', 'b' => '42'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact value'],
            'scientific' => ['label' => 'Approximate'],
            'digits' => ['label' => 'Size'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a − b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
