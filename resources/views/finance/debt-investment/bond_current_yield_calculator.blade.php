<x-calc.page
    title="Bond Current Yield Calculator - SolveKit"
    description="Free Bond Current Yield Calculator: current yield = annual coupon ÷ price. Current yield is the bond's income return at today's price, ignoring the gain or loss at maturity."
    lede="Work out the current yield from annual coupon payment and bond price."
    about="Current yield is the bond's income return at today's price, ignoring the gain or loss at maturity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'bond_current_yield', 'fields' => ['coupon', 'price']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual coupon payment, Bond price.'],
        ['name' => 'Read the result', 'text' => 'The current yield appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the current yield?', 'answer' => 'Current yield = annual coupon ÷ price.'],
        ['question' => 'What is the current yield for annual coupon payment $50, bond price $950?', 'answer' => '5.263%.'],
        ['question' => 'And for annual coupon payment $37.50, bond price $1,040?', 'answer' => '3.606%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'YTM also includes the pull to par.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Annual coupon payment" value="50" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Bond price" value="950" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Current yield" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['coupon' => 50, 'price' => 950],
        'Example B' => ['coupon' => 37.5, 'price' => 1040],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>current yield = annual coupon ÷ price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
