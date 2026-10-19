<x-calc.page
    title="Turnover Rate Calculator - SolveKit"
    description="Free Turnover Rate Calculator: turnover = separations ÷ average employees. Employee turnover rate is the share of the workforce that left in the period (voluntary and involuntary)."
    lede="Work out the turnover rate from separations and average number of employees."
    about="Employee turnover rate is the share of the workforce that left in the period (voluntary and involuntary). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'turnover_rate', 'fields' => ['separations', 'average']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Separations, Average number of employees.'],
        ['name' => 'Read the result', 'text' => 'The turnover rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the turnover rate?', 'answer' => 'Turnover = separations ÷ average employees.'],
        ['question' => 'What is the turnover rate for separations 24, average number of employees 200?', 'answer' => '12%.'],
        ['question' => 'And for separations 9, average number of employees 60?', 'answer' => '15%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'US annual turnover is often around 40–50% across all industries (BLS JOLTS separations), higher in retail and hospitality.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="separations" label="Separations" value="24" min="0" step="1" />
        <x-calc.field name="average" label="Average number of employees" value="200" step="any" />
    </div>

    <x-calc.result label="Turnover rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['separations' => 24, 'average' => 200],
        'Example B' => ['separations' => 9, 'average' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turnover = separations ÷ average employees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
