<x-calc.page
    title="Shiplap Calculator - SolveKit"
    description="Free shiplap calculator: shiplap boards and linear feet for walls from the board's face width and length, less openings."
    lede="Work out the shiplap boards for a wall."
    about="Shiplap boards overlap, so only the face (exposed) width counts: a 1×6 shiplap board covers about 5⅛ in, a 1×8 about 6⅞ in; check your board. Linear feet = net area ÷ face width; boards = linear feet ÷ board length. Add 10–15% for cuts."
    :calc="['engine' => 'con-finish', 'tool' => 'boards', 'fields' => ['walls', 'walls_unit', 'openings', 'openings_unit', 'exposure', 'board_length', 'waste', 'price'], 'unitFields' => ['exposure' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'board_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Add doors and windows', 'text' => 'Width, height and how many.'],
        ['name' => 'Enter the board size', 'text' => 'Face width and length.'],
    ]"
    :faqs="[
        ['question' => 'How many shiplap boards for a 12 × 8 wall?', 'answer' => 'About 31 boards of 8 ft at a 5⅛ in face, with 10% waste.'],
        ['question' => 'What is face width?', 'answer' => 'The part that shows once the boards overlap.'],
        ['question' => 'Should shiplap run horizontally?', 'answer' => 'Horizontal is traditional; vertical works too, with blocking for nailing.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[12, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 4, 1]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="exposure" label="Face (exposed) width" value="5.125" min="0" placeholder="Face (exposed) width">
            <label for="calc-exposure-unit" class="sr-only">Face (exposed) width unit</label>
            <select id="calc-exposure-unit" name="exposure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="board_length" label="Board length" value="8" min="0" placeholder="Board length">
            <label for="calc-board_length-unit" class="sr-only">Board length unit</label>
            <select id="calc-board_length-unit" name="board_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for cuts" value="10" min="0" max="100" suffix="%" />
    </div>

    <x-calc.field name="price" label="Price per board (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Boards needed" />

    <x-calc.options :examples="[
        'Accent wall 12 × 8 ft' => ['walls' => '12 8', 'walls_unit' => 'ft', 'openings' => '', 'exposure' => 5.125, 'exposure-unit' => 'in', 'board_length' => 8, 'board_length-unit' => 'ft', 'waste' => 10],
        'Room with window' => ['walls' => '12 8
14 8
12 8
14 8', 'walls_unit' => 'ft', 'openings' => '3 4 1', 'openings_unit' => 'ft', 'exposure' => 6.875, 'exposure-unit' => 'in', 'board_length' => 12, 'board_length-unit' => 'ft', 'waste' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'linear' => ['label' => 'Linear length'],
            'area' => ['label' => 'Area'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>linear = net area ÷ face width × (1 + waste)</li>
            <li>boards = linear ÷ board length</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
