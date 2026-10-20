<x-calc.page
    title="Floor Division Calculator - SolveKit"
    description="Free floor division calculator: a // b (division rounded down) and the matching remainder, including negative numbers."
    lede="Calculate floor division."
    about="Floor division divides and rounds down to the next integer: 17 // 5 = 3 and −17 // 5 = −4. Together with the floored remainder it satisfies a = b × (a // b) + (a mod b)."
    :calc="['engine' => 'mt-number', 'tool' => 'modulo', 'fields' => ['a', 'm'], 'kind' => 'floor']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is −17 // 5?', 'answer' => '−4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Dividend" value="-17" type="text" inputmode="decimal" />
        <x-calc.field name="m" label="Divisor" value="5" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Floor quotient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '-17', 'm' => '5'],
        'Positive' => ['a' => '17', 'm' => '5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'quotient' => ['label' => 'Floor quotient'],
            'remainder' => ['label' => 'Remainder'],
            'truncated' => ['label' => 'Truncated quotient'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a // b = ⌊a ÷ b⌋</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
