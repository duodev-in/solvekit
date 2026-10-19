<x-calc.page
    title="Stamp Duty Land Tax Calculator UK - SolveKit"
    description="Free stamp duty calculator for England and Northern Ireland: SDLT bands from April 2025, first-time buyer relief, the 5% additional property surcharge and the 2% non-resident surcharge."
    lede="Work out stamp duty on a home purchase."
    about="Residential SDLT (England and NI) from April 1, 2025: 0% up to £125,000, 2% to £250,000, 5% to £925,000, 10% to £1.5 million and 12% above. First-time buyers pay 0% up to £300,000 and 5% to £500,000 if the price is £500,000 or less. Additional homes pay 5% more on the whole price; non-residents 2% more. Scotland (LBTT) and Wales (LTT) have their own taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'sdlt', 'fields' => ['price', 'buyer', 'non_resident'], 'data' => ['uk' => config('finance_data.uk')], 'sym' => 'GBP', 'currency' => 'GBP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the price', 'text' => ''],
        ['name' => 'Choose the buyer type', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is SDLT on a £350,000 home?', 'answer' => '£7,500.00.'],
        ['question' => 'For a first-time buyer?', 'answer' => '£2,500.00.'],
        ['question' => 'For a buy-to-let?', 'answer' => '£25,000.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Purchase price" value="350000" step="0.01" suffix="£" />
        <x-calc.select name="buyer" label="Buyer" :options="['standard' => 'Moving home', 'first' => 'First-time buyer', 'additional' => 'Additional property']" selected="standard" />
    </div>

    <x-calc.checkbox name="non_resident" label="Non-UK resident buyer" :checked="false" />

    <x-calc.result label="Stamp Duty Land Tax" />

    <x-calc.options :decimals="false" :examples="[
        'Moving home' => ['price' => 350000, 'buyer' => 'standard', 'non_resident' => false],
        'First-time buyer' => ['price' => 350000, 'buyer' => 'first', 'non_resident' => false],
        'Additional' => ['price' => 350000, 'buyer' => 'additional', 'non_resident' => false],
        '£1.2 million' => ['price' => 1200000, 'buyer' => 'standard', 'non_resident' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'base' => ['label' => 'Standard SDLT'],
            'relief' => ['label' => 'First-time buyer relief'],
            'surcharge' => ['label' => 'Surcharges'],
            'effective' => ['label' => 'Effective rate'],
        ]" />
        <x-calc.quick-ref heading="By band" name="slices" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SDLT = Σ band rate × slice of the price</li>
            <li>+ 5% surcharge on additional homes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
