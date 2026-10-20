<x-calc.page
    title="Integer Calculator - SolveKit"
    description="Free integer calculator: add, subtract, multiply and divide positive and negative whole numbers exactly."
    lede="Calculate with integers."
    about="Integer rules: adding a negative is subtracting; subtracting a negative is adding; a product or quotient of two numbers with the same sign is positive, otherwise negative. Division of integers may give a fraction."
    :calc="['engine' => 'mt-arith', 'tool' => 'arith', 'fields' => ['a', 'op', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is −12 × −7?', 'answer' => '84.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="First integer" value="-12" type="text" inputmode="decimal" />
        <x-calc.select name="op" label="Operation" :options="['+' => '+', '-' => '−', '*' => '×', '/' => '÷']" selected="*" />
        <x-calc.field name="b" label="Second integer" value="-7" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '-12', 'op' => '*', 'b' => '-7'],
        'Subtract a negative' => ['a' => '5', 'op' => '-', 'b' => '-8'],
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
            <li>sign rules</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
