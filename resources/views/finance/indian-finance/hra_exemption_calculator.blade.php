<x-calc.page
    title="HRA Exemption Calculator - SolveKit"
    description="Free HRA exemption calculator: house rent allowance exempt under section 10(13A), the least of HRA received, rent minus 10% of basic, and 50% or 40% of basic."
    lede="Work out your tax-free HRA."
    about="The exempt HRA is the least of: actual HRA received; rent paid − 10% of basic + DA; and 50% of basic + DA in Delhi, Mumbai, Kolkata or Chennai (40% elsewhere). The rest is taxable. HRA exemption is available only in the old tax regime. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'hra', 'fields' => ['period', 'basic', 'hra', 'rent', 'metro'], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter salary, HRA and rent', 'text' => ''],
        ['name' => 'Choose metro or not', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much HRA is exempt with ₹50,000 basic, ₹20,000 HRA and ₹18,000 rent in Mumbai?', 'answer' => '₹1,56,000 a year.'],
        ['question' => 'And in Pune?', 'answer' => '₹1,56,000.'],
    ]"
>
    <x-calc.select name="period" label="Amounts are" :options="['month' => 'Monthly', 'year' => 'Yearly']" selected="month" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="basic" label="Basic + DA" value="50000" step="1" suffix="₹" />
        <x-calc.field name="hra" label="HRA received" value="20000" step="1" suffix="₹" />
        <x-calc.field name="rent" label="Rent paid" value="18000" step="1" suffix="₹" />
    </div>

    <x-calc.checkbox name="metro" label="Live in Delhi, Mumbai, Kolkata or Chennai" :checked="true" />

    <x-calc.result label="HRA exemption a year" />

    <x-calc.options :decimals="false" :examples="[
        'Metro' => ['period' => 'month', 'basic' => 50000, 'hra' => 20000, 'rent' => 18000, 'metro' => true],
        'Non-metro' => ['period' => 'month', 'basic' => 50000, 'hra' => 20000, 'rent' => 18000, 'metro' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'received' => ['label' => 'HRA received'],
            'rent' => ['label' => 'Rent − 10% of basic'],
            'share' => ['label' => 'Share of basic'],
            'taxable' => ['label' => 'Taxable HRA'],
            'regime' => ['label' => 'Regime'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>exempt = min(HRA, rent − 10% basic, 50%/40% basic)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
