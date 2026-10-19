<x-calc.page
    title="ROI Calculator - Return on Investment - SolveKit"
    description="Free ROI Calculator - Return on Investment: ROI = (return − cost) ÷ cost. Return on investment is net profit as a share of the cost."
    lede="Work out the ROI from amount invested, amount returned and years (optional)."
    about="Return on investment is net profit as a share of the cost. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'roi', 'fields' => ['cost', 'gain', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Amount invested, Amount returned, Years (optional).'],
        ['name' => 'Read the result', 'text' => 'The ROI appears as you type, with net profit, annualized ROI below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ROI?', 'answer' => 'ROI = (return − cost) ÷ cost.'],
        ['question' => 'What is the ROI for amount invested $20,000, amount returned $26,000, years 3?', 'answer' => '30%. Net profit: $6,000.00.'],
        ['question' => 'And for amount invested $5,000, amount returned $7,400, years 4?', 'answer' => '48%. Net profit: $2,400.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Annualized ROI makes investments of different lengths comparable.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Amount invested" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="gain" label="Amount returned" value="26000" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years (optional)" value="3" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="ROI" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 20000, 'gain' => 26000, 'years' => 3],
        'Example B' => ['cost' => 5000, 'gain' => 7400, 'years' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Net profit'],
            'r2' => ['label' => 'Annualized ROI'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROI = (return − cost) ÷ cost</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
