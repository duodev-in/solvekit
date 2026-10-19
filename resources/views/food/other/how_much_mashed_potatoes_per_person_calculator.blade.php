<x-calc.page
    title="How Much Mashed Potatoes Per Person Calculator - SolveKit"
    description="Free mashed potatoes calculator: how many pounds of potatoes to buy per person for a side or main, with the butter, milk and salt and how many cups it makes."
    lede="Find how many potatoes to mash for your guests."
    about="Plan about ½ lb (225 g) of raw potatoes per adult as a side and ¾ lb as a main (children half). A classic mash uses 2 tablespoons of butter, ¼ cup of milk and ½ teaspoon of salt per pound. Peeling loses about 15%; a cup of mashed potatoes weighs 210 g (USDA)."
    :calc="['engine' => 'fd-other', 'tool' => 'mashed', 'fields' => ['adults', 'kids', 'role', 'appetite'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Choose side or main and appetite', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many potatoes for 10 adults and 2 children?', 'answer' => '5.5 lb (2.49 kg for 11 adult portions as a side; about 12½ cups (12.4) mashed).'],
        ['question' => 'How much butter?', 'answer' => '11 tbsp (156 g).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="10" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="role" label="Served as" :options="['side' => 'A side', 'main' => 'A main part of the meal']" selected="side" />
        <x-calc.select name="appetite" label="Appetite" :options="['light' => 'Light', 'normal' => 'Average', 'hearty' => 'Hearty']" selected="normal" />
    </div>

    <x-calc.result label="Potatoes (raw, unpeeled)" />

    <x-calc.options :decimals="false" :examples="[
        'Holiday side' => ['adults' => 10, 'kids' => 2, 'role' => 'side', 'appetite' => 'normal'],
        'Main for 4' => ['adults' => 4, 'kids' => 0, 'role' => 'main', 'appetite' => 'hearty'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'butter' => ['label' => 'Butter'],
            'milk' => ['label' => 'Milk'],
            'salt' => ['label' => 'Salt'],
            'servings' => ['label' => 'Servings'],
            'type' => ['label' => 'Potatoes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>potatoes = ½ lb × adult portions × appetite</li>
            <li>per lb: 2 tbsp butter, ¼ cup milk</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
