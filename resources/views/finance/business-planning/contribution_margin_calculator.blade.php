<x-calc.page
    title="Contribution Margin Calculator - SolveKit"
    description="Free Contribution Margin Calculator: CM = price − variable cost. Contribution margin is what each sale contributes toward fixed costs and profit."
    lede="Work out the contribution margin per unit from price per unit, variable cost per unit and units sold (optional)."
    about="Contribution margin is what each sale contributes toward fixed costs and profit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'contribution_margin', 'fields' => ['price', 'variable', 'units']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price per unit, Variable cost per unit, Units sold (optional).'],
        ['name' => 'Read the result', 'text' => 'The contribution margin per unit appears as you type, with contribution margin ratio, total contribution below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the contribution margin per unit?', 'answer' => 'CM = price − variable cost; CM ratio = CM ÷ price.'],
        ['question' => 'What is the contribution margin per unit for price per unit $50, variable cost per unit $30, units sold 1,000?', 'answer' => '$20.00. Contribution margin ratio: 40%.'],
        ['question' => 'And for price per unit $120, variable cost per unit $85, units sold 400?', 'answer' => '$35.00. Contribution margin ratio: 29.17%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 40% CM ratio means 40 cents of each dollar of sales covers fixed costs and profit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Price per unit" value="50" step="0.01" suffix="$" />
        <x-calc.field name="variable" label="Variable cost per unit" value="30" step="0.01" suffix="$" />
        <x-calc.field name="units" label="Units sold (optional)" value="1000" min="0" step="1" />
    </div>

    <x-calc.result label="Contribution margin per unit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 50, 'variable' => 30, 'units' => 1000],
        'Example B' => ['price' => 120, 'variable' => 85, 'units' => 400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Contribution margin ratio'],
            'r2' => ['label' => 'Total contribution'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CM = price − variable cost</li>
            <li>CM ratio = CM ÷ price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
