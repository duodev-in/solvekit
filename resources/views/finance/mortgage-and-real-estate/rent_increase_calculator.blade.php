<x-calc.page
    title="Rent Increase Calculator - SolveKit"
    description="Free Rent Increase Calculator: increase = (new − current) ÷ current. Rent increase as a percentage; some states and cities cap annual increases (rent stabilization)."
    lede="Work out the rent increase from current rent and new rent."
    about="Rent increase as a percentage; some states and cities cap annual increases (rent stabilization). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'rent_increase', 'fields' => ['current', 'new']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Current rent, New rent.'],
        ['name' => 'Read the result', 'text' => 'The rent increase appears as you type, with monthly increase, yearly increase below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the rent increase?', 'answer' => 'Increase = (new − current) ÷ current.'],
        ['question' => 'What is the rent increase for current rent $1,500, new rent $1,600?', 'answer' => '6.667%. Monthly increase: $100.00.'],
        ['question' => 'And for current rent $2,200, new rent $2,420?', 'answer' => '10%. Monthly increase: $220.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Check local rules and required notice periods.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="current" label="Current rent" value="1500" step="0.01" suffix="$" />
        <x-calc.field name="new" label="New rent" value="1600" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Rent increase" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['current' => 1500, 'new' => 1600],
        'Example B' => ['current' => 2200, 'new' => 2420],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Monthly increase'],
            'r2' => ['label' => 'Yearly increase'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>increase = (new − current) ÷ current</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
