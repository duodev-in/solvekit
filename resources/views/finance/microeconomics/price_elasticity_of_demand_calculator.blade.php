<x-calc.page
    title="Price Elasticity of Demand Calculator - SolveKit"
    description="Free Price Elasticity of Demand Calculator: PED = %ΔQ ÷ %ΔP (midpoint method). Elasticity measures how strongly buyers respond to price; |PED| > 1 is elastic."
    lede="Work out the price elasticity of demand from your figures."
    about="Elasticity measures how strongly buyers respond to price; |PED| > 1 is elastic. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_elasticity_of_demand', 'fields' => ['q1', 'q2', 'p1', 'p2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Quantity before, Quantity after, Price before, Price after.'],
        ['name' => 'Read the result', 'text' => 'The price elasticity of demand appears as you type, with revenue before, revenue after below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price elasticity of demand?', 'answer' => 'PED = %ΔQ ÷ %ΔP (midpoint method).'],
        ['question' => 'What is the price elasticity of demand for quantity before 1,000, quantity after 900, price before $10, price after $11?', 'answer' => '−1.105. Revenue before: $10,000.00.'],
        ['question' => 'And for quantity before 200, quantity after 150, price before $2, price after $2.50?', 'answer' => '−1.286. Revenue before: $400.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'With elastic demand, raising price lowers revenue.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Quantity before" value="1000" step="any" />
        <x-calc.field name="q2" label="Quantity after" value="900" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="Price before" value="10" step="0.01" suffix="$" />
        <x-calc.field name="p2" label="Price after" value="11" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Price elasticity of demand" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['q1' => 1000, 'q2' => 900, 'p1' => 10, 'p2' => 11],
        'Example B' => ['q1' => 200, 'q2' => 150, 'p1' => 2, 'p2' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Revenue before'],
            'r2' => ['label' => 'Revenue after'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PED = %ΔQ ÷ %ΔP (midpoint method)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
