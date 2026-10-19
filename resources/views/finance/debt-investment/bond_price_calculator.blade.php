<x-calc.page
    title="Bond Price Calculator - SolveKit"
    description="Free bond price calculator: clean and dirty price, accrued interest and duration of a coupon bond from its yield, settlement and maturity dates."
    lede="Price a bond from its yield."
    about="Cash flows are the coupons (coupon rate × face ÷ frequency) and the face value at maturity, discounted at the yield per period. Coupon dates step back from maturity; between coupons the buyer pays accrued interest, so the dirty (invoice) price = clean price + accrued. Results match spreadsheet PRICE, YIELD and DURATION functions. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'bond_price', 'fields' => ['settle', 'maturity', 'coupon', 'ytm', 'face', 'freq', 'basis']]"
    :how-to="[
        ['name' => 'Enter dates and coupon', 'text' => ''],
        ['name' => 'Enter the yield', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a 4.5% bond maturing May 2036 worth at a 4.8% yield?', 'answer' => '$977.15 clean per $1,000.'],
        ['question' => 'What is the Excel example (5.75%, 6.5%, 30/360)?', 'answer' => '$94.63 per 100.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="settle" label="Settlement date" value="2026-10-18" type="date" />
        <x-calc.field name="maturity" label="Maturity date" value="2036-05-15" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Coupon rate" value="4.5" step="any" suffix="%" />
        <x-calc.field name="ytm" label="Yield to maturity" value="4.8" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
        <x-calc.select name="freq" label="Coupons a year" :options="['2' => 'Semi-annual', '1' => 'Annual', '4' => 'Quarterly', '12' => 'Monthly']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="basis" label="Day count" :options="['act' => 'Actual/actual', '30360' => '30/360']" selected="act" />
    </div>

    <x-calc.result label="Clean price" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['settle' => '2026-10-18', 'maturity' => '2036-05-15', 'coupon' => 4.5, 'ytm' => 4.8, 'face' => 1000, 'freq' => '2', 'basis' => 'act'],
        'Excel check' => ['settle' => '2008-02-15', 'maturity' => '2017-11-15', 'coupon' => 5.75, 'ytm' => 6.5, 'face' => 100, 'freq' => '2', 'basis' => '30360'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'dirty' => ['label' => 'Dirty price'],
            'accrued' => ['label' => 'Accrued interest'],
            'current' => ['label' => 'Current yield'],
            'coupons' => ['label' => 'Coupons'],
            'duration' => ['label' => 'Duration'],
            'premium' => ['label' => 'Premium or discount'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dirty = Σ CFₖ ÷ (1 + y/f)^(w + k)</li>
            <li>clean = dirty − accrued</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
