<x-calc.page
    title="Coupon Payment Calculator - SolveKit"
    description="Free Coupon Payment Calculator: coupon = face × coupon rate ÷ payments a year. Each coupon is the face value times the coupon rate, split over the payments in a year."
    lede="Work out the coupon payment from face value, coupon rate and payments a year."
    about="Each coupon is the face value times the coupon rate, split over the payments in a year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'coupon_payment', 'fields' => ['face', 'rate', 'per']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Face value, Coupon rate, Payments a year.'],
        ['name' => 'Read the result', 'text' => 'The coupon payment appears as you type, with annual coupon below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the coupon payment?', 'answer' => 'Coupon = face × coupon rate ÷ payments a year.'],
        ['question' => 'What is the coupon payment for face value $1,000, coupon rate 5%, payments a year 2?', 'answer' => '$25.00. Annual coupon: $50.00.'],
        ['question' => 'And for face value $5,000, coupon rate 4.25%, payments a year 2?', 'answer' => '$106.25. Annual coupon: $212.50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Most US corporate bonds pay twice a year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="face" label="Face value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Coupon rate" value="5" step="any" suffix="%" />
        <x-calc.field name="per" label="Payments a year" value="2" min="0" step="1" />
    </div>

    <x-calc.result label="Coupon payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['face' => 1000, 'rate' => 5, 'per' => 2],
        'Example B' => ['face' => 5000, 'rate' => 4.25, 'per' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Annual coupon'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coupon = face × coupon rate ÷ payments a year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
