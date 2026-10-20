<x-calc.page
    title="Significant Figures Calculator – Sig Fig - SolveKit"
    description="Free significant figures calculator: count the sig figs in a number and round it to any number of significant figures."
    lede="Count and round significant figures."
    about="Significant figures are the digits that carry meaning: non-zero digits, zeros between them, and trailing zeros after a decimal point. Leading zeros (0.0045) do not count. 1,200 is ambiguous (2, 3 or 4 sig figs); write 1.20 × 10³ to show 3."
    :calc="['engine' => 'mt-number', 'tool' => 'sig_figs', 'fields' => ['x', 'round']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'How many significant figures are in 0.004560?', 'answer' => '4 significant figures.'],
        ['question' => 'And 1200?', 'answer' => '2 to 4 significant figures.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number" value="0.004560" type="text" inputmode="text" />
        <x-calc.field name="round" label="Round to (optional)" value="2" min="0" max="40" step="1" />
    </div>

    <x-calc.result label="Significant figures" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '0.004560', 'round' => 2],
        'Ambiguous' => ['x' => '1200', 'round' => 2],
        'Scientific' => ['x' => '6.020e23', 'round' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'scientific' => ['label' => 'Scientific notation'],
            'rounded' => ['label' => 'Rounded'],
            'decimals' => ['label' => 'Decimal places'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Count from the first non-zero digit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
