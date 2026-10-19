<x-calc.page
    title="Rental Property Calculator - SolveKit"
    description="Free rental property calculator: monthly cash flow, NOI, cap rate, cash-on-cash return and IRR over a holding period including the sale."
    lede="Analyze a rental property investment."
    about="NOI = rent less vacancy − operating expenses (tax, insurance, management, maintenance, HOA). Cash flow = NOI − mortgage payments. Cap rate = NOI ÷ price; cash-on-cash = cash flow ÷ cash invested. The IRR adds rising rents and the sale at the end, after selling costs and the loan payoff. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'rental', 'fields' => ['price', 'down', 'closing', 'rate', 'years', 'rent', 'vacancy', 'tax', 'insurance', 'management', 'maintenance', 'hoa', 'appreciation', 'rent_growth', 'hold', 'selling']]"
    :how-to="[
        ['name' => 'Enter the purchase and loan', 'text' => ''],
        ['name' => 'Enter rent and expenses', 'text' => 'Then appreciation and holding period.'],
    ]"
    :faqs="[
        ['question' => 'What does a $300,000 rental at $2,400 a month return with 25% down at 7%?', 'answer' => 'Cash flow −$83.93 a month; cap rate 5.652%; IRR 9.184% over 10 years including the sale.'],
        ['question' => 'And with all cash?', 'answer' => 'Cash-on-cash 5.487%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Purchase price" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="down" label="Down payment" value="25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="closing" label="Closing and repair costs" value="9000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Mortgage rate" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Mortgage term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="rent" label="Monthly rent" value="2400" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="vacancy" label="Vacancy" value="5" step="any" suffix="%" />
        <x-calc.field name="tax" label="Property tax (% a year)" value="1.2" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="insurance" label="Insurance a year" value="1500" step="0.01" suffix="$" />
        <x-calc.field name="management" label="Management (% of rent)" value="8" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="maintenance" label="Maintenance (% of value a year)" value="1" step="any" suffix="%" />
        <x-calc.field name="hoa" label="HOA a month" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="appreciation" label="Appreciation a year" value="3" step="any" suffix="%" />
        <x-calc.field name="rent_growth" label="Rent and cost growth a year" value="3" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hold" label="Years held" value="10" min="0" step="1" suffix="years" />
        <x-calc.field name="selling" label="Selling costs" value="6" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly cash flow" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['price' => 300000, 'down' => 25, 'closing' => 9000, 'rate' => 7, 'years' => 30, 'rent' => 2400, 'vacancy' => 5, 'tax' => 1.2, 'insurance' => 1500, 'management' => 8, 'maintenance' => 1, 'hoa' => 0, 'appreciation' => 3, 'rent_growth' => 3, 'hold' => 10, 'selling' => 6],
        'All cash' => ['price' => 300000, 'down' => 100, 'closing' => 9000, 'rate' => 7, 'years' => 30, 'rent' => 2400, 'vacancy' => 5, 'tax' => 1.2, 'insurance' => 1500, 'management' => 8, 'maintenance' => 1, 'hoa' => 0, 'appreciation' => 3, 'rent_growth' => 3, 'hold' => 10, 'selling' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'noi' => ['label' => 'Net operating income'],
            'cap' => ['label' => 'Cap rate'],
            'coc' => ['label' => 'Cash-on-cash return'],
            'irr' => ['label' => 'IRR'],
            'invested' => ['label' => 'Cash invested'],
            'grm' => ['label' => 'Gross rent multiplier'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NOI = rent × (1 − vacancy) − expenses</li>
            <li>cash flow = NOI − debt service</li>
            <li>IRR solves Σ CFₜ ÷ (1 + IRR)^t = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
