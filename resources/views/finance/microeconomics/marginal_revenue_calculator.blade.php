<x-calc.page
    title="Marginal Revenue Calculator - SolveKit"
    description="Free Marginal Revenue Calculator: MR = ΔTR ÷ ΔQ. Marginal revenue is the extra revenue from selling one more unit."
    lede="Work out the marginal revenue from your figures."
    about="Marginal revenue is the extra revenue from selling one more unit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'marginal_revenue', 'fields' => ['rev1', 'rev2', 'q1', 'q2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total revenue before, Total revenue after, Quantity before, Quantity after.'],
        ['name' => 'Read the result', 'text' => 'The marginal revenue appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the marginal revenue?', 'answer' => 'MR = ΔTR ÷ ΔQ.'],
        ['question' => 'What is the marginal revenue for total revenue before $100,000, total revenue after $108,000, quantity before 1,000, quantity after 1,100?', 'answer' => '$80.00.'],
        ['question' => 'And for total revenue before $5,000, total revenue after $5,400, quantity before 50, quantity after 60?', 'answer' => '$40.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'For a price-taker it equals the price.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rev1" label="Total revenue before" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="rev2" label="Total revenue after" value="108000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Quantity before" value="1000" step="any" />
        <x-calc.field name="q2" label="Quantity after" value="1100" step="any" />
    </div>

    <x-calc.result label="Marginal revenue" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rev1' => 100000, 'rev2' => 108000, 'q1' => 1000, 'q2' => 1100],
        'Example B' => ['rev1' => 5000, 'rev2' => 5400, 'q1' => 50, 'q2' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MR = ΔTR ÷ ΔQ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
