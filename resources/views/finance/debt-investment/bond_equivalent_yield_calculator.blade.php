<x-calc.page
    title="Bond Equivalent Yield Calculator - SolveKit"
    description="Free Bond Equivalent Yield Calculator: BEY = (face − price) ÷ price × 365 ÷ days. The bond equivalent yield annualizes the return on a discount security (such as a Treasury bill) so it can be compared with coupon bonds."
    lede="Work out the bond equivalent yield from face value, purchase price and days to maturity."
    about="The bond equivalent yield annualizes the return on a discount security (such as a Treasury bill) so it can be compared with coupon bonds. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'bond_equivalent_yield', 'fields' => ['face', 'price', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Face value, Purchase price, Days to maturity.'],
        ['name' => 'Read the result', 'text' => 'The bond equivalent yield appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the bond equivalent yield?', 'answer' => 'BEY = (face − price) ÷ price × 365 ÷ days.'],
        ['question' => 'What is the bond equivalent yield for face value $1,000, purchase price $985, days to maturity 182?', 'answer' => '3.054%.'],
        ['question' => 'And for face value $10,000, purchase price $9,890, days to maturity 91?', 'answer' => '4.461%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Treasury bills over 182 days use a slightly different formula.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Purchase price" value="985" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days to maturity" value="182" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Bond equivalent yield" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['face' => 1000, 'price' => 985, 'days' => 182],
        'Example B' => ['face' => 10000, 'price' => 9890, 'days' => 91],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BEY = (face − price) ÷ price × 365 ÷ days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
