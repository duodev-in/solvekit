<x-calc.page
    title="Attrition Rate Calculator - SolveKit"
    description="Free Attrition Rate Calculator: attrition = leavers ÷ average headcount. Attrition is the share of the average workforce that left during the period."
    lede="Work out the attrition rate from your figures."
    about="Attrition is the share of the average workforce that left during the period. Annualizing a shorter period lets you compare quarters with years. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'attrition_rate', 'fields' => ['leavers', 'start', 'end', 'months']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Employees who left, Headcount at start, Headcount at end, Period.'],
        ['name' => 'Read the result', 'text' => 'The attrition rate appears as you type, with annualized, average headcount below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the attrition rate?', 'answer' => 'Attrition = leavers ÷ average headcount; annualized × 12 ÷ months.'],
        ['question' => 'What is the attrition rate for employees who left 18, headcount at start 150, headcount at end 158, period 12 months?', 'answer' => '11.69%. Annualized: 11.69%.'],
        ['question' => 'And for employees who left 6, headcount at start 80, headcount at end 76, period 3 months?', 'answer' => '7.692%. Annualized: 30.77%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Many organizations see 10–20% a year; very high rates in one team point to a local problem.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="leavers" label="Employees who left" value="18" min="0" step="1" />
        <x-calc.field name="start" label="Headcount at start" value="150" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="end" label="Headcount at end" value="158" min="0" step="1" />
        <x-calc.field name="months" label="Period" value="12" min="0" step="any" suffix="months" />
    </div>

    <x-calc.result label="Attrition rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['leavers' => 18, 'start' => 150, 'end' => 158, 'months' => 12],
        'Example B' => ['leavers' => 6, 'start' => 80, 'end' => 76, 'months' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Annualized'],
            'r2' => ['label' => 'Average headcount'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>attrition = leavers ÷ average headcount</li>
            <li>annualized × 12 ÷ months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
