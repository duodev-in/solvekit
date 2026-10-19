<x-calc.page
    title="MIRR Calculator - Modified Internal Rate of Return - SolveKit"
    description="Free MIRR calculator: modified internal rate of return with separate finance and reinvestment rates, compared with the IRR."
    lede="Find the modified IRR of cash flows."
    about="MIRR = (FV of positive flows at the reinvestment rate ÷ PV of negative flows at the finance rate)^(1/n) − 1. Unlike the IRR it has one answer and does not assume cash is reinvested at the IRR itself. It matches spreadsheet MIRR(). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'mirr', 'fields' => ['finance', 'reinvest', 'flows']]"
    :how-to="[
        ['name' => 'Enter both rates', 'text' => 'Borrowing and reinvestment.'],
        ['name' => 'List the cash flows', 'text' => 'Investment first.'],
    ]"
    :faqs="[
        ['question' => 'What is the MIRR of −120,000, 39,000, 30,000, 21,000, 37,000, 46,000 at 10% and 12%?', 'answer' => '12.61% (IRR 13.07%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="finance" label="Finance rate" value="10" step="any" suffix="%" />
        <x-calc.field name="reinvest" label="Reinvestment rate" value="12" step="any" suffix="%" />
    </div>

    <x-calc.textarea name="flows" label="Cash flows, year 0 first (one per line)" value="-120000
39000
30000
21000
37000
46000" rows="6" />

    <x-calc.result label="Modified internal rate of return" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['finance' => 10, 'reinvest' => 12, 'flows' => '-120000
39000
30000
21000
37000
46000'],
        'Equal rates' => ['finance' => 8, 'reinvest' => 8, 'flows' => '-1000
300
400
500'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pv' => ['label' => 'PV of outflows'],
            'fv' => ['label' => 'FV of inflows'],
            'irr' => ['label' => 'IRR'],
            'periods' => ['label' => 'Periods'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MIRR = (FV₊ ÷ −PV₋)^(1/n) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
