<x-calc.page
    title="Multiplication Calculator - SolveKit"
    description="Free multiplication calculator: multiply numbers exactly, however many digits they have."
    lede="Multiply numbers."
    about="Products of long numbers are exact: 123456789 × 987654321 = 121932631112635269. Decimals are exact too (0.1 × 0.3 = 0.03)."
    :calc="['engine' => 'mt-arith', 'tool' => 'arith', 'fields' => ['list'], 'op' => '*']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 123456789 × 987654321?', 'answer' => '121,932,631,112,635,269.'],
    ]"
>
    <x-calc.textarea name="list" label="Numbers to multiply" value="123456789
987654321" rows="4" />

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '123456789
987654321'],
        'Decimals' => ['list' => '0.1
0.3
12'],
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
            <li>a × b × …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
