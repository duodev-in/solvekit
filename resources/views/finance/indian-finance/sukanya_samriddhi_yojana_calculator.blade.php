<x-calc.page
    title="Sukanya Samriddhi Yojana Calculator - SolveKit"
    description="Free Sukanya Samriddhi Yojana calculator: maturity value of an SSY account at the notified 8.2% rate, with deposits for 15 years and maturity at 21 years."
    lede="Plan an SSY account for your daughter."
    about="An SSY account can be opened for a girl under 10. Deposits of ₹250 to ₹1.5 lakh a year are made for 15 years; the account keeps earning until it matures 21 years after opening. The rate (8.2% for October–December 2026) is reset quarterly, compounded yearly, and the scheme is tax-free. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'ssy', 'fields' => ['yearly', 'age', 'start', 'rate'], 'data' => ['smallsavings' => config('finance_data.smallsavings')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the yearly deposit', 'text' => ''],
        ['name' => 'Enter her age and the year', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does ₹1.5 lakh a year in SSY give?', 'answer' => '₹71,82,119.'],
        ['question' => 'And ₹50,000 a year?', 'answer' => '₹23,94,040.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="yearly" label="Yearly deposit" value="150000" step="1" suffix="₹" />
        <x-calc.field name="age" label="Girl's age at opening" value="2" min="0" max="10" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Year of opening" value="2026" min="2015" step="1" />
        <x-calc.field name="rate" label="Interest rate" value="8.2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Maturity value at 21 years" />

    <x-calc.options :decimals="false" :examples="[
        'Maximum' => ['yearly' => 150000, 'age' => 2, 'start' => 2026, 'rate' => 8.2],
        '₹50,000' => ['yearly' => 50000, 'age' => 5, 'start' => 2026, 'rate' => 8.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'invested' => ['label' => 'Deposited'],
            'interest' => ['label' => 'Interest'],
            'rate' => ['label' => 'Rate'],
            'withdrawal' => ['label' => 'Partial withdrawal'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deposits years 1–15, growth to year 21</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
