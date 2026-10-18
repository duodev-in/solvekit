<x-calc.page
    title="Cost of Having a Baby Calculator - SolveKit"
    description="Free cost of having a baby calculator: a first-year budget for a new baby from your own figures for birth costs, diapers, feeding, childcare and gear."
    lede="Plan your baby's first-year budget."
    about="Costs vary enormously with country, insurance, childcare and choices, so this is a planner built from your own figures. List each cost with the number of months it applies (1 for one-off costs such as a crib or hospital bill). The example figures are placeholders to edit."
    :calc="['engine' => 'ev-care', 'tool' => 'baby_cost', 'fields' => ['items']]"
    :how-to="[
        ['name' => 'List your costs', 'text' => 'Monthly costs with 12 months; one-offs with 1.'],
        ['name' => 'Edit the examples', 'text' => 'They are placeholders.'],
    ]"
    :faqs="[
        ['question' => 'How much does a baby cost in the first year?', 'answer' => 'It depends heavily on childcare and insurance; enter your own figures.'],
        ['question' => 'What is usually the biggest cost?', 'answer' => 'Childcare, where it is used.'],
        ['question' => 'Should I include parental leave?', 'answer' => 'Add lost income as a line if it applies.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Budget" :columns="['name' => 'Item', 'cost' => 'Cost $', 'months' => 'Months']" :rows="[['Hospital bill (after insurance)', 3000, 1], ['Diapers and wipes', 80, 12], ['Formula or feeding', 150, 12], ['Childcare', 1200, 6], ['Clothes', 50, 12], ['Crib, car seat, stroller', 900, 1]]" add-label="Add cost" :text="['name']" />

    <x-calc.result label="First-year cost" />

    <x-calc.options :decimals="false" :examples="[
        'With childcare' => ['items' => 'Hospital bill (after insurance)	3000	1
Diapers and wipes	80	12
Formula or feeding	150	12
Childcare	1200	6
Clothes	50	12
Crib, car seat, stroller	900	1'],
        'Breastfeeding, family care' => ['items' => 'Hospital bill (after insurance)	1500	1
Diapers and wipes	70	12
Clothes	40	12
Second-hand gear	300	1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'month' => ['label' => 'Per month'],
            'biggest' => ['label' => 'Biggest cost'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="Budget lines" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = Σ cost × months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
