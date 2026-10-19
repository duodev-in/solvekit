<x-calc.page
    title="Coupon Rate Calculator - SolveKit"
    description="Free Coupon Rate Calculator: coupon rate = annual coupon ÷ face value. The coupon rate is fixed when the bond is issued and does not change with price."
    lede="Work out the coupon rate from annual coupon payments and face value."
    about="The coupon rate is fixed when the bond is issued and does not change with price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'coupon_rate', 'fields' => ['coupon', 'face']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual coupon payments, Face value.'],
        ['name' => 'Read the result', 'text' => 'The coupon rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the coupon rate?', 'answer' => 'Coupon rate = annual coupon ÷ face value.'],
        ['question' => 'What is the coupon rate for annual coupon payments $60, face value $1,000?', 'answer' => '6%.'],
        ['question' => 'And for annual coupon payments $22.50, face value $500?', 'answer' => '4.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It differs from current yield and YTM unless the bond trades at par.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="coupon" label="Annual coupon payments" value="60" step="0.01" suffix="$" />
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Coupon rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['coupon' => 60, 'face' => 1000],
        'Example B' => ['coupon' => 22.5, 'face' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coupon rate = annual coupon ÷ face value</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
