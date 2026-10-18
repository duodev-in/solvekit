<x-calc.page
    title="Decking Calculator - SolveKit"
    description="Free decking calculator: deck boards, joists and screws or hidden clips for a deck from its size, board width and gap."
    lede="Work out the deck boards, joists and fasteners for a deck."
    about="Boards run along the deck length: rows = deck width ÷ (board width + gap), and each row needs length ÷ board length boards. Joists run across at the spacing you set. Each board gets two screws at every joist. A 5/4×6 or 2×6 deck board is 5½ in wide; ⅛–3/16 in gaps are typical for dry wood."
    :calc="['engine' => 'con-framing', 'tool' => 'decking', 'fields' => ['length', 'width', 'board_width', 'gap', 'board_length', 'joist_spacing', 'waste', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'board_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'gap' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'board_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'joist_spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the deck size', 'text' => 'Length is the direction the boards run.'],
        ['name' => 'Enter the board size and gap', 'text' => 'And the joist spacing.'],
    ]"
    :faqs="[
        ['question' => 'How many deck boards for a 16 × 12 deck?', 'answer' => 'With 5½ in boards and 3/16 in gaps: 26 rows of 16 ft boards, 28 with 5% extra.'],
        ['question' => 'How many screws per deck board?', 'answer' => 'Two at every joist: about 26 for a 16 ft board on 16 in joists.'],
        ['question' => 'What joist spacing for composite decking?', 'answer' => 'Usually 16 in on center, 12 in for diagonal boards; check the maker.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Deck length (along the boards)" value="16" min="0" placeholder="Deck length (along the boards)">
            <label for="calc-length-unit" class="sr-only">Deck length (along the boards) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Deck width" value="12" min="0" placeholder="Deck width">
            <label for="calc-width-unit" class="sr-only">Deck width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="board_width" label="Board width (actual)" value="5.5" min="0" placeholder="Board width (actual)">
            <label for="calc-board_width-unit" class="sr-only">Board width (actual) unit</label>
            <select id="calc-board_width-unit" name="board_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gap" label="Gap" value="0.1875" min="0" placeholder="Gap">
            <label for="calc-gap-unit" class="sr-only">Gap unit</label>
            <select id="calc-gap-unit" name="gap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="board_length" label="Board length" value="16" min="0" placeholder="Board length">
            <label for="calc-board_length-unit" class="sr-only">Board length unit</label>
            <select id="calc-board_length-unit" name="board_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="joist_spacing" label="Joist spacing" value="16" min="0" placeholder="Joist spacing">
            <label for="calc-joist_spacing-unit" class="sr-only">Joist spacing unit</label>
            <select id="calc-joist_spacing-unit" name="joist_spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra boards" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per board (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Deck boards" />

    <x-calc.options :examples="[
        '16 × 12 ft deck' => ['length' => 16, 'length-unit' => 'ft', 'width' => 12, 'width-unit' => 'ft', 'board_width' => 5.5, 'board_width-unit' => 'in', 'gap' => 0.1875, 'gap-unit' => 'in', 'board_length' => 16, 'board_length-unit' => 'ft', 'joist_spacing' => 16, 'joist_spacing-unit' => 'in', 'waste' => 5],
        '20 × 14 ft with 12 ft boards' => ['length' => 20, 'length-unit' => 'ft', 'width' => 14, 'width-unit' => 'ft', 'board_width' => 5.5, 'board_width-unit' => 'in', 'gap' => 0.125, 'gap-unit' => 'in', 'board_length' => 12, 'board_length-unit' => 'ft', 'joist_spacing' => 16, 'joist_spacing-unit' => 'in', 'waste' => 5],
        'Metric 5 × 4 m' => ['length' => 5, 'length-unit' => 'm', 'width' => 4, 'width-unit' => 'm', 'board_width' => 140, 'board_width-unit' => 'mm', 'gap' => 5, 'gap-unit' => 'mm', 'board_length' => 5.4, 'board_length-unit' => 'm', 'joist_spacing' => 400, 'joist_spacing-unit' => 'mm', 'waste' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'linear' => ['label' => 'Linear decking'],
            'joists' => ['label' => 'Joists'],
            'screws' => ['label' => 'Fasteners'],
            'area' => ['label' => 'Area'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rows = ⌈width ÷ (board + gap)⌉</li>
            <li>boards = rows × ⌈length ÷ board length⌉</li>
            <li>joists = ⌊length ÷ spacing⌋ + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
