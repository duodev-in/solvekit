<x-calc.page
    title="Rent or Buy Calculator - SolveKit"
    description="Free rent or buy calculator: compare net wealth from buying a home with renting and investing the difference, year by year."
    lede="Should you rent or buy?"
    about="Owning costs the mortgage, property tax, maintenance and insurance; renting costs rent. Whoever pays less each year invests the difference at your investment return; the renter also invests the down payment and buying costs. Wealth compares home equity after selling costs with the renter's portfolio. Taxes on gains are ignored. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'rent_or_buy', 'fields' => ['price', 'down', 'rate', 'tax', 'maintenance', 'insurance', 'buy_costs', 'sell_costs', 'appreciation', 'rent', 'renters_insurance', 'rent_growth', 'invest', 'years']]"
    :how-to="[
        ['name' => 'Enter the home and mortgage', 'text' => ''],
        ['name' => 'Enter rent and growth rates', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Over 10 years, is it better to buy a $450,000 home or rent at $2,400?', 'answer' => 'Renting comes out ahead: by $14,795 in net wealth.'],
        ['question' => 'What if you stay only 3 years?', 'answer' => 'Renting comes out ahead.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Home price" value="450000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="20" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Mortgage rate" value="6.5" step="any" suffix="%" />
        <x-calc.field name="tax" label="Property tax" value="1.1" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="maintenance" label="Maintenance (% a year)" value="1" step="any" suffix="%" />
        <x-calc.field name="insurance" label="Home insurance a year" value="1800" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="buy_costs" label="Buying costs" value="3" step="any" suffix="%" />
        <x-calc.field name="sell_costs" label="Selling costs" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="appreciation" label="Home price growth" value="3" step="any" suffix="%" />
        <x-calc.field name="rent" label="Monthly rent" value="2400" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="renters_insurance" label="Renter's insurance a year" value="200" step="0.01" suffix="$" />
        <x-calc.field name="rent_growth" label="Rent growth" value="3" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="invest" label="Investment return" value="6" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="1" suffix="years" />
    </div>

    <x-calc.result label="Comes out ahead" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 450000, 'down' => 20, 'rate' => 6.5, 'tax' => 1.1, 'maintenance' => 1, 'insurance' => 1800, 'buy_costs' => 3, 'sell_costs' => 6, 'appreciation' => 3, 'rent' => 2400, 'renters_insurance' => 200, 'rent_growth' => 3, 'invest' => 6, 'years' => 10],
        'Short stay' => ['price' => 450000, 'down' => 20, 'rate' => 6.5, 'tax' => 1.1, 'maintenance' => 1, 'insurance' => 1800, 'buy_costs' => 3, 'sell_costs' => 6, 'appreciation' => 3, 'rent' => 2400, 'renters_insurance' => 200, 'rent_growth' => 3, 'invest' => 6, 'years' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Net wealth over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'owner' => ['label' => 'Buyer\'s net wealth'],
            'renter' => ['label' => 'Renter\'s net wealth'],
            'crossover' => ['label' => 'Break-even year'],
            'payment' => ['label' => 'Mortgage payment'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>owner wealth = value × (1 − selling) − balance</li>
            <li>renter wealth = invested savings</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
