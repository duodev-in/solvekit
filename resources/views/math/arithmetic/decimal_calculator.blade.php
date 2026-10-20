<x-calc.page
    title="Decimal Calculator - SolveKit"
    description="Free decimal calculator: add, subtract, multiply and divide decimals exactly, without floating-point errors."
    lede="Calculate with decimals."
    about="Computers store most decimals in binary, so 0.1 + 0.2 gives 0.30000000000000004 in many programs. Here decimals are exact fractions, so 0.1 + 0.2 = 0.3 and 1.1 × 1.1 = 1.21."
    :calc="['engine' => 'mt-arith', 'tool' => 'arith', 'fields' => ['a', 'op', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.1 + 0.2?', 'answer' => '0.3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="First number" value="0.1" type="text" inputmode="decimal" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="+" />
        <x-calc.field name="b" label="Second number" value="0.2" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '0.1', 'op' => '+', 'b' => '0.2'],
        'Multiply' => ['a' => '1.1', 'op' => '*', 'b' => '1.1'],
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
            <li>exact decimal arithmetic</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
