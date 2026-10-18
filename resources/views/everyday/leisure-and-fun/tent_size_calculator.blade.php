<x-calc.page
    title="Tent Size Calculator - SolveKit"
    description="Free tent size calculator: what person rating of tent to buy for your group, gear and dog, with the floor area."
    lede="Choose the right size tent."
    about="Tent person ratings assume people lying shoulder to shoulder on standard pads, about 15 square feet each. Many campers buy one size up for comfort, gear or a dog. Check the tent's floor dimensions against your pads (standard 20 × 72 in, wide 25 in)."
    :calc="['engine' => 'ev-fun', 'tool' => 'tent', 'fields' => ['people', 'comfort', 'gear', 'dog', 'per_person']]"
    :how-to="[
        ['name' => 'Enter the people', 'text' => 'And how roomy you want it.'],
        ['name' => 'Add gear or a dog', 'text' => 'Each adds a place.'],
    ]"
    :faqs="[
        ['question' => 'What size tent for 2 people?', 'answer' => 'A 2-person tent is snug; a 3-person tent is roomier.'],
        ['question' => 'How much floor does a person need?', 'answer' => 'About 15 ft² on a standard pad.'],
        ['question' => 'Does a dog need space?', 'answer' => 'Count a medium dog as one more person.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="people" label="People sleeping" value="2" min="1" max="12" step="1" />
        <x-calc.select name="comfort" label="Comfort" :options="['snug' => 'Snug (backpacking)', 'roomy' => 'Roomy (car camping)']" selected="roomy" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="gear" label="Gear inside the tent" :checked="false" />
        <x-calc.checkbox name="dog" label="A dog" :checked="false" />
        <x-calc.field name="per_person" label="Floor per person" value="15" min="10" max="30" suffix="ft²" />
    </div>

    <x-calc.result label="Tent to buy" />

    <x-calc.options :decimals="false" :examples="[
        'Couple, car camping' => ['people' => 2, 'comfort' => 'roomy', 'gear' => false, 'dog' => false, 'per_person' => 15],
        'Family of 4 with gear' => ['people' => 4, 'comfort' => 'roomy', 'gear' => true, 'dog' => true, 'per_person' => 15],
        'Solo backpacker' => ['people' => 1, 'comfort' => 'snug', 'gear' => false, 'dog' => false, 'per_person' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Floor area'],
            'pad' => ['label' => 'Pads'],
            'note' => ['label' => 'Ratings'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rating = people + comfort + gear + dog</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
