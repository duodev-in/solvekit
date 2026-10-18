<x-calc.page
    title="Rafter Length Calculator - SolveKit"
    description="Free rafter length calculator: common rafter length from span and pitch, with overhang, ridge board deduction and cut angles."
    lede="Work out the length of a common rafter."
    about="Run = half the span less half the ridge board. Rafter line length = run × √(1 + (pitch ÷ 12)²); the overhang tail adds overhang × the same factor. Plumb cuts are the roof angle from square."
    :calc="['engine' => 'con-roof', 'tool' => 'rafter_length', 'fields' => ['span', 'pitch', 'overhang', 'ridge', 'depth'], 'unitFields' => ['span' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'overhang' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'ridge' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the span and pitch', 'text' => 'Span is outside wall to outside wall.'],
        ['name' => 'Add the overhang and ridge', 'text' => 'The ridge board shortens each rafter.'],
    ]"
    :faqs="[
        ['question' => 'How long is a rafter for a 24 ft span at 6/12?', 'answer' => '14 ft 5 9/16 in with a 12 in overhang and a 1½ in ridge board.'],
        ['question' => 'What is the plumb cut angle for 6/12?', 'answer' => '26.57° from square.'],
        ['question' => 'Why subtract half the ridge?', 'answer' => 'The rafters meet the faces of the ridge board, not the center line.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Building span (outside of walls)" value="24" min="0" placeholder="Building span (outside of walls)">
            <label for="calc-span-unit" class="sr-only">Building span (outside of walls) unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pitch" label="Pitch (rise per 12)" value="6" min="0" step="0.5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="overhang" label="Overhang (horizontal)" value="12" min="0" placeholder="Overhang (horizontal)">
            <label for="calc-overhang-unit" class="sr-only">Overhang (horizontal) unit</label>
            <select id="calc-overhang-unit" name="overhang-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ridge" label="Ridge board thickness" value="1.5" min="0" placeholder="Ridge board thickness">
            <label for="calc-ridge-unit" class="sr-only">Ridge board thickness unit</label>
            <select id="calc-ridge-unit" name="ridge-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Rafter depth (actual)" value="7.25" min="0" placeholder="Rafter depth (actual)">
            <label for="calc-depth-unit" class="sr-only">Rafter depth (actual) unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Rafter length" />

    <x-calc.options :examples="[
        '24 ft span, 6/12' => ['span' => 24, 'span-unit' => 'ft', 'pitch' => 6, 'overhang' => 12, 'overhang-unit' => 'in', 'ridge' => 1.5, 'ridge-unit' => 'in', 'depth' => 7.25, 'depth-unit' => 'in'],
        '30 ft span, 8/12' => ['span' => 30, 'span-unit' => 'ft', 'pitch' => 8, 'overhang' => 18, 'overhang-unit' => 'in', 'ridge' => 1.5, 'ridge-unit' => 'in', 'depth' => 9.25, 'depth-unit' => 'in'],
        'Metric 8 m, 35°' => ['span' => 8, 'span-unit' => 'm', 'pitch' => 8.4, 'overhang' => 400, 'overhang-unit' => 'mm', 'ridge' => 45, 'ridge-unit' => 'mm', 'depth' => 195, 'depth-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'line' => ['label' => 'To the wall'],
            'tail' => ['label' => 'Tail'],
            'rise' => ['label' => 'Rise'],
            'cuts' => ['label' => 'Cuts'],
            'stock' => ['label' => 'Board length'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>run = span ÷ 2 − ridge ÷ 2</li>
            <li>rafter = (run + overhang) × √(1 + (pitch ÷ 12)²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
