<x-calc.page
    title="Wainscoting Calculator - SolveKit"
    description="Free wainscoting calculator: beadboard or wainscot panels, chair rail and baseboard for a room from wall lengths and wainscot height."
    lede="Work out the wainscot panels and trim for a room."
    about="Wainscot panels (such as 4 × 8 ft beadboard sheets) are cut to the wainscot height: a 32 in wainscot gets three pieces from an 8 ft sheet. Pieces = run ÷ panel width; panels = pieces ÷ pieces per panel. Chair rail and baseboard run the full length less doors."
    :calc="['engine' => 'con-finish', 'tool' => 'wainscoting', 'fields' => ['walls', 'walls_unit', 'height', 'panel_width', 'panel_height', 'doors', 'door_width', 'waste', 'price'], 'unitFields' => ['height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'panel_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'panel_height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'door_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'List the wall lengths', 'text' => 'Around the room.'],
        ['name' => 'Set the height and panel', 'text' => 'And subtract doors.'],
    ]"
    :faqs="[
        ['question' => 'What height should wainscoting be?', 'answer' => 'About a third of the wall: 32–36 in on an 8 ft wall.'],
        ['question' => 'How many beadboard sheets for a 12 × 14 room?', 'answer' => '5 sheets of 4 × 8 at 32 in high with one door and 10% waste.'],
        ['question' => 'What is chair rail?', 'answer' => 'The molding along the top of the wainscot.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Wall lengths" :columns="['length' => 'Length']" :rows="[[12], [14], [12], [14]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Wainscot height" value="32" min="0" placeholder="Wainscot height">
            <label for="calc-height-unit" class="sr-only">Wainscot height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="panel_width" label="Panel width" value="4" min="0" placeholder="Panel width">
            <label for="calc-panel_width-unit" class="sr-only">Panel width unit</label>
            <select id="calc-panel_width-unit" name="panel_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="panel_height" label="Panel length" value="8" min="0" placeholder="Panel length">
            <label for="calc-panel_height-unit" class="sr-only">Panel length unit</label>
            <select id="calc-panel_height-unit" name="panel_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="doors" label="Doors" value="1" min="0" step="1" />
        <x-calc.field name="door_width" label="Door width" value="36" min="0" placeholder="Door width">
            <label for="calc-door_width-unit" class="sr-only">Door width unit</label>
            <select id="calc-door_width-unit" name="door_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per panel (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Panels" />

    <x-calc.options :examples="[
        '12 × 14 room, 32 in' => ['walls' => '12
14
12
14', 'walls_unit' => 'ft', 'height' => 32, 'height-unit' => 'in', 'panel_width' => 4, 'panel_width-unit' => 'ft', 'panel_height' => 8, 'panel_height-unit' => 'ft', 'doors' => 1, 'door_width' => 36, 'door_width-unit' => 'in', 'waste' => 10],
        'Hallway 1 m high' => ['walls' => '6
6', 'walls_unit' => 'm', 'height' => 1, 'height-unit' => 'm', 'panel_width' => 1.22, 'panel_width-unit' => 'm', 'panel_height' => 2.44, 'panel_height-unit' => 'm', 'doors' => 2, 'door_width' => 0.9, 'door_width-unit' => 'm', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'run' => ['label' => 'Wall run'],
            'area' => ['label' => 'Area'],
            'trim' => ['label' => 'Trim'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pieces = ⌈run ÷ panel width⌉</li>
            <li>panels = ⌈pieces ÷ ⌊panel length ÷ height⌋⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
