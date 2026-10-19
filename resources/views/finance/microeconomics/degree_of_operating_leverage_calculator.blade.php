<x-calc.page
    title="Degree of Operating Leverage Calculator - SolveKit"
    description="Free Degree of Operating Leverage Calculator: DOL = %Δ EBIT ÷ %Δ sales (= contribution margin ÷ EBIT). Operating leverage shows how strongly profit reacts to sales because of fixed costs."
    lede="Work out the degree of operating leverage from change in sales and change in EBIT."
    about="Operating leverage shows how strongly profit reacts to sales because of fixed costs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'degree_of_operating_leverage', 'fields' => ['sales_change', 'ebit_change']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Change in sales, Change in EBIT.'],
        ['name' => 'Read the result', 'text' => 'The degree of operating leverage appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the degree of operating leverage?', 'answer' => 'DOL = %Δ EBIT ÷ %Δ sales (= contribution margin ÷ EBIT).'],
        ['question' => 'What is the degree of operating leverage for change in sales 10%, change in EBIT 25%?', 'answer' => '2.5×.'],
        ['question' => 'And for change in sales -8%, change in EBIT -30%?', 'answer' => '3.75×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A DOL of 2.5 turns a 10% sales rise into a 25% EBIT rise.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sales_change" label="Change in sales" value="10" step="any" suffix="%" />
        <x-calc.field name="ebit_change" label="Change in EBIT" value="25" step="any" suffix="%" />
    </div>

    <x-calc.result label="Degree of operating leverage" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['sales_change' => 10, 'ebit_change' => 25],
        'Example B' => ['sales_change' => -8, 'ebit_change' => -30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DOL = %Δ EBIT ÷ %Δ sales (= contribution margin ÷ EBIT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
