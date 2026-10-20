<x-calc.page
    title="Place Value Calculator - SolveKit"
    description="Free place value calculator: the place (ones, tens, tenths …) and value of every digit in a number."
    lede="Find the place value of each digit."
    about="Each position is worth ten times the one to its right: in 4,305.27 the 3 is in the hundreds place (300) and the 7 in the hundredths place (0.07)."
    :calc="['engine' => 'mt-arith', 'tool' => 'place_value', 'fields' => ['x', 'digit']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What place is the 3 in 4,305.27?', 'answer' => 'hundreds.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number" value="4305.27" type="text" inputmode="decimal" />
        <x-calc.field name="digit" label="Digit to find (optional)" value="3" min="0" max="9" step="1" />
    </div>

    <x-calc.result label="Place" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '4305.27', 'digit' => 3],
        'Large' => ['x' => '7012345678', 'digit' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'factors' => ['label' => 'Every digit'],
            'powers' => ['label' => 'Powers of ten'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>digit × 10^place</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
