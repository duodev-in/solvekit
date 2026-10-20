<x-calc.page
    title="Digit Sum Calculator - SolveKit"
    description="Free digit sum calculator: the sum of the digits of a number, and its digital root."
    lede="Add up the digits."
    about="The digit sum adds every digit: 9,875 → 9 + 8 + 7 + 5 = 29. It powers the divisibility tests for 3 and 9."
    :calc="['engine' => 'mt-arith', 'tool' => 'digit_sum', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the digit sum of 9,875?', 'answer' => '29.'],
    ]"
>
    <x-calc.field name="n" label="Number" value="9875" type="text" inputmode="decimal" />

    <x-calc.result label="Digit sum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '9875'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Digit sum'],
            'root' => ['label' => 'Digital root'],
            'nine' => ['label' => 'Mod 9'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ digits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
