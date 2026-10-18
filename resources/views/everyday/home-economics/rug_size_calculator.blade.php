<x-calc.page
    title="Rug Size Calculator - SolveKit"
    description="Free rug size calculator: the largest standard rug for a room that leaves a border of floor showing, in feet or centimeters."
    lede="Find the right rug size for your room."
    about="A room-size rug usually leaves 12–18 inches (30–45 cm) of floor showing on every side. The calculator subtracts that border and picks the largest standard size that fits: 5 × 8, 6 × 9, 8 × 10, 9 × 12 ft and so on, or common metric sizes."
    :calc="['engine' => 'ev-home', 'tool' => 'rug', 'fields' => ['length', 'width', 'border', 'system'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'border' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['rugs' => config('everyday_data.rugs')]]"
    :how-to="[
        ['name' => 'Enter the room', 'text' => 'Length and width.'],
        ['name' => 'Set the border', 'text' => '12–18 inches is usual.'],
    ]"
    :faqs="[
        ['question' => 'What size rug for a 14 × 12 ft room?', 'answer' => '8 × 10 ft keeps at least 18 inches of floor showing; with a 12-inch border a 9 × 12 ft rug fits.'],
        ['question' => 'What size rug under a queen bed?', 'answer' => 'Often 8 × 10 ft.'],
        ['question' => 'Should all furniture sit on the rug?', 'answer' => 'In a living room, at least the front legs.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Room length" value="14" min="0" placeholder="Room length">
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
        <x-calc.field name="border" label="Floor border each side" value="18" min="0" placeholder="Floor border each side">
            <label for="calc-border-unit" class="sr-only">Floor border each side unit</label>
            <select id="calc-border-unit" name="border-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="system" legend="Rug sizes" :options="['ft' => 'Feet', 'cm' => 'Centimeters']" selected="ft" />

    <x-calc.result label="Largest standard rug that leaves the border" />

    <x-calc.options :examples="[
        '14 × 12 ft room' => ['length' => 14, 'length-unit' => 'ft', 'width' => 12, 'width-unit' => 'ft', 'border' => 18, 'border-unit' => 'in', 'system' => 'ft'],
        '12 × 10 ft, 12 in border' => ['length' => 12, 'length-unit' => 'ft', 'width' => 10, 'width-unit' => 'ft', 'border' => 12, 'border-unit' => 'in', 'system' => 'ft'],
        '4 × 3.5 m, metric rugs' => ['length' => 4, 'length-unit' => 'm', 'width' => 3.5, 'width-unit' => 'm', 'border' => 40, 'border-unit' => 'cm', 'system' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Space available'],
            'rule' => ['label' => 'Guideline'],
        ]" />
        <x-calc.quick-ref heading="Standard sizes" name="sizes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>space = room − 2 × border</li>
            <li>rug = largest standard size within the space</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
