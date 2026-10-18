<x-calc.page
    title="Carpet Calculator - SolveKit"
    description="Free carpet calculator: square yards of carpet to buy from a 12 or 15 ft roll for several rooms, with seams, pad and cost."
    lede="Work out how much carpet to buy from a roll."
    about="Carpet comes off a roll of fixed width (usually 12 ft, sometimes 13.5 or 15 ft, or 4 m). Each room is covered in strips laid along its longer side; you pay for every strip cut, so the purchase is often more than the floor area. A few inches extra on each strip lets the installer trim to the walls."
    :calc="['engine' => 'con-finish', 'tool' => 'carpet', 'fields' => ['rooms', 'rooms_unit', 'roll', 'trim', 'price'], 'unitFields' => ['roll' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'trim' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'rowUnits' => ['rooms' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each room', 'text' => 'Length and width.'],
        ['name' => 'Set the roll width', 'text' => '12 ft is standard.'],
    ]"
    :faqs="[
        ['question' => 'How many square yards for a 12 × 14 room?', 'answer' => 'With a 12 ft roll: one strip 14 ft 3 in long, 19 yd².'],
        ['question' => 'Why is there waste?', 'answer' => 'A roll is a fixed width, so narrow strips leave offcuts.'],
        ['question' => 'How much pad do I need?', 'answer' => 'The floor area itself, since pad is cut to the room.'],
    ]"
>
    <x-calc.rows-editor name="rooms" label="Rooms" :columns="['length' => 'Length', 'width' => 'Width']" :rows="[[12, 14], [10, 12]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add room" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="roll" label="Roll width" value="12" min="0" placeholder="Roll width">
            <label for="calc-roll-unit" class="sr-only">Roll width unit</label>
            <select id="calc-roll-unit" name="roll-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="trim" label="Extra per strip for trimming" value="3" min="0" placeholder="Extra per strip for trimming">
            <label for="calc-trim-unit" class="sr-only">Extra per strip for trimming unit</label>
            <select id="calc-trim-unit" name="trim-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per yd² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Carpet to buy" />

    <x-calc.options :examples="[
        'Two rooms, 12 ft roll' => ['rooms' => '12 14
10 12', 'rooms_unit' => 'ft', 'roll' => 12, 'roll-unit' => 'ft', 'trim' => 3, 'trim-unit' => 'in'],
        'Wide room, 15 ft roll' => ['rooms' => '20 14', 'rooms_unit' => 'ft', 'roll' => 15, 'roll-unit' => 'ft', 'trim' => 3, 'trim-unit' => 'in', 'price' => 28],
        'Metric 4 m roll' => ['rooms' => '5 4.5
3.5 3', 'rooms_unit' => 'm', 'roll' => 4, 'roll-unit' => 'm', 'trim' => 75, 'trim-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'floor' => ['label' => 'Floor area'],
            'waste' => ['label' => 'Offcut'],
            'pad' => ['label' => 'Pad'],
            'seams' => ['label' => 'Seams'],
            'cost' => ['label' => 'Cost'],
        ]" />
        <x-calc.quick-ref heading="Each room" name="rooms" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>strips = ⌈shorter side ÷ roll width⌉</li>
            <li>carpet = strips × (longer side + trim) × roll width</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
