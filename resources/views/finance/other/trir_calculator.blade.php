<x-calc.page
    title="TRIR Calculator - SolveKit"
    description="Free TRIR Calculator: TRIR = recordable cases × 200,000 ÷ hours worked. The total recordable incident rate is OSHA recordable injuries and illnesses per 100 full-time workers."
    lede="Work out the total recordable incident rate from OSHA recordable cases and total hours worked."
    about="The total recordable incident rate is OSHA recordable injuries and illnesses per 100 full-time workers. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'trir', 'fields' => ['cases', 'hours']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'OSHA recordable cases, Total hours worked.'],
        ['name' => 'Read the result', 'text' => 'The total recordable incident rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the total recordable incident rate?', 'answer' => 'TRIR = recordable cases × 200,000 ÷ hours worked.'],
        ['question' => 'What is the total recordable incident rate for OSHA recordable cases 6, total hours worked 400,000?', 'answer' => '3.'],
        ['question' => 'And for OSHA recordable cases 3, total hours worked 95,000?', 'answer' => '6.316.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Private industry averaged about 2.4 (BLS, 2023).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cases" label="OSHA recordable cases" value="6" min="0" step="1" />
        <x-calc.field name="hours" label="Total hours worked" value="400000" step="any" />
    </div>

    <x-calc.result label="Total recordable incident rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cases' => 6, 'hours' => 400000],
        'Example B' => ['cases' => 3, 'hours' => 95000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TRIR = recordable cases × 200,000 ÷ hours worked</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
