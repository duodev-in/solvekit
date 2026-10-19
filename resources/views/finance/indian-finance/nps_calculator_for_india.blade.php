<x-calc.page
    title="NPS Calculator for India - SolveKit"
    description="Free NPS calculator: National Pension System corpus at 60, the lump sum you can take (up to 80% for non-government subscribers) and the monthly pension from the annuity."
    lede="Project your NPS corpus and pension."
    about="Monthly contributions grow at your expected return until 60. Since December 2025 non-government subscribers can take up to 80% as a lump sum (all of it if the corpus is ₹8 lakh or less) and must buy an annuity with the rest; government employees keep the 60/40 split. Up to 60% of the lump sum is tax-free. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'nps', 'fields' => ['monthly', 'age', 'balance', 'rate', 'stepup', 'lump', 'annuity_rate', 'sector'], 'data' => ['nps' => config('finance_data.nps')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter contribution and age', 'text' => ''],
        ['name' => 'Enter returns and the exit split', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹10,000 a month from 30 give at 60?', 'answer' => '₹3,59,30,210; pension ₹38,924 a month at 6.5%.'],
        ['question' => 'And for a government employee?', 'answer' => 'Lump sum ₹2,15,58,126 (60%) tax-free up to 60%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="monthly" label="Monthly contribution" value="10000" step="1" suffix="₹" />
        <x-calc.field name="age" label="Your age" value="30" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Current balance" value="0" step="1" suffix="₹" />
        <x-calc.field name="rate" label="Expected return" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stepup" label="Yearly increase" value="5" step="any" suffix="%" />
        <x-calc.field name="lump" label="Lump sum share" value="80" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="annuity_rate" label="Annuity rate" value="6.5" step="any" suffix="%" />
        <x-calc.select name="sector" label="Subscriber" :options="['private' => 'All citizen or corporate', 'govt' => 'Government']" selected="private" />
    </div>

    <x-calc.result label="Corpus at 60" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['monthly' => 10000, 'age' => 30, 'balance' => 0, 'rate' => 10, 'stepup' => 5, 'lump' => 80, 'annuity_rate' => 6.5, 'sector' => 'private'],
        'Government' => ['monthly' => 10000, 'age' => 30, 'balance' => 0, 'rate' => 10, 'stepup' => 5, 'lump' => 60, 'annuity_rate' => 6.5, 'sector' => 'govt'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Corpus over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'lump' => ['label' => 'Lump sum'],
            'annuity' => ['label' => 'Used for the annuity'],
            'pension' => ['label' => 'Monthly pension'],
            'rules' => ['label' => 'Exit rules'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>corpus = SIP growth to 60</li>
            <li>pension = annuity × rate ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
