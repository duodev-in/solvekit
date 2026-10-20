<x-calc.page
    title="Divisibility Test Calculator - SolveKit"
    description="Free divisibility test calculator: whether a number is divisible by another, with the divisibility rule for 2 to 12."
    lede="Test divisibility."
    about="Divisibility rules check without dividing: by 3 or 9 when the digit sum is, by 4 when the last two digits are, by 11 when the alternating digit sum is. The tool also lists every divisor from 2 to 12."
    :calc="['engine' => 'mt-number', 'tool' => 'divisibility', 'fields' => ['n', 'd']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 7392 divisible by 11?', 'answer' => 'Yes, 7,392 is divisible by 11.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Number" value="7392" type="text" inputmode="decimal" />
        <x-calc.field name="d" label="Divisor" value="11" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Divisible?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '7392', 'd' => '11'],
        'By 3' => ['n' => '123456', 'd' => '3'],
        'By 7' => ['n' => '1001', 'd' => '7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rule' => ['label' => 'Rule'],
            'quotient' => ['label' => 'Division'],
            'all' => ['label' => 'Divisible by (2–12)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n mod d = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
