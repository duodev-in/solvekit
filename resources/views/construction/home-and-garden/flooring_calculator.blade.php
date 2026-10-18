<x-calc.page
    title="Flooring Calculator - SolveKit"
    description="Free flooring calculator: square feet and boxes of laminate, vinyl plank, hardwood or engineered flooring for several rooms, with waste."
    lede="Work out how many boxes of flooring you need."
    about="Floor area is the sum of the rooms; add 5–10% for cuts (more for diagonal layouts or many angles), then divide by the coverage printed on the box."
    :calc="['engine' => 'con-finish', 'tool' => 'flooring', 'fields' => ['rooms', 'rooms_unit', 'waste', 'box', 'price'], 'unitFields' => ['box' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'rowUnits' => ['rooms' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each room', 'text' => 'Split L-shaped rooms into rectangles.'],
        ['name' => 'Enter the box coverage', 'text' => 'From the box label.'],
    ]"
    :faqs="[
        ['question' => 'How much extra flooring should I buy?', 'answer' => '5–10% for straight layouts, 15% for diagonal or herringbone.'],
        ['question' => 'How many boxes for 300 ft²?', 'answer' => '17 boxes of 20 ft² with 10% extra.'],
        ['question' => 'Do I measure into closets?', 'answer' => 'Yes, and to the middle of door openings.'],
    ]"
>
    <x-calc.rows-editor name="rooms" label="Rooms" :columns="['length' => 'Length', 'width' => 'Width']" :rows="[[12, 14], [10, 12]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add room" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="waste" label="Extra for cuts" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="box" label="Coverage per box" value="20" min="0" placeholder="Coverage per box">
            <label for="calc-box-unit" class="sr-only">Coverage per box unit</label>
            <select id="calc-box-unit" name="box-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per ft² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Flooring needed" />

    <x-calc.options :examples="[
        'Two rooms' => ['rooms' => '12 14
10 12', 'rooms_unit' => 'ft', 'waste' => 10, 'box' => 20, 'box-unit' => 'ft2'],
        'Open plan 6 × 5 m' => ['rooms' => '6 5', 'rooms_unit' => 'm', 'waste' => 8, 'box' => 2.2, 'box-unit' => 'm2', 'price' => 3.5],
        'Herringbone 15%' => ['rooms' => '15 12', 'rooms_unit' => 'ft', 'waste' => 15, 'box' => 18.5, 'box-unit' => 'ft2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Floor area'],
            'with_waste' => ['label' => 'With waste'],
            'boxes' => ['label' => 'Boxes'],
            'cost' => ['label' => 'Cost'],
        ]" />
        <x-calc.quick-ref heading="Each room" name="rooms" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>boxes = Σ room areas × (1 + waste) ÷ coverage per box</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
