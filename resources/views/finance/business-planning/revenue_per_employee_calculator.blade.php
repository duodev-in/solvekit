<x-calc.page
    title="Revenue Per Employee Calculator - SolveKit"
    description="Free Revenue Per Employee Calculator: revenue per employee = revenue ÷ employees. Revenue per employee is a rough measure of labor productivity; it varies hugely by industry."
    lede="Work out the revenue per employee from annual revenue and employees (FTE)."
    about="Revenue per employee is a rough measure of labor productivity; it varies hugely by industry. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'revenue_per_employee', 'fields' => ['revenue', 'employees']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual revenue, Employees (FTE).'],
        ['name' => 'Read the result', 'text' => 'The revenue per employee appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the revenue per employee?', 'answer' => 'Revenue per employee = revenue ÷ employees.'],
        ['question' => 'What is the revenue per employee for annual revenue $25,000,000, employees 120?', 'answer' => '$208,333.33.'],
        ['question' => 'And for annual revenue $4,000,000, employees 32?', 'answer' => '$125,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with companies in the same industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Annual revenue" value="25000000" step="0.01" suffix="$" />
        <x-calc.field name="employees" label="Employees (FTE)" value="120" step="any" />
    </div>

    <x-calc.result label="Revenue per employee" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 25000000, 'employees' => 120],
        'Example B' => ['revenue' => 4000000, 'employees' => 32],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>revenue per employee = revenue ÷ employees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
