<x-calc.page
    title="Yield to Call Calculator - SolveKit"
    description="Free yield to call calculator: the yield of a callable bond if it is redeemed at the call date and call price, with yield to worst."
    lede="Find a callable bond's yield to call."
    about="Yield to call treats the call date as maturity and the call price as the redemption value. For bonds above par the issuer is likely to call when rates fall, so yield to worst (the lower of YTM and YTC) is the cautious figure. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'bond_yield', 'fields' => ['settle', 'maturity', 'coupon', 'price', 'face', 'call_date', 'call_price', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter the bond and price', 'text' => ''],
        ['name' => 'Enter call date and price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the yield to call of a 6% bond at $1,040 callable at par in 2030?', 'answer' => '4.769%; YTM 5.457%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="settle" label="Settlement date" value="2026-10-18" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2036-05-15" type="date" />
        <x-calc.field name="coupon" label="Coupon rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Clean price" value="1040" step="0.01" suffix="$" />
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="call_date" label="Call date" value="2030-05-15" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="call_price" label="Call price" value="1000" step="0.01" suffix="$" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Yield to maturity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 6, 'price' => 1040, 'face' => 1000, 'call_date' => '2030-05-15', 'call_price' => 1000, 'freq' => '2', 'basis' => 'act'],
        'Call premium' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 6, 'price' => 1040, 'face' => 1000, 'call_date' => '2029-05-15', 'call_price' => 1020, 'freq' => '2', 'basis' => 'act'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ytc' => ['label' => 'Yield to call'],
            'worst' => ['label' => 'Yield to worst'],
            'current' => ['label' => 'Current yield'],
            'effective' => ['label' => 'Effective annual yield'],
            'accrued' => ['label' => 'Accrued interest'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>YTC: redemption = call price at the call date</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
