<x-calc.page
    title="Rainfall Calculator - SolveKit"
    description="Free rainfall calculator: water volume from rain depth and area, and how much a roof can collect."
    lede="Find rainfall volume."
    about="One millimetre of rain on one square metre is one litre."
    :calc="['engine' => 'ot-misc', 'tool' => 'rainfall', 'fields' => ['rain', 'area', 'runoff'], 'unitFields' => ['rain' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'area' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much water does 25 mm on 100 m² give?', 'answer' => '2,500 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rain" label="Rainfall depth" value="25" placeholder="Rainfall depth">
            <label for="calc-rain-unit" class="sr-only">Rainfall depth unit</label>
            <select id="calc-rain-unit" name="rain-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="area" label="Area (roof, garden, field)" value="100" min="0" placeholder="Area (roof, garden, field)">
            <label for="calc-area-unit" class="sr-only">Area (roof, garden, field) unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="runoff" label="Surface" :options="['1' => 'All the water (1.0)', '0.95' => 'Metal or tiled roof (0.95)', '0.85' => 'Concrete or asphalt (0.85)', '0.6' => 'Gravel (0.6)', '0.2' => 'Lawn or garden (0.2)']" selected="0.95" />
    </div>

    <x-calc.result label="Rain volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rain' => 25, 'rain-unit' => 'mm', 'area' => 100, 'area-unit' => 'm2', 'runoff' => '0.95'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'collected' => ['label' => 'Water you could collect (runoff)'],
            'weight' => ['label' => 'Weight'],
            'gallons' => ['label' => 'In US gallons'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
