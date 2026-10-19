<x-calc.page
    title="CLTV Calculator — Customer Lifetime Value - SolveKit"
    description="Free CLTV Calculator — Customer Lifetime Value: CLV = AOV × purchases a year × margin × years (discounted). Customer lifetime value is the gross profit a customer brings over the relationship."
    lede="Work out the customer lifetime value from your figures."
    about="Customer lifetime value is the gross profit a customer brings over the relationship. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cltv', 'fields' => ['value', 'frequency', 'margin', 'years', 'discount']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Average order value, Purchases a year, Gross margin, Customer lifespan, Discount rate (optional).'],
        ['name' => 'Read the result', 'text' => 'The customer lifetime value appears as you type, with yearly gross profit per customer below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the customer lifetime value?', 'answer' => 'CLV = AOV × purchases a year × margin × years (discounted).'],
        ['question' => 'What is the customer lifetime value for average order value $80, purchases a year 4, gross margin 40%, customer lifespan 3 years, discount rate 0%?', 'answer' => '$384.00. Yearly gross profit per customer: $128.00.'],
        ['question' => 'And for average order value $45, purchases a year 10, gross margin 30%, customer lifespan 5 years, discount rate 10%?', 'answer' => '$511.76. Yearly gross profit per customer: $135.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with acquisition cost.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Average order value" value="80" step="0.01" suffix="$" />
        <x-calc.field name="frequency" label="Purchases a year" value="4" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="margin" label="Gross margin" value="40" step="any" suffix="%" />
        <x-calc.field name="years" label="Customer lifespan" value="3" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="discount" label="Discount rate (optional)" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Customer lifetime value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['value' => 80, 'frequency' => 4, 'margin' => 40, 'years' => 3, 'discount' => 0],
        'Example B' => ['value' => 45, 'frequency' => 10, 'margin' => 30, 'years' => 5, 'discount' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Yearly gross profit per customer'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CLV = AOV × purchases a year × margin × years (discounted)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
