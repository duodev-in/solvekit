<x-calc.page
    title="Bond Convexity Calculator - SolveKit"
    description="Free bond convexity calculator: convexity of a bond and how much it improves the duration estimate of price change."
    lede="Calculate a bond's convexity."
    about="Convexity = Σ CFₜ t(t + 1) ÷ (1 + y/f)^(t + 2) ÷ (P f²). Price change ≈ −D_mod Δy + ½ C Δy². The exact repricing is shown for comparison. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'convexity', 'fields' => ['settle', 'maturity', 'coupon', 'ytm', 'shift', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter the bond', 'text' => ''],
        ['name' => 'Choose a yield change', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much does convexity add for a 2-point yield rise on a 20-year 5% bond?', 'answer' => 'Duration alone −25.09%; with convexity −20.86%; exact −21.34%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="settle" label="Settlement date" value="2026-10-18" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2046-10-15" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon rate" value="5" step="any" suffix="%" />
        <x-calc.field name="ytm" label="Yield" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shift" label="Yield change" value="2" step="any" suffix="%" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Convexity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['settle' => '2026-10-18', 'maturity' => '2046-10-15', 'coupon' => 5, 'ytm' => 5, 'shift' => 2, 'freq' => '2', 'basis' => 'act'],
        'Zero-ish coupon' => ['settle' => '2026-10-18', 'maturity' => '2046-10-15', 'coupon' => 0.5, 'ytm' => 5, 'shift' => 2, 'freq' => '2', 'basis' => 'act'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'duration' => ['label' => 'Duration estimate'],
            'withConvexity' => ['label' => 'With convexity'],
            'exact' => ['label' => 'Exact change'],
            'macaulay' => ['label' => 'Macaulay duration'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C = Σ CF t(t + 1) ÷ (1 + y/f)^(t+2) ÷ (P f²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
