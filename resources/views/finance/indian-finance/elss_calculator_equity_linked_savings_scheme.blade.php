<x-calc.page
    title="ELSS Calculator – Equity-Linked Savings Scheme - SolveKit"
    description="Free ELSS calculator: maturity value of an ELSS SIP or lump sum, the section 80C tax saving under the old regime and the 3-year lock-in."
    lede="Plan an ELSS investment and its tax saving."
    about="ELSS funds are equity mutual funds with a 3-year lock-in. Investments up to ₹1.5 lakh a year qualify for section 80C deduction in the old tax regime only. SIP value = P × [(1 + i)^n − 1] ÷ i × (1 + i), with P the monthly instalment, i the monthly rate (annual ÷ 12) and n the months; instalments are made at the start of each month, as fund houses assume. Mutual fund returns are not guaranteed; equity funds have returned roughly 10–14% a year over long periods, with large swings. Equity gains over ₹1.25 lakh a year are taxed at 12.5% (LTCG). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'elss', 'fields' => ['mode', 'amount', 'rate', 'years', 'slab'], 'data' => ['india' => config('finance_data.india')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Choose SIP or lump sum', 'text' => ''],
        ['name' => 'Enter amount, return and your slab', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹12,500 a month in ELSS for 10 years become at 12%?', 'answer' => '₹29,04,238; tax saving ₹46,800 a year under section 80C (old regime only, up to ₹1.5 lakh).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Invest as" :options="['sip' => 'Monthly SIP', 'lump' => 'Lump sum']" selected="sip" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="12500" step="1" suffix="₹" />
        <x-calc.field name="rate" label="Expected return" value="12" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
        <x-calc.field name="slab" label="Your tax slab (old regime)" value="30" step="any" suffix="%" />
    </div>

    <x-calc.result label="Expected value" />

    <x-calc.options :decimals="false" :examples="[
        'SIP' => ['mode' => 'sip', 'amount' => 12500, 'rate' => 12, 'years' => 10, 'slab' => 30],
        'Lump sum' => ['mode' => 'lump', 'amount' => 150000, 'rate' => 12, 'years' => 3, 'slab' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gains' => ['label' => 'Gains'],
            'tax' => ['label' => '80C saving'],
            'ltcg' => ['label' => 'Tax on gains'],
            'lockin' => ['label' => 'Lock-in'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = SIP or lump sum growth</li>
            <li>saving = min(invested, ₹1.5 lakh) × slab × 1.04</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
