<x-calc.page
    title="BBQ Grill Size Calculator - SolveKit"
    description="Free BBQ grill size calculator: how much grill space your burgers, hot dogs, chicken, steaks and corn need, and how many batches on your grill."
    lede="Find how much grill space your cookout needs."
    about="Each item needs its footprint plus room to turn it: about 25 in² for a burger, 12 for a hot dog, 20 for a chicken piece, 60 for a steak and 14 for an ear of corn (a convention, adjust to your food). A 22 in kettle grill has about 363 in² and a typical three-burner gas grill about 450 in² of main cooking area."
    :calc="['engine' => 'fd-party', 'tool' => 'grill', 'fields' => ['guests', 'grill_area', 'burgers', 'hotdogs', 'chicken', 'steaks', 'corn', 'kebabs']]"
    :how-to="[
        ['name' => 'Enter guests and food per guest', 'text' => ''],
        ['name' => 'Enter your grill area', 'text' => 'Width × depth of the grate.'],
    ]"
    :faqs="[
        ['question' => 'How much grill space for 12 guests with a burger, hot dog, half a chicken piece and corn each?', 'answer' => '732 in²: 3 batches on a 363 in² grill (0.47 m² in all).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="guests" label="Guests" value="12" min="0" step="1" />
        <x-calc.field name="grill_area" label="Your grill area" value="363" min="0" step="any" suffix="in²" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="burgers" label="Burgers each" value="1" min="0" step="any" />
        <x-calc.field name="hotdogs" label="Hot dogs each" value="1" min="0" step="any" />
        <x-calc.field name="chicken" label="Chicken pieces each" value="0.5" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="steaks" label="Steaks each" value="0" min="0" step="any" />
        <x-calc.field name="corn" label="Ears of corn each" value="1" min="0" step="any" />
        <x-calc.field name="kebabs" label="Kebabs each" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Grill space for everything at once" />

    <x-calc.options :decimals="false" :examples="[
        'Cookout' => ['guests' => 12, 'grill_area' => 363, 'burgers' => 1, 'hotdogs' => 1, 'chicken' => 0.5, 'steaks' => 0, 'corn' => 1, 'kebabs' => 0],
        'Steak night' => ['guests' => 6, 'grill_area' => 450, 'burgers' => 0, 'hotdogs' => 0, 'chicken' => 0, 'steaks' => 1, 'corn' => 1, 'kebabs' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'batches' => ['label' => 'Batches'],
            'kettle' => ['label' => '22 in kettle'],
            'gas' => ['label' => 'Gas grill'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>area = Σ items × footprint</li>
            <li>batches = area ÷ grill area</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
