<x-calc.page
    title="Compatible Numbers Calculator - SolveKit"
    description="Free compatible numbers calculator: estimate a sum, difference, product or quotient with easy numbers, and compare with the exact answer."
    lede="Estimate with compatible numbers."
    about="Compatible numbers are nearby values that are easy to work with mentally: 432 ÷ 7 ≈ 420 ÷ 7 = 60. For sums and products, round to the leading digits. The exact result and the estimate error are shown."
    :calc="['engine' => 'mt-arith', 'tool' => 'compatible', 'fields' => ['a', 'op', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Estimate 432 ÷ 7.', 'answer' => '62.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="First number" value="432" step="any" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="/" />
        <x-calc.field name="b" label="Second number" value="7" step="any" />
    </div>

    <x-calc.result label="Estimate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 432, 'op' => '/', 'b' => 7],
        'Sum' => ['a' => 378, 'op' => '+', 'b' => 514],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'compatible' => ['label' => 'Compatible numbers'],
            'exact' => ['label' => 'Exact result'],
            'error' => ['label' => 'Error'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>estimate with easy numbers</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
