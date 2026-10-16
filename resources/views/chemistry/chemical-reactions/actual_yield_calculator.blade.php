<x-calc.page
    title="Actual Yield Calculator - SolveKit"
    description="Free actual yield calculator: actual yield from the theoretical yield and percent yield."
    lede="Work out the actual yield from the percent yield."
    about="Actual yield = theoretical yield × percent yield ÷ 100. It tells you how much product to expect at a known efficiency."
    :calc="['engine' => 'chem-reactions', 'tool' => 'actual_yield', 'fields' => ['theoretical', 'percent', 'unit_label']]"
    :how-to="[
        ['name' => 'Enter the theoretical yield', 'text' => 'From the equation.'],
        ['name' => 'Enter the percent yield', 'text' => 'From experience or the literature.'],
    ]"
    :faqs="[
        ['question' => 'How do I find actual yield?', 'answer' => 'Theoretical yield × percent yield ÷ 100.'],
        ['question' => 'Is actual yield measured or calculated?', 'answer' => 'Usually measured; here it is predicted from a percent yield.'],
        ['question' => 'What reduces yield?', 'answer' => 'Side reactions, equilibrium limits and losses during work-up.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="theoretical" label="Theoretical yield" value="50" min="0" />
        <x-calc.field name="percent" label="Percent yield" value="80" min="0" suffix="%" />
    </div>

    <x-calc.field name="unit_label" label="Unit (optional)" value="g" type="text" />

    <x-calc.result label="Actual yield" />

    <x-calc.options :examples="[
        '80% of 50 g' => ['theoretical' => 50, 'percent' => 80, 'unit_label' => 'g'],
        '65% of 2.4 kg' => ['theoretical' => 2.4, 'percent' => 65, 'unit_label' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lost' => ['label' => 'Shortfall'],
            'fraction' => ['label' => 'As a fraction'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>actual = theoretical × % ÷ 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
