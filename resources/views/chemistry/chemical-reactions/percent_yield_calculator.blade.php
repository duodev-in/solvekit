<x-calc.page
    title="Percent Yield Calculator - SolveKit"
    description="Free percent yield calculator: percent yield from actual and theoretical yield."
    lede="Work out the percent yield of a reaction."
    about="Percent yield is the actual yield divided by the theoretical yield, times 100. Use the Theoretical Yield Calculator if you need the theoretical amount from the equation."
    :calc="['engine' => 'chem-reactions', 'tool' => 'percent_yield', 'fields' => ['actual', 'theoretical']]"
    :how-to="[
        ['name' => 'Enter both yields', 'text' => 'In the same unit.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate percent yield?', 'answer' => 'Actual ÷ theoretical × 100.'],
        ['question' => 'Can percent yield exceed 100%?', 'answer' => 'Only if the product is impure or still wet.'],
        ['question' => 'What is a good yield?', 'answer' => 'It depends on the reaction; above 90% is excellent for many syntheses.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="actual" label="Actual yield" value="30" min="0" />
        <x-calc.field name="theoretical" label="Theoretical yield" value="35.74" min="0" help="Same unit as actual" />
    </div>

    <x-calc.result label="Percent yield" />

    <x-calc.options :examples="[
        '30 of 35.74 g' => ['actual' => 30, 'theoretical' => 35.74],
        '8.5 of 10 g' => ['actual' => 8.5, 'theoretical' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lost' => ['label' => 'Shortfall'],
            'fraction' => ['label' => 'As a fraction'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% yield = actual ÷ theoretical × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
