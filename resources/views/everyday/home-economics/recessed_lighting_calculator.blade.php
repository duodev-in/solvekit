<x-calc.page
    title="Recessed Lighting Calculator - SolveKit"
    description="Free recessed lighting calculator: how many can lights a room needs, their spacing and distance from the walls, from room size and ceiling height."
    lede="Lay out recessed lights evenly in a room."
    about="A common rule of thumb spaces recessed lights about half the ceiling height apart (4 ft apart for an 8 ft ceiling), with the outer lights half that from the walls. The room is divided into an even grid. Wider-beam fixtures can go further apart; check the maker's spacing guide."
    :calc="['engine' => 'ev-home', 'tool' => 'recessed', 'fields' => ['length', 'width', 'ceiling'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'ceiling' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the room size', 'text' => 'Length and width.'],
        ['name' => 'Enter the ceiling height', 'text' => 'It sets the spacing.'],
    ]"
    :faqs="[
        ['question' => 'How many recessed lights for a 16 × 12 ft room?', 'answer' => '12, in 4 rows of 3 with an 8 ft ceiling.'],
        ['question' => 'How far apart should recessed lights be?', 'answer' => 'About half the ceiling height.'],
        ['question' => 'How far from the wall?', 'answer' => 'About half the spacing, often 2–3 ft.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Room length" value="16" min="0" placeholder="Room length">
            <label for="calc-length-unit" class="sr-only">Room length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Room width" value="12" min="0" placeholder="Room width">
            <label for="calc-width-unit" class="sr-only">Room width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ceiling" label="Ceiling height" value="8" min="0" placeholder="Ceiling height">
            <label for="calc-ceiling-unit" class="sr-only">Ceiling height unit</label>
            <select id="calc-ceiling-unit" name="ceiling-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Recessed lights" />

    <x-calc.options :examples="[
        '16 × 12 ft, 8 ft ceiling' => ['length' => 16, 'length-unit' => 'ft', 'width' => 12, 'width-unit' => 'ft', 'ceiling' => 8, 'ceiling-unit' => 'ft'],
        'Kitchen 14 × 10, 9 ft' => ['length' => 14, 'length-unit' => 'ft', 'width' => 10, 'width-unit' => 'ft', 'ceiling' => 9, 'ceiling-unit' => 'ft'],
        '5 × 4 m, 2.6 m' => ['length' => 5, 'length-unit' => 'm', 'width' => 4, 'width-unit' => 'm', 'ceiling' => 2.6, 'ceiling-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'spacing' => ['label' => 'Spacing'],
            'edge' => ['label' => 'From the walls'],
            'rule' => ['label' => 'Rule of thumb'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>spacing ≈ ceiling height ÷ 2</li>
            <li>edge distance ≈ spacing ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
