<x-calc.page
    title="Margin Call Calculator - SolveKit"
    description="Free Margin Call Calculator: margin call price = P × (1 − initial margin) ÷ (1 − maintenance margin). A long margin position gets a margin call when equity falls to the maintenance requirement (FINRA minimum 25%)."
    lede="Work out the margin call price from purchase price, initial margin and maintenance margin."
    about="A long margin position gets a margin call when equity falls to the maintenance requirement (FINRA minimum 25%). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_call', 'fields' => ['price', 'initial', 'maintenance']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Purchase price, Initial margin, Maintenance margin.'],
        ['name' => 'Read the result', 'text' => 'The margin call price appears as you type, with fall before the call below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the margin call price?', 'answer' => 'Margin call price = P × (1 − initial margin) ÷ (1 − maintenance margin).'],
        ['question' => 'What is the margin call price for purchase price $50, initial margin 50%, maintenance margin 25%?', 'answer' => '$33.33. Fall before the call: 33.33%.'],
        ['question' => 'And for purchase price $120, initial margin 60%, maintenance margin 30%?', 'answer' => '$68.57. Fall before the call: 42.86%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Brokers can require more and sell without notice.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Purchase price" value="50" step="0.01" suffix="$" />
        <x-calc.field name="initial" label="Initial margin" value="50" step="any" suffix="%" />
        <x-calc.field name="maintenance" label="Maintenance margin" value="25" step="any" suffix="%" />
    </div>

    <x-calc.result label="Margin call price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 50, 'initial' => 50, 'maintenance' => 25],
        'Example B' => ['price' => 120, 'initial' => 60, 'maintenance' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Fall before the call'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>margin call price = P × (1 − initial margin) ÷ (1 − maintenance margin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
