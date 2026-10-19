<x-calc.page
    title="Enterprise Value Calculator - SolveKit"
    description="Free Enterprise Value Calculator: EV = market cap + debt + preferred + minority interest − cash. Enterprise value is the value of the whole business: what it would cost to buy all the equity and pay off the debt, net of cash."
    lede="Work out the enterprise value from your figures."
    about="Enterprise value is the value of the whole business: what it would cost to buy all the equity and pay off the debt, net of cash. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'enterprise_value', 'fields' => ['cap', 'debt', 'preferred', 'minority', 'cash']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Market capitalization, Total debt, Preferred stock, Minority interest, Cash and equivalents.'],
        ['name' => 'Read the result', 'text' => 'The enterprise value appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the enterprise value?', 'answer' => 'EV = market cap + debt + preferred + minority interest − cash.'],
        ['question' => 'What is the enterprise value for market capitalization $80,000,000, total debt $25,000,000, preferred stock $0, minority interest $0, cash and equivalents $10,000,000?', 'answer' => '$95,000,000.00.'],
        ['question' => 'And for market capitalization $3,500,000,000, total debt $1,200,000,000, preferred stock $0, minority interest $50,000,000, cash and equivalents $400,000,000?', 'answer' => '$4,350,000,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Used for EV/EBITDA and EV/Sales.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap" label="Market capitalization" value="80000000" step="0.01" suffix="$" />
        <x-calc.field name="debt" label="Total debt" value="25000000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="preferred" label="Preferred stock" value="0" step="0.01" suffix="$" />
        <x-calc.field name="minority" label="Minority interest" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash" label="Cash and equivalents" value="10000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Enterprise value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cap' => 80000000, 'debt' => 25000000, 'preferred' => 0, 'minority' => 0, 'cash' => 10000000],
        'Example B' => ['cap' => 3500000000, 'debt' => 1200000000, 'preferred' => 0, 'minority' => 50000000, 'cash' => 400000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EV = market cap + debt + preferred + minority interest − cash</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
