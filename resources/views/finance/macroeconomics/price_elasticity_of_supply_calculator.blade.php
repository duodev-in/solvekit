<x-calc.page
    title="Price Elasticity of Supply Calculator - SolveKit"
    description="Free Price Elasticity of Supply Calculator: PES = %ΔQs ÷ %ΔP (midpoint method). Elasticity of supply measures how much producers respond to price."
    lede="Work out the price elasticity of supply from your figures."
    about="Elasticity of supply measures how much producers respond to price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_elasticity_of_supply', 'fields' => ['q1', 'q2', 'p1', 'p2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Quantity supplied before, Quantity supplied after, Price before, Price after.'],
        ['name' => 'Read the result', 'text' => 'The price elasticity of supply appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price elasticity of supply?', 'answer' => 'PES = %ΔQs ÷ %ΔP (midpoint method).'],
        ['question' => 'What is the price elasticity of supply for quantity supplied before 1,000, quantity supplied after 1,200, price before $10, price after $12?', 'answer' => '1.'],
        ['question' => 'And for quantity supplied before 500, quantity supplied after 520, price before $4, price after $6?', 'answer' => '0.09804.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 1 is elastic; supply is usually more elastic in the long run.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Quantity supplied before" value="1000" step="any" />
        <x-calc.field name="q2" label="Quantity supplied after" value="1200" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="Price before" value="10" step="0.01" suffix="$" />
        <x-calc.field name="p2" label="Price after" value="12" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Price elasticity of supply" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['q1' => 1000, 'q2' => 1200, 'p1' => 10, 'p2' => 12],
        'Example B' => ['q1' => 500, 'q2' => 520, 'p1' => 4, 'p2' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PES = %ΔQs ÷ %ΔP (midpoint method)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
