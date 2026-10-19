<x-calc.page
    title="Customer Acquisition Cost Calculator – CAC Calculator - SolveKit"
    description="Free Customer Acquisition Cost Calculator – CAC Calculator: CAC = sales and marketing spend ÷ new customers. CAC is the total cost of winning one new customer."
    lede="Work out the customer acquisition cost from sales and marketing spend, new customers and monthly gross margin per customer (optional)."
    about="CAC is the total cost of winning one new customer. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'customer_acquisition_cost', 'fields' => ['sales', 'customers', 'margin']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Sales and marketing spend, New customers, Monthly gross margin per customer (optional).'],
        ['name' => 'Read the result', 'text' => 'The customer acquisition cost appears as you type, with CAC payback below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the customer acquisition cost?', 'answer' => 'CAC = sales and marketing spend ÷ new customers; payback = CAC ÷ monthly gross margin.'],
        ['question' => 'What is the customer acquisition cost for sales and marketing spend $60,000, new customers 400, monthly gross margin per customer $50?', 'answer' => '$150.00. CAC payback: 3 months.'],
        ['question' => 'And for sales and marketing spend $18,000, new customers 90, monthly gross margin per customer $30?', 'answer' => '$200.00. CAC payback: 6.667 months.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Many SaaS investors look for CAC payback under 12 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sales" label="Sales and marketing spend" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="customers" label="New customers" value="400" min="0" step="1" />
        <x-calc.field name="margin" label="Monthly gross margin per customer (optional)" value="50" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Customer acquisition cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['sales' => 60000, 'customers' => 400, 'margin' => 50],
        'Example B' => ['sales' => 18000, 'customers' => 90, 'margin' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'CAC payback'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CAC = sales and marketing spend ÷ new customers</li>
            <li>payback = CAC ÷ monthly gross margin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
