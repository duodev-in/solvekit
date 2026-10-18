<x-calc.page
    title="How Many Tables Calculator - SolveKit"
    description="Free how many tables calculator: tables and chairs needed for a party, wedding or banquet by table size, and the floor space to seat everyone."
    lede="Work out how many tables you need for your guests."
    about="Tables = guests ÷ seats per table, rounded up. Caterers seat 8 at a 60-inch round, 10 at a 72-inch round, 6 at a 6-ft rectangle (8 with ends) and 8 at an 8-ft rectangle (10 with ends). Banquet seating needs about 10–12 square feet per guest including aisles."
    :calc="['engine' => 'ev-home', 'tool' => 'tables', 'fields' => ['guests', 'table', 'seats', 'space']]"
    :how-to="[
        ['name' => 'Enter guests and table type', 'text' => 'Seats per table are filled in.'],
        ['name' => 'Check the floor space', 'text' => 'For the room.'],
    ]"
    :faqs="[
        ['question' => 'How many 60-inch round tables for 120 guests?', 'answer' => '15 tables of 8.'],
        ['question' => 'How many people fit at a 72-inch round?', 'answer' => 'About 10 (up to 12 tightly).'],
        ['question' => 'How much space for a banquet of 100?', 'answer' => 'About 1,000–1,200 ft².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="guests" label="Guests" value="120" min="1" step="1" />
        <x-calc.select name="table" label="Table" :options="['round48' => '48 in round (6)', 'round60' => '60 in round (8)', 'round72' => '72 in round (10)', 'rect6' => '6 ft rectangle (6)', 'rect6_ends' => '6 ft rectangle with ends (8)', 'rect8' => '8 ft rectangle (8)', 'rect8_ends' => '8 ft rectangle with ends (10)']" selected="round60" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="seats" label="Seats per table (override)" value="" min="1" step="1" placeholder="Use the table's" />
        <x-calc.field name="space" label="Floor space per guest" value="12" min="6" max="25" suffix="ft²" />
    </div>

    <x-calc.result label="Tables needed" />

    <x-calc.options :decimals="false" :examples="[
        '120 guests, 60 in rounds' => ['guests' => 120, 'table' => 'round60', 'seats' => '', 'space' => 12],
        '75 guests, 8 ft tables' => ['guests' => 75, 'table' => 'rect8', 'seats' => '', 'space' => 10],
        'Wedding of 200, 72 in' => ['guests' => 200, 'table' => 'round72', 'seats' => '', 'space' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'empty' => ['label' => 'Spare seats'],
            'area' => ['label' => 'Floor space'],
            'chairs' => ['label' => 'Chairs'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tables = ⌈guests ÷ seats per table⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
