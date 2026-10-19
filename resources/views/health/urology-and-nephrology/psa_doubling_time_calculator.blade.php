<x-calc.page
    title="PSA Doubling Time Calculator - SolveKit"
    description="Free PSA doubling time calculator: how fast PSA is rising from two or more dated results, by log-linear regression, with PSA velocity."
    lede="Calculate PSA doubling time."
    about="PSA doubling time is the time for PSA to double, worked out from the slope of the natural log of PSA against time (the method used by MSKCC): PSADT = ln 2 ÷ slope. It is used mainly after prostate cancer treatment; short doubling times (under 3–12 months) carry higher risk. Use results from the same lab where possible. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'psa_dt', 'fields' => ['values']]"
    :how-to="[
        ['name' => 'Enter each PSA with its date', 'text' => 'At least two.'],
    ]"
    :faqs="[
        ['question' => 'What is the doubling time for 1.2, 1.6 and 2.3 over a year?', 'answer' => '12.9 months.'],
    ]"
>
    <x-calc.rows-editor name="values" label="PSA results (date YYYY-MM-DD, ng/mL)" :columns="['date' => 'Date', 'psa' => 'PSA']" :rows="[['2025-01-15', '1.2'], ['2025-07-10', '1.6'], ['2026-01-20', '2.3']]" add-label="Add result" />

    <x-calc.result label="PSA doubling time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['values' => '2025-01-15 1.2
2025-07-10 1.6
2026-01-20 2.3'],
        'Fast' => ['values' => '2026-01-01 0.5
2026-04-01 0.9
2026-07-01 1.7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'velocity' => ['label' => 'PSA velocity'],
            'method' => ['label' => 'Method'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PSADT = ln 2 ÷ slope of ln PSA</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
