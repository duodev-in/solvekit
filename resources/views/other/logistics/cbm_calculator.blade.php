<x-calc.page
    title="CBM Calculator - SolveKit"
    description="Free CBM calculator: cubic metres of cartons, cubic feet and containers needed."
    lede="Find cubic metres."
    about="CBM (cubic metres) is how freight volume is measured and priced."
    :calc="['engine' => 'ot-misc', 'tool' => 'cbm', 'fields' => ['l', 'w', 'h', 'qty'], 'unitFields' => ['l' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all(), 'other' => collect(config('other_data'))->only(['containers'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the CBM of 120 cartons of 60 × 40 × 35 cm?', 'answer' => '10.08 m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="l" label="Carton length" value="60" placeholder="Carton length">
            <label for="calc-l-unit" class="sr-only">Carton length unit</label>
            <select id="calc-l-unit" name="l-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Carton width" value="40" placeholder="Carton width">
            <label for="calc-w-unit" class="sr-only">Carton width unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Carton height" value="35" placeholder="Carton height">
            <label for="calc-h-unit" class="sr-only">Carton height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="qty" label="Number of cartons" value="120" min="1" step="any" />
    </div>

    <x-calc.result label="Total volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['l' => 60, 'l-unit' => 'cm', 'w' => 40, 'w-unit' => 'cm', 'h' => 35, 'h-unit' => 'cm', 'qty' => 120],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'each' => ['label' => 'One carton'],
            'ft3' => ['label' => 'Cubic feet'],
            'containers' => ['label' => 'Containers by volume (at 85% fill)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
