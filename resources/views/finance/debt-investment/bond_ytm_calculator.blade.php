<x-calc.page
    title="Bond YTM Calculator - SolveKit"
    description="Free bond YTM calculator: yield to maturity from price, coupon and maturity, with current yield."
    lede="Find a bond's yield to maturity."
    about="A bond priced below par yields more than its coupon; above par, less. Cash flows are the coupons (coupon rate × face ÷ frequency) and the face value at maturity, discounted at the yield per period. Coupon dates step back from maturity; between coupons the buyer pays accrued interest, so the dirty (invoice) price = clean price + accrued. Results match spreadsheet PRICE, YIELD and DURATION functions. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'bond_yield', 'fields' => ['settle', 'maturity', 'coupon', 'price', 'face', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter the bond', 'text' => ''],
        ['name' => 'Read the YTM', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the YTM of a 5.5% bond at $1,050?', 'answer' => '4.841%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="settle" label="Settlement date" value="2026-10-18" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2036-05-15" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon rate" value="5.5" step="any" suffix="%" />
        <x-calc.field name="price" label="Clean price" value="1050" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Yield to maturity" />

    <x-calc.options :decimals="false" :examples="[
        'Premium' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 5.5, 'price' => 1050, 'face' => 1000, 'freq' => '2', 'basis' => 'act'],
        'Discount' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 3, 'price' => 880, 'face' => 1000, 'freq' => '2', 'basis' => 'act'],
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
            <li>solve price = PV(cash flows) for y</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
