<x-calc.page
    title="Board and Batten Calculator - SolveKit"
    description="Free board and batten calculator: number of vertical boards and battens for walls, with linear feet."
    lede="Work out the boards and battens for board-and-batten siding or paneling."
    about="Wide boards run vertically with a small gap, and a batten covers each joint. Boards per wall = wall length ÷ (board width + gap); battens = boards − 1. Each piece runs the full wall height. The batten must be at least twice the gap wide."
    :calc="['engine' => 'con-finish', 'tool' => 'board_and_batten', 'fields' => ['walls', 'walls_unit', 'board_width', 'gap', 'batten_width', 'waste'], 'unitFields' => ['board_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'gap' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'batten_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each wall', 'text' => 'Length and height.'],
        ['name' => 'Enter the board and batten widths', 'text' => 'Actual sizes.'],
    ]"
    :faqs="[
        ['question' => 'How many boards for a 12 ft wall?', 'answer' => 'With 1×10 boards (9¼ in) and ½ in gaps: 15 boards and 14 battens before waste.'],
        ['question' => 'How wide should the gap be?', 'answer' => 'Usually ½ in, covered by a 2½–3½ in batten.'],
        ['question' => 'Can I do battens only?', 'answer' => 'For interior accent walls, battens over drywall are common; enter the batten spacing as the board width.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[12, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="board_width" label="Board width (actual)" value="9.25" min="0" placeholder="Board width (actual)">
            <label for="calc-board_width-unit" class="sr-only">Board width (actual) unit</label>
            <select id="calc-board_width-unit" name="board_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gap" label="Gap between boards" value="0.5" min="0" placeholder="Gap between boards">
            <label for="calc-gap-unit" class="sr-only">Gap between boards unit</label>
            <select id="calc-gap-unit" name="gap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="batten_width" label="Batten width (actual)" value="2.5" min="0" placeholder="Batten width (actual)">
            <label for="calc-batten_width-unit" class="sr-only">Batten width (actual) unit</label>
            <select id="calc-batten_width-unit" name="batten_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />

    <x-calc.result label="Boards" />

    <x-calc.options :examples="[
        'Wall 12 × 8 ft' => ['walls' => '12 8', 'walls_unit' => 'ft', 'board_width' => 9.25, 'board_width-unit' => 'in', 'gap' => 0.5, 'gap-unit' => 'in', 'batten_width' => 2.5, 'batten_width-unit' => 'in', 'waste' => 10],
        'Shed 4 walls' => ['walls' => '10 7
8 7
10 7
8 7', 'walls_unit' => 'ft', 'board_width' => 11.25, 'board_width-unit' => 'in', 'gap' => 0.5, 'gap-unit' => 'in', 'batten_width' => 3.5, 'batten_width-unit' => 'in', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'battens' => ['label' => 'Battens'],
            'board_ft' => ['label' => 'Board length'],
            'batten_ft' => ['label' => 'Batten length'],
            'area' => ['label' => 'Wall area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>boards = ⌈wall length ÷ (board + gap)⌉</li>
            <li>battens = boards − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
