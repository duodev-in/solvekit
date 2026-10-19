<x-calc.page
    title="Turkey Size Calculator - SolveKit"
    description="Free turkey size calculator: what size turkey to buy for your guests (USDA 1 lb a person, 1½ with leftovers), or a bone-in or boneless breast, with roasting and thawing times."
    lede="Find what size turkey to buy."
    about="USDA recommends about 1 lb of whole turkey per person (1½ lb for leftovers), ¾ lb of bone-in breast or ½ lb of boneless breast. Children count as half. Very large birds (over about 24 lb) roast unevenly; two smaller birds are often better."
    :calc="['engine' => 'fd-party', 'tool' => 'turkey_size', 'fields' => ['adults', 'kids', 'bird', 'leftovers'], 'data' => ['turkey' => config('food_data.turkey')]]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Choose the cut and leftovers', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What size turkey for 10 adults and 4 children?', 'answer' => '12 lb (5.44 kg).'],
        ['question' => 'With leftovers?', 'answer' => '18 lb (8.16 kg).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="10" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="4" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bird" label="Turkey" :options="['whole' => 'Whole turkey', 'breast' => 'Bone-in breast', 'boneless' => 'Boneless breast or roast']" selected="whole" />
        <x-calc.checkbox name="leftovers" label="Plan for leftovers" :checked="false" />
    </div>

    <x-calc.result label="Whole turkey to buy" />

    <x-calc.options :decimals="false" :examples="[
        '14 guests' => ['adults' => 10, 'kids' => 4, 'bird' => 'whole', 'leftovers' => false],
        'With leftovers' => ['adults' => 10, 'kids' => 4, 'bird' => 'whole', 'leftovers' => true],
        'Breast for 6' => ['adults' => 6, 'kids' => 0, 'bird' => 'breast', 'leftovers' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'roast' => ['label' => 'Roasting'],
            'thaw' => ['label' => 'Thawing'],
            'twoBirds' => ['label' => 'One bird or two'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = (adults + children ÷ 2) × lb per person</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
