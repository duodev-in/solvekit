<x-calc.page
    title="Thanksgiving Calculator - SolveKit"
    description="Free Thanksgiving calculator: how much turkey, stuffing, potatoes, gravy, cranberry sauce, vegetables, rolls and pie to buy for your guests, with or without leftovers."
    lede="Plan how much food to make for Thanksgiving."
    about="USDA suggests about 1 lb of whole turkey per person, or 1½ lb if you want leftovers. The other amounts are common catering portions per adult: ¾ cup of stuffing, ½ lb of potatoes, ⅓ cup of gravy, ¼ cup of cranberry sauce, ¼ lb of vegetables, 1½ rolls and a slice of pie. Children count as half an adult. Adjust for your crowd's appetite."
    :calc="['engine' => 'fd-party', 'tool' => 'thanksgiving', 'fields' => ['adults', 'kids', 'appetite', 'leftovers']]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Choose appetite and leftovers', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much food for 10 adults and 4 children?', 'answer' => 'Turkey 12 lb (5.44 kg); the full list is in the table.'],
        ['question' => 'And with leftovers?', 'answer' => 'Turkey 18 lb (8.16 kg).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="10" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="4" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="appetite" label="Appetite" :options="['light' => 'Light', 'normal' => 'Average', 'hearty' => 'Hearty']" selected="normal" />
        <x-calc.checkbox name="leftovers" label="Plan for leftovers" :checked="false" />
    </div>

    <x-calc.result label="Turkey" />

    <x-calc.options :decimals="false" :examples="[
        'Dinner for 14' => ['adults' => 10, 'kids' => 4, 'appetite' => 'normal', 'leftovers' => false],
        'With leftovers' => ['adults' => 10, 'kids' => 4, 'appetite' => 'normal', 'leftovers' => true],
        'Small table' => ['adults' => 4, 'kids' => 0, 'appetite' => 'hearty', 'leftovers' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'people' => ['label' => 'Adult portions'],
            'roast' => ['label' => 'Roasting'],
            'basis' => ['label' => 'Basis'],
        ]" />
        <x-calc.grid heading="Shopping list" name="list" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turkey = 1 lb × (adults + children ÷ 2)</li>
            <li>other items = portion × adult portions × appetite</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
