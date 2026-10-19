<x-calc.page
    title="Yield to Maturity Calculator - SolveKit"
    description="Free yield to maturity calculator: YTM of a bond from its clean price, coupon, settlement and maturity dates, by root-finding."
    lede="Calculate yield to maturity."
    about="YTM is the single discount rate (compounded at the coupon frequency) that equates the bond's cash flows with its dirty price. It assumes you hold to maturity and reinvest coupons at the same rate. Cash flows are the coupons (coupon rate × face ÷ frequency) and the face value at maturity, discounted at the yield per period. Coupon dates step back from maturity; between coupons the buyer pays accrued interest, so the dirty (invoice) price = clean price + accrued. Results match spreadsheet PRICE, YIELD and DURATION functions. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'bond_yield', 'fields' => ['settle', 'maturity', 'coupon', 'price', 'face', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter dates, coupon and price', 'text' => ''],
        ['name' => 'Read the YTM', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the YTM of the Excel YIELD example?', 'answer' => '6.5% (30/360).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="settle" label="Settlement date" value="2008-02-15" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2016-11-15" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon rate" value="5.75" step="any" suffix="%" />
        <x-calc.field name="price" label="Clean price" value="95.04287" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="face" label="Face value" value="100" step="0.01" suffix="$" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Yield to maturity" />

    <x-calc.options :decimals="false" :examples="[
        'Excel' => ['settle' => '2008-02-15', 'maturity' => '2016-11-15', 'coupon' => 5.75, 'price' => 95.04287, 'face' => 100, 'freq' => '2', 'basis' => '30360'],
        'Treasury' => ['settle' => '2026-10-18', 'maturity' => '2031-09-30', 'coupon' => 4, 'price' => 99.2, 'face' => 100, 'freq' => '2', 'basis' => 'act'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'current' => ['label' => 'Current yield'],
            'ytc' => ['label' => 'Yield to call'],
            'worst' => ['label' => 'Yield to worst'],
            'effective' => ['label' => 'Effective annual yield'],
            'accrued' => ['label' => 'Accrued interest'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>solve P + AI = Σ CF ÷ (1 + y/f)^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
