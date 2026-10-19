<x-calc.page
    title="Interest Coverage Ratio Calculator - SolveKit"
    description="Free Interest Coverage Ratio Calculator: coverage = EBIT ÷ interest expense. Interest coverage shows how many times operating profit covers interest."
    lede="Work out the interest coverage from EBIT and interest expense."
    about="Interest coverage shows how many times operating profit covers interest. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'interest_coverage_ratio', 'fields' => ['ebit', 'interest']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBIT, Interest expense.'],
        ['name' => 'Read the result', 'text' => 'The interest coverage appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the interest coverage?', 'answer' => 'Coverage = EBIT ÷ interest expense.'],
        ['question' => 'What is the interest coverage for EBIT $600,000, interest expense $150,000?', 'answer' => '4×.'],
        ['question' => 'And for EBIT $90,000, interest expense $70,000?', 'answer' => '1.286×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Below about 1.5 is a warning sign.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebit" label="EBIT" value="600000" step="0.01" suffix="$" />
        <x-calc.field name="interest" label="Interest expense" value="150000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Interest coverage" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 600000, 'interest' => 150000],
        'Example B' => ['ebit' => 90000, 'interest' => 70000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coverage = EBIT ÷ interest expense</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
