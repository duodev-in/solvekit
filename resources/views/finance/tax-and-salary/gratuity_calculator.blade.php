<x-calc.page
    title="Gratuity Calculator - SolveKit"
    description="Free gratuity calculator for India: 15 ÷ 26 × last drawn basic + DA × years of service, the ₹20 lakh tax-free limit and eligibility."
    lede="Work out your gratuity."
    about="Under the Payment of Gratuity Act (now the Code on Social Security, in force from November 21, 2025): gratuity = last drawn basic + DA × 15 ÷ 26 × years of service, with a final part-year over 6 months counted as a full year. Employers not covered use 15 ÷ 30 and completed years. It is normally paid after 5 years (1 year for fixed-term employees). Up to ₹20 lakh is tax-free for private-sector employees (₹25 lakh for central government). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'gratuity', 'fields' => ['salary', 'years', 'months', 'covered', 'employer', 'fixed_term'], 'data' => ['gratuity' => config('finance_data.gratuity')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your last salary', 'text' => 'Basic + DA.'],
        ['name' => 'Enter years of service', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the gratuity on ₹60,000 after 8 years 7 months?', 'answer' => '₹3,11,538 (9 years counted).'],
        ['question' => 'And for an employer not covered by the Act?', 'answer' => '₹2,40,000.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salary" label="Last drawn basic + DA (monthly)" value="60000" step="1" suffix="₹" />
        <x-calc.field name="years" label="Years of service" value="8" min="0" step="1" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="months" label="Plus months" value="7" min="0" step="1" suffix="months" />
        <x-calc.select name="covered" label="Employer covered by the Act" :options="['yes' => 'Yes', 'no' => 'No']" selected="yes" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="employer" label="Employer" :options="['private' => 'Private sector', 'central' => 'Central government']" selected="private" />
    </div>

    <x-calc.checkbox name="fixed_term" label="Fixed-term employee" :checked="false" />

    <x-calc.result label="Gratuity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['salary' => 60000, 'years' => 8, 'months' => 7, 'covered' => 'yes', 'employer' => 'private', 'fixed_term' => false],
        'Not covered' => ['salary' => 60000, 'years' => 8, 'months' => 7, 'covered' => 'no', 'employer' => 'private', 'fixed_term' => false],
        'Long service' => ['salary' => 200000, 'years' => 25, 'months' => 0, 'covered' => 'yes', 'employer' => 'private', 'fixed_term' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'years' => ['label' => 'Years counted'],
            'eligible' => ['label' => 'Eligibility'],
            'taxfree' => ['label' => 'Tax-free limit'],
            'taxable' => ['label' => 'Taxable part'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gratuity = salary × 15 ÷ 26 × years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
