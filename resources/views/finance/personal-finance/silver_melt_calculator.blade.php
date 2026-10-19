<x-calc.page
    title="Silver Melt Calculator - SolveKit"
    description="Free Silver Melt Calculator: value = grams × purity ÷ 31.1035 × spot. Silver melt value from its pure silver content at the spot price you enter."
    lede="Work out the melt value from weight (grams), purity (sterling 92.5%, 90% coin silver) and silver spot price per troy ounce."
    about="Silver melt value from its pure silver content at the spot price you enter. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'silver_melt', 'fields' => ['weight', 'purity', 'spot']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Weight (grams), Purity (sterling 92.5%, 90% coin silver), Silver spot price per troy ounce.'],
        ['name' => 'Read the result', 'text' => 'The melt value appears as you type, with pure silver (g), troy ounces below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the melt value?', 'answer' => 'Value = grams × purity ÷ 31.1035 × spot.'],
        ['question' => 'What is the melt value for weight 100, purity 92.5%, silver spot price per troy ounce $45?', 'answer' => '$133.83. Pure silver (g): 92.5.'],
        ['question' => 'And for weight 25, purity 90%, silver spot price per troy ounce $45?', 'answer' => '$32.55. Pure silver (g): 22.5.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Pre-1965 US dimes, quarters and halves are 90% silver: a dime holds 2.25 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="weight" label="Weight (grams)" value="100" step="any" />
        <x-calc.field name="purity" label="Purity (sterling 92.5%, 90% coin silver)" value="92.5" step="any" suffix="%" />
        <x-calc.field name="spot" label="Silver spot price per troy ounce" value="45" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Melt value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['weight' => 100, 'purity' => 92.5, 'spot' => 45],
        'Example B' => ['weight' => 25, 'purity' => 90, 'spot' => 45],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Pure silver (g)'],
            'r2' => ['label' => 'Troy ounces'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = grams × purity ÷ 31.1035 × spot</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
