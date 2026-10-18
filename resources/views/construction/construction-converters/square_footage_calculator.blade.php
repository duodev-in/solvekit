<x-calc.page
    title="Square Footage Calculator - SolveKit"
    description="Free square footage calculator: total square feet of several rooms or areas, in ft², m², yd² and acres, with cost per square foot."
    lede="Add up the square footage of rooms or areas."
    about="Square footage is length × width for each rectangular area. Add a row for each room or section (an L-shaped room is two rectangles) and the calculator totals them. For circles and other shapes use the Square Yards Calculator."
    :calc="['engine' => 'con-area', 'tool' => 'square_footage', 'fields' => ['rooms', 'rooms_unit', 'waste', 'price'], 'rowUnits' => ['rooms' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each area', 'text' => 'Length and width, with a count for repeats.'],
        ['name' => 'Add extra if needed', 'text' => 'For flooring waste, for example.'],
    ]"
    :faqs="[
        ['question' => 'How do I work out square footage?', 'answer' => 'Multiply length by width in feet; add up every area.'],
        ['question' => 'How do I measure an L-shaped room?', 'answer' => 'Split it into two rectangles and enter both.'],
        ['question' => 'How many square feet in an acre?', 'answer' => '43,560.'],
    ]"
>
    <x-calc.rows-editor name="rooms" label="Areas" :columns="['length' => 'Length', 'width' => 'Width', 'count' => 'Count']" :rows="[[12, 14, 1], [10, 12, 2], [8, 6, 1]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add area" help="Count repeats an identical area" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra (optional)" value="" min="0" max="100" suffix="%" placeholder="0" />
        <x-calc.field name="price" label="Price per ft² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Total area" />

    <x-calc.options :examples="[
        'Three rooms' => ['rooms' => '12 14 1
10 12 2
8 6 1', 'rooms_unit' => 'ft'],
        'One room 5 × 4 m' => ['rooms' => '5 4 1', 'rooms_unit' => 'm'],
        'Flooring with 10%' => ['rooms' => '15 12 1
11 9 1', 'rooms_unit' => 'ft', 'waste' => 10, 'price' => 4.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'm2' => ['label' => 'Square meters'],
            'yd2' => ['label' => 'Square yards'],
            'acres' => ['label' => 'Acres'],
            'cost' => ['label' => 'Cost'],
        ]" />
        <x-calc.quick-ref heading="Each area" name="areas" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>area = length × width</li>
            <li>total = Σ areas × (1 + extra)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
