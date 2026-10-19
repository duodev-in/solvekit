<x-calc.page
    title="Atal Pension Yojana Calculator - SolveKit"
    description="Free Atal Pension Yojana calculator: monthly contribution for a guaranteed pension of ₹1,000 to ₹5,000 from the PFRDA chart, by joining age."
    lede="Find your APY contribution."
    about="APY guarantees a pension of ₹1,000–₹5,000 a month from 60. The monthly contribution depends only on your joining age (18–40) and the pension chosen, from the PFRDA chart. The nominee receives a fixed corpus (₹1.7 lakh to ₹8.5 lakh). Income-tax payers cannot join since October 2022. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'apy', 'fields' => ['age', 'pension'], 'data' => ['apy' => config('finance_data.apy')], 'sym' => 'INR', 'currency' => 'INR', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your age', 'text' => ''],
        ['name' => 'Choose the pension', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a 25-year-old pay for a ₹5,000 pension?', 'answer' => '₹376 a month.'],
        ['question' => 'And at 40?', 'answer' => '₹1,454.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Joining age" value="25" min="18" max="40" step="1" />
        <x-calc.select name="pension" label="Monthly pension" :options="['1000' => '₹1,000', '2000' => '₹2,000', '3000' => '₹3,000', '4000' => '₹4,000', '5000' => '₹5,000']" selected="5000" />
    </div>

    <x-calc.result label="Monthly contribution" />

    <x-calc.options :decimals="false" :examples="[
        'Age 25' => ['age' => 25, 'pension' => '5000'],
        'Age 40' => ['age' => 40, 'pension' => '5000'],
        'Age 18, ₹1,000' => ['age' => 18, 'pension' => '1000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total contribution'],
            'months' => ['label' => 'Months'],
            'corpus' => ['label' => 'Nominee corpus'],
            'quarterly' => ['label' => 'Quarterly option'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>contribution = PFRDA chart[age][pension]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
