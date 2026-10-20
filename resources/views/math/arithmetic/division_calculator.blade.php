<x-calc.page
    title="Division Calculator - SolveKit"
    description="Free division calculator: divide two numbers exactly, with the decimal (repeating digits marked) and the fraction."
    lede="Divide numbers."
    about="The quotient is shown exactly: 22 ÷ 7 = 3.(142857) = 22/7. For whole-number division with a remainder use the quotient or long division calculators."
    :calc="['engine' => 'mt-arith', 'tool' => 'arith', 'fields' => ['a', 'b'], 'op' => '/']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 22 ÷ 7?', 'answer' => '3.(142857).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Dividend" value="22" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Divisor" value="7" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Quotient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '22', 'b' => '7'],
        'Decimals' => ['a' => '7.5', 'b' => '0.25'],
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
            <li>a ÷ b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
