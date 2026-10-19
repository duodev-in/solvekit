<x-calc.page
    title="SIP Calculator + Lumpsum - SolveKit"
    description="Free SIP and lump sum calculator: combined future value of a one-time investment plus monthly SIPs in rupees."
    lede="Combine a lump sum with a monthly SIP."
    about="The lump sum grows at the monthly-compounded rate for the whole period, and each SIP instalment from the month it is made. SIP value = P × [(1 + i)^n − 1] ÷ i × (1 + i), with P the monthly instalment, i the monthly rate (annual ÷ 12) and n the months; instalments are made at the start of each month, as fund houses assume. Mutual fund returns are not guaranteed; equity funds have returned roughly 10–14% a year over long periods, with large swings. Equity gains over ₹1.25 lakh a year are taxed at 12.5% (LTCG). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'sip', 'fields' => ['lump', 'monthly', 'rate', 'years', 'stepup'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the lump sum and SIP', 'text' => ''],
        ['name' => 'Enter return and years', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do ₹2 lakh plus ₹10,000 a month for 15 years at 12% become?', 'answer' => '₹62,44,920.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lump" label="Lump sum" value="200000" step="1" suffix="$" />
        <x-calc.field name="monthly" label="Monthly SIP" value="10000" step="1" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Expected return a year" value="12" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="15" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stepup" label="Yearly step-up" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Expected value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lump' => 200000, 'monthly' => 10000, 'rate' => 12, 'years' => 15, 'stepup' => 0],
        'Lump sum only' => ['lump' => 500000, 'monthly' => 0, 'rate' => 12, 'years' => 15, 'stepup' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Value over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'invested' => ['label' => 'Amount invested'],
            'gains' => ['label' => 'Estimated gains'],
            'multiple' => ['label' => 'Multiple'],
            'xirr' => ['label' => 'Expected return'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV = L(1 + i)^n + SIP value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
