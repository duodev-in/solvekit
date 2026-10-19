<x-calc.page
    title="Bond Yield Calculator - SolveKit"
    description="Free bond yield calculator: current yield, yield to maturity and yield to call from a bond's price, coupon and dates."
    lede="Find a bond's yields from its price."
    about="Current yield = annual coupon ÷ clean price. Yield to maturity is the rate that makes the present value of all cash flows equal the dirty price. Yield to call does the same to the call date and price; yield to worst is the lower. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'bond_yield', 'fields' => ['settle', 'maturity', 'coupon', 'price', 'face', 'call_date', 'call_price', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter dates and coupon', 'text' => ''],
        ['name' => 'Enter the price', 'text' => 'And a call date if callable.'],
    ]"
    :faqs="[
        ['question' => 'What is the yield of a 4.5% bond at $970?', 'answer' => '4.896%; current yield 4.639%.'],
        ['question' => 'And to its 2030 call at par?', 'answer' => '4.769%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="settle" label="Settlement date" value="2026-10-18" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2036-05-15" type="date" />
        <x-calc.field name="coupon" label="Coupon rate" value="4.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Clean price" value="970" step="0.01" suffix="$" />
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="call_date" label="Call date (optional)" value="" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="call_price" label="Call price (optional)" value="1000" step="0.01" suffix="$" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Yield to maturity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 4.5, 'price' => 970, 'face' => 1000, 'call_date' => '', 'call_price' => '', 'freq' => '2', 'basis' => 'act'],
        'Callable' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 6, 'price' => 1040, 'face' => 1000, 'call_date' => '2030-05-15', 'call_price' => 1000, 'freq' => '2', 'basis' => 'act'],
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
            <li>price + accrued = Σ CFₖ ÷ (1 + y/f)^(w + k), solved for y</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
