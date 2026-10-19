<x-calc.page
    title="How Much Ham per Person Calculator - SolveKit"
    description="Free ham per person calculator: how big a ham to buy for your guests (USDA ¼–⅓ lb boneless, ½–¾ lb bone-in per person), with the reheating time."
    lede="Find how much ham to buy."
    about="USDA suggests ¼ to ⅓ lb of boneless ham per person, or ½ to ¾ lb of bone-in ham (spiral-cut hams are bone-in). The larger amount allows for hearty eaters and leftovers. Fully cooked hams are reheated at 325 °F to 140 °F (FSIS chart)."
    :calc="['engine' => 'fd-party', 'tool' => 'ham_person', 'fields' => ['adults', 'kids', 'bone', 'leftovers'], 'data' => ['ham' => config('food_data.ham')]]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Choose the ham', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much spiral ham for 12 adults and 4 children?', 'answer' => '7 lb (3.18 kg).'],
        ['question' => 'Boneless with leftovers?', 'answer' => '4.67 lb (2.12 kg).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="12" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="4" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bone" label="Ham" :options="['bone-in' => 'Bone-in', 'spiral' => 'Spiral-cut (bone-in)', 'boneless' => 'Boneless']" selected="spiral" />
        <x-calc.checkbox name="leftovers" label="Plan for leftovers" :checked="false" />
    </div>

    <x-calc.result label="Ham to buy" />

    <x-calc.options :decimals="false" :examples="[
        'Easter' => ['adults' => 12, 'kids' => 4, 'bone' => 'spiral', 'leftovers' => false],
        'Boneless' => ['adults' => 12, 'kids' => 4, 'bone' => 'boneless', 'leftovers' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'servings' => ['label' => 'Portions'],
            'reheat' => ['label' => 'Reheating'],
            'note' => ['label' => 'Fresh ham'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ham = adult portions × lb per person</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
