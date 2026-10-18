<x-calc.page
    title="Framing Calculator - SolveKit"
    description="Free wall framing calculator: studs, plates, headers, precut stud length and board feet for a stud wall."
    lede="Work out the studs, plates and headers for a stud wall."
    about="Studs = wall length ÷ spacing + 1, plus a king and a jack stud each side of every opening and two extra per corner; the studs removed by an opening are reused as cripples. A wall has one bottom plate and a doubled top plate, so plates are three times the length. Precut stud length is the wall height less three 1½ in plates."
    :calc="['engine' => 'con-framing', 'tool' => 'framing', 'fields' => ['length', 'height', 'spacing', 'stud_size', 'corners', 'openings', 'opening_width', 'waste'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'opening_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the wall', 'text' => 'Length, height and stud spacing.'],
        ['name' => 'Add openings and corners', 'text' => 'Each adds studs.'],
    ]"
    :faqs="[
        ['question' => 'How many studs for a 20 ft wall?', 'answer' => '16 at 16 in on center; with two openings, two corners and 10% extra, 31.'],
        ['question' => 'What is a 92⅝ in stud?', 'answer' => 'The precut length for an 8 ft 1⅛ in wall with three 1½ in plates.'],
        ['question' => '16 or 24 in on center?', 'answer' => 'Both are allowed for most 2×6 walls; 2×4 bearing walls are usually 16 in (IRC Table R602.3(5)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Wall length" value="20" min="0" placeholder="Wall length">
            <label for="calc-length-unit" class="sr-only">Wall length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Wall height (to top of plates)" value="97.125" min="0" placeholder="Wall height (to top of plates)">
            <label for="calc-height-unit" class="sr-only">Wall height (to top of plates) unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spacing" label="Stud spacing" value="16" min="0" placeholder="Stud spacing">
            <label for="calc-spacing-unit" class="sr-only">Stud spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="stud_size" label="Studs" :options="['4' => '2×4', '6' => '2×6']" selected="4" />
        <x-calc.field name="corners" label="Corners" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="openings" label="Doors and windows" value="2" min="0" step="1" />
        <x-calc.field name="opening_width" label="Typical opening width" value="36" min="0" placeholder="Typical opening width">
            <label for="calc-opening_width-unit" class="sr-only">Typical opening width unit</label>
            <select id="calc-opening_width-unit" name="opening_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra studs" value="10" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Studs" />

    <x-calc.options :examples="[
        '20 ft wall, 2 openings' => ['length' => 20, 'length-unit' => 'ft', 'height' => 97.125, 'height-unit' => 'in', 'spacing' => 16, 'spacing-unit' => 'in', 'stud_size' => '4', 'corners' => 2, 'openings' => 2, 'opening_width' => 36, 'opening_width-unit' => 'in', 'waste' => 10],
        '2×6 at 24 in, 30 ft' => ['length' => 30, 'length-unit' => 'ft', 'height' => 97.125, 'height-unit' => 'in', 'spacing' => 24, 'spacing-unit' => 'in', 'stud_size' => '6', 'corners' => 2, 'openings' => 3, 'opening_width' => 48, 'opening_width-unit' => 'in', 'waste' => 10],
        'Metric 6 m wall' => ['length' => 6, 'length-unit' => 'm', 'height' => 2.4, 'height-unit' => 'm', 'spacing' => 400, 'spacing-unit' => 'mm', 'stud_size' => '4', 'corners' => 0, 'openings' => 1, 'opening_width' => 900, 'opening_width-unit' => 'mm', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'plates' => ['label' => 'Plates'],
            'headers' => ['label' => 'Headers'],
            'stud_length' => ['label' => 'Stud length'],
            'board_feet' => ['label' => 'Board feet'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>studs = ⌊L ÷ spacing⌋ + 1 + 4 × openings + 2 × corners</li>
            <li>plates = 3 × L</li>
            <li>stud = height − 3 × 1½ in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
