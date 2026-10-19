<x-calc.page
    title="Combined Ratio Calculator - SolveKit"
    description="Free Combined Ratio Calculator: combined ratio = loss ratio + expense ratio. An insurer's combined ratio shows underwriting profitability."
    lede="Work out the combined ratio from incurred losses (incl. adjustment expenses), underwriting expenses and earned premiums."
    about="An insurer's combined ratio shows underwriting profitability. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'combined_ratio', 'fields' => ['losses', 'expenses', 'premiums']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Incurred losses (incl. adjustment expenses), Underwriting expenses, Earned premiums.'],
        ['name' => 'Read the result', 'text' => 'The combined ratio appears as you type, with loss ratio, expense ratio below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the combined ratio?', 'answer' => 'Combined ratio = loss ratio + expense ratio.'],
        ['question' => 'What is the combined ratio for incurred losses $650,000, underwriting expenses $280,000, earned premiums $1,000,000?', 'answer' => '93%. Loss ratio: 65%.'],
        ['question' => 'And for incurred losses $820,000, underwriting expenses $260,000, earned premiums $1,000,000?', 'answer' => '108%. Loss ratio: 82%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Below 100% is an underwriting profit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="losses" label="Incurred losses (incl. adjustment expenses)" value="650000" step="0.01" suffix="$" />
        <x-calc.field name="expenses" label="Underwriting expenses" value="280000" step="0.01" suffix="$" />
        <x-calc.field name="premiums" label="Earned premiums" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Combined ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['losses' => 650000, 'expenses' => 280000, 'premiums' => 1000000],
        'Example B' => ['losses' => 820000, 'expenses' => 260000, 'premiums' => 1000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Loss ratio'],
            'r2' => ['label' => 'Expense ratio'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>combined ratio = loss ratio + expense ratio</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
