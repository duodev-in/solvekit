<x-calc.page
    title="Standard Form Calculator - SolveKit"
    description="Free standard form calculator: a number in standard form a × 10ⁿ (UK meaning) and written out (US meaning)."
    lede="Write a number in standard form."
    about="In the UK, standard form means a × 10ⁿ with 1 ≤ a < 10 (scientific notation): 43,000 = 4.3 × 10⁴. In the US, “standard form” of a number usually means writing it out in digits. Both are shown."
    :calc="['engine' => 'mt-number', 'tool' => 'standard_form', 'fields' => ['x']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 43,000 in standard form?', 'answer' => '4.3 × 10⁴.'],
    ]"
>
    <x-calc.field name="x" label="Number" value="43000" type="text" inputmode="decimal" />

    <x-calc.result label="Standard form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '43000'],
        'Small' => ['x' => '0.00072'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'uk' => ['label' => 'UK standard form'],
            'us' => ['label' => 'US standard form'],
            'words' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a × 10ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
