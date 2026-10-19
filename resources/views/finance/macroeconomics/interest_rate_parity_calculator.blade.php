<x-calc.page
    title="Interest Rate Parity Calculator - SolveKit"
    description="Free interest rate parity calculator: forward exchange rate from the spot rate and two interest rates (covered interest parity), and the gap from a quoted forward."
    lede="Find the forward rate implied by interest rate parity."
    about="Covered interest parity: F = S × (1 + i_quote × t) ÷ (1 + i_base × t), with simple money-market rates on a 360-day year (365 for GBP). If a quoted forward differs, borrowing in one currency and lending in the other would earn a riskless profit before costs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'irp', 'fields' => ['spot', 'rd', 'rf', 'days', 'basis', 'forward']]"
    :how-to="[
        ['name' => 'Enter spot and rates', 'text' => ''],
        ['name' => 'Enter the term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 90-day EUR/USD forward at 1.08 with USD 4.3% and EUR 2.25%?', 'answer' => '1.086.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spot" label="Spot rate (quote per base)" value="1.08" step="any" />
        <x-calc.field name="rd" label="Quote currency rate" value="4.3" step="any" suffix="%" />
        <x-calc.field name="rf" label="Base currency rate" value="2.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="days" label="Days" value="90" min="1" step="1" suffix="days" />
        <x-calc.select name="basis" label="Day count" :options="['360' => '360', '365' => '365']" selected="360" />
        <x-calc.field name="forward" label="Quoted forward (optional)" value="" step="any" />
    </div>

    <x-calc.result label="Forward rate by covered interest parity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['spot' => 1.08, 'rd' => 4.3, 'rf' => 2.25, 'days' => 90, 'basis' => '360', 'forward' => ''],
        'USD/JPY' => ['spot' => 150, 'rd' => 0.5, 'rf' => 4.3, 'days' => 180, 'basis' => '360', 'forward' => 147.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'points' => ['label' => 'Forward points'],
            'premium' => ['label' => 'Annualized premium'],
            'arbitrage' => ['label' => 'Quoted vs parity'],
            'continuous' => ['label' => 'Continuous version'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = S(1 + i_q t) ÷ (1 + i_b t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
