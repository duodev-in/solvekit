<x-calc.page
    title="Factorial Calculator - SolveKit"
    description="Free factorial calculator: n! exactly for n up to 20,000, with the number of digits, trailing zeros and the double factorial."
    lede="Calculate n factorial."
    about="n! = n × (n − 1) × … × 1, with 0! = 1. It grows extremely fast: 20! has 19 digits and 100! has 158. Trailing zeros come from factors of 5: ⌊n/5⌋ + ⌊n/25⌋ + …."
    :calc="['engine' => 'mt-number', 'tool' => 'factorial', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 20!?', 'answer' => '2,432,902,008,176,640,000.'],
        ['question' => 'How many zeros end 100!?', 'answer' => '24.'],
    ]"
>
    <x-calc.field name="n" label="n" value="20" type="text" inputmode="decimal" />

    <x-calc.result label="n!" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '20'],
        'Hundred' => ['n' => '100'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'digits' => ['label' => 'Digits'],
            'zeros' => ['label' => 'Trailing zeros'],
            'double' => ['label' => 'Double factorial n!!'],
            'scientific' => ['label' => 'Scientific'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n! = Π k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
