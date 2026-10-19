<x-calc.page
    title="Lerner Index Calculator - SolveKit"
    description="Free Lerner Index Calculator: L = (P − MC) ÷ P. The Lerner index measures market power: 0 under perfect competition, approaching 1 with strong monopoly power."
    lede="Work out the Lerner index from price and marginal cost."
    about="The Lerner index measures market power: 0 under perfect competition, approaching 1 with strong monopoly power. Under profit maximization it equals 1 ÷ |price elasticity of demand|. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'lerner_index', 'fields' => ['price', 'mc']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price, Marginal cost.'],
        ['name' => 'Read the result', 'text' => 'The Lerner index appears as you type, with implied demand elasticity below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Lerner index?', 'answer' => 'L = (P − MC) ÷ P.'],
        ['question' => 'What is the Lerner index for price $100, marginal cost $70?', 'answer' => '0.3. Implied demand elasticity: −3.333.'],
        ['question' => 'And for price $25, marginal cost $20?', 'answer' => '0.2. Implied demand elasticity: −5.'],
        ['question' => 'What does the result tell me?', 'answer' => 'An index of 0.3 means price is 30% above marginal cost.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="mc" label="Marginal cost" value="70" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Lerner index" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 100, 'mc' => 70],
        'Example B' => ['price' => 25, 'mc' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Implied demand elasticity'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = (P − MC) ÷ P</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
