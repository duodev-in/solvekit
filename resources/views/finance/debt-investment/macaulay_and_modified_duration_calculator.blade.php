<x-calc.page
    title="Macaulay and Modified Duration Calculator - SolveKit"
    description="Free bond duration calculator: Macaulay and modified duration, convexity and DV01 from coupon, yield and dates."
    lede="Measure a bond's interest-rate sensitivity."
    about="Macaulay duration is the present-value-weighted average time to the cash flows, in years. Modified duration = Macaulay ÷ (1 + y/f) is the approximate % price change for a 1-point yield change. Adding ½ × convexity × Δy² improves the estimate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'duration', 'fields' => ['settle', 'maturity', 'coupon', 'ytm', 'shift', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter dates, coupon and yield', 'text' => ''],
        ['name' => 'Read duration and convexity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the duration in the Excel DURATION example (8% coupon, 9% yield, 2018–2048)?', 'answer' => '10.92 years; modified 10.45.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="settle" label="Settlement date" value="2018-07-01" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2048-01-01" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon rate" value="8" step="any" suffix="%" />
        <x-calc.field name="ytm" label="Yield" value="9" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shift" label="Yield change to test" value="1" step="any" suffix="%" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Macaulay duration" />

    <x-calc.options :decimals="false" :examples="[
        'Excel' => ['settle' => '2018-07-01', 'maturity' => '2048-01-01', 'coupon' => 8, 'ytm' => 9, 'shift' => 1, 'freq' => '2', 'basis' => 'act'],
        '5-year note' => ['settle' => '2026-10-18', 'maturity' => '2031-10-15', 'coupon' => 4, 'ytm' => 4.2, 'shift' => 1, 'freq' => '2', 'basis' => 'act'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'modified' => ['label' => 'Modified duration'],
            'convexity' => ['label' => 'Convexity'],
            'change' => ['label' => 'Estimated price change'],
            'dv01' => ['label' => 'DV01'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D_mac = Σ t PV(CFₜ) ÷ P</li>
            <li>D_mod = D_mac ÷ (1 + y/f)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
