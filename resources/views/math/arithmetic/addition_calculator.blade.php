<x-calc.page
    title="Addition Calculator - SolveKit"
    description="Free addition calculator: add any list of numbers exactly, including long numbers, decimals and negatives."
    lede="Add numbers."
    about="Numbers are added exactly, digit by digit, so long whole numbers and decimals such as 0.1 + 0.2 = 0.3 never show floating-point errors. Enter as many numbers as you need."
    :calc="['engine' => 'mt-arith', 'tool' => 'arith', 'fields' => ['list'], 'op' => '+']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 1234.56 + 789.1 − 45?', 'answer' => '1,978.66.'],
    ]"
>
    <x-calc.textarea name="list" label="Numbers (one per line or separated by commas)" value="1234.56
789.1
-45" rows="5" />

    <x-calc.result label="Sum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '1234.56
789.1
-45'],
        'Big' => ['list' => '99999999999999999999
1'],
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
            <li>a + b + …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
