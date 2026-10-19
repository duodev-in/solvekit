<x-calc.page
    title="Times Interest Earned Ratio Calculator - SolveKit"
    description="Free Times Interest Earned Ratio Calculator: TIE = EBIT ÷ interest. Times interest earned is another name for interest coverage."
    lede="Work out the times interest earned from earnings before interest and taxes and interest expense."
    about="Times interest earned is another name for interest coverage. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'times_interest_earned_ratio', 'fields' => ['ebit', 'interest']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Earnings before interest and taxes, Interest expense.'],
        ['name' => 'Read the result', 'text' => 'The times interest earned appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the times interest earned?', 'answer' => 'TIE = EBIT ÷ interest.'],
        ['question' => 'What is the times interest earned for earnings before interest and taxes $800,000, interest expense $200,000?', 'answer' => '4×.'],
        ['question' => 'And for earnings before interest and taxes $120,000, interest expense $60,000?', 'answer' => '2×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Higher means more room to pay interest.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebit" label="Earnings before interest and taxes" value="800000" step="0.01" suffix="$" />
        <x-calc.field name="interest" label="Interest expense" value="200000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Times interest earned" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 800000, 'interest' => 200000],
        'Example B' => ['ebit' => 120000, 'interest' => 60000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TIE = EBIT ÷ interest</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
