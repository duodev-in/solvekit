<x-calc.page
    title="Roth IRA calculator - SolveKit"
    description="Free Roth IRA calculator: tax-free balance at retirement with the 2026 contribution limit and the income phase-out for your filing status."
    lede="Project a Roth IRA and check how much you may contribute."
    about="Roth IRA contributions are not deductible, but qualified withdrawals after 59½ (and five years) are tax-free. For 2026 the limit is $7,500 ($8,600 at 50+), reduced for modified AGI between $153,000 and $168,000 (single) or $242,000 and $252,000 (joint), using the IRS worksheet: rounded up to $10, at least $200. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'roth', 'fields' => ['contribution', 'balance', 'magi', 'status', 'age', 'retire', 'rate', 'tax'], 'data' => ['limits' => config('finance_data.limits')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter income and status', 'text' => 'For the phase-out.'],
        ['name' => 'Enter contribution, ages and return', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much can a single filer with MAGI of $160,000 contribute in 2026?', 'answer' => '$4,000.00 at a MAGI of $160,000 (phase-out $153,000–$168,000).'],
        ['question' => 'What does $7,500 a year from 30 to 65 at 7% become?', 'answer' => '$1,109,350.95, tax-free.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="contribution" label="Yearly contribution" value="7500" step="0.01" suffix="$" />
        <x-calc.field name="balance" label="Current balance" value="10000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="magi" label="Modified AGI" value="160000" step="0.01" suffix="$" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Your age" value="30" min="0" step="1" />
        <x-calc.field name="retire" label="Retirement age" value="65" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Annual return" value="7" step="any" suffix="%" />
        <x-calc.field name="tax" label="Tax rate you avoid" value="22" step="any" suffix="%" />
    </div>

    <x-calc.result label="Balance at retirement" />

    <x-calc.options :decimals="false" :examples="[
        'Phase-out' => ['contribution' => 7500, 'balance' => 10000, 'magi' => 160000, 'status' => 'single', 'age' => 30, 'retire' => 65, 'rate' => 7, 'tax' => 22],
        'Full contribution' => ['contribution' => 7500, 'balance' => 0, 'magi' => 90000, 'status' => 'single', 'age' => 30, 'retire' => 65, 'rate' => 7, 'tax' => 22],
        'Married' => ['contribution' => 7500, 'balance' => 30000, 'magi' => 245000, 'status' => 'mfj', 'age' => 45, 'retire' => 65, 'rate' => 6, 'tax' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'allowed' => ['label' => 'You may contribute'],
            'contributed' => ['label' => 'Contributions'],
            'growth' => ['label' => 'Tax-free growth'],
            'after' => ['label' => 'After tax'],
            'saved' => ['label' => 'Tax saved'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>allowed = limit × (high − MAGI) ÷ (high − low), rounded up to $10</li>
            <li>B = Σ C(1 + r)^(n − t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
