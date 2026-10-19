<x-calc.page
    title="Sales Commission Calculator - SolveKit"
    description="Free sales commission calculator: flat-rate or tiered commission, with base pay and a draw against commission."
    lede="Work out sales commission."
    about="Flat: commission = sales × rate. Tiered: each rate applies to sales within its tier. With a draw, the rep receives at least the draw; if commission falls short, the shortfall is usually recovered from future commission (recoverable draw). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'commission', 'fields' => ['plan', 'sales', 'base', 'draw', 'rate', 'tiers']]"
    :how-to="[
        ['name' => 'Choose flat or tiered', 'text' => ''],
        ['name' => 'Enter sales, base and draw', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does $120,000 earn on tiers of 3%, 5% over $50,000 and 8% over $100,000?', 'answer' => 'Commission $5,600.00; total pay $8,600.00.'],
        ['question' => 'And at a flat 5%?', 'answer' => '$6,000.00.'],
    ]"
>
    <x-calc.segmented name="plan" legend="Plan" :options="['flat' => 'Flat rate', 'tiered' => 'Tiered']" selected="tiered" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sales" label="Sales for the period" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="base" label="Base pay" value="3000" step="0.01" suffix="$" />
        <x-calc.field name="draw" label="Draw (optional)" value="0" step="0.01" suffix="$" />
    </div>

    <div data-show-when="plan:flat" hidden>
        <x-calc.field name="rate" label="Commission rate" value="5" step="any" suffix="%" />
    </div>

    <div data-show-when="plan:tiered">
        <x-calc.rows-editor name="tiers" label="Tiers (from sales level, rate %)" :columns="['from' => 'From', 'rate' => 'Rate %']" :rows="[[0, 3], [50000, 5], [100000, 8]]" />
    </div>

    <x-calc.result label="Pay for the period" />

    <x-calc.options :decimals="false" :examples="[
        'Tiered' => ['plan' => 'tiered', 'sales' => 120000, 'base' => 3000, 'draw' => 0, 'rate' => '', 'tiers' => '0 3
50000 5
100000 8'],
        'Flat' => ['plan' => 'flat', 'sales' => 120000, 'base' => 3000, 'draw' => 0, 'rate' => 5, 'tiers' => ''],
        'Draw' => ['plan' => 'flat', 'sales' => 40000, 'base' => 0, 'draw' => 4000, 'rate' => 6, 'tiers' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'commission' => ['label' => 'Commission'],
            'effective' => ['label' => 'Effective rate'],
            'draw' => ['label' => 'Draw carried forward'],
            'base' => ['label' => 'Base'],
        ]" />
        <x-calc.quick-ref heading="By tier" name="tiers" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>flat: sales × rate</li>
            <li>tiered: Σ rateₖ × sales in tier k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
