<x-calc.page
    title="Lumen Calculator (Lumen to Lux to Candela) - SolveKit"
    description="Free lumen calculator: convert lumens to candela and lux from beam angle and distance."
    lede="Convert lumens to lux and candela."
    about="Lumens measure total light output, candela measure intensity in a direction, and lux measure light falling on a surface. A beam angle spreads the lumens over a solid angle; lux falls with the square of the distance."
    :calc="['engine' => 'ph-wave', 'tool' => 'lumen', 'fields' => ['lm', 'beam', 'd', 'out'], 'unitFields' => ['beam' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'illuminance', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many lux does an 800 lm, 60° lamp give at 2 m?', 'answer' => '237.59 lx.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lm" label="Luminous flux (lumens)" value="800" min="0" step="any" />
        <x-calc.field name="beam" label="Beam angle (full)" value="60" placeholder="Beam angle (full)">
            <label for="calc-beam-unit" class="sr-only">Beam angle (full) unit</label>
            <select id="calc-beam-unit" name="beam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance to the surface" value="2" placeholder="Distance to the surface">
            <label for="calc-d-unit" class="sr-only">Distance to the surface unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['lx' => 'lx', 'fc' => 'fc', 'phot' => 'ph', 'klx' => 'klx']" selected="lx" />
    </div>

    <x-calc.result label="Illuminance at the centre" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'lx', 'lm' => 800, 'beam' => 60, 'beam-unit' => 'deg', 'd' => 2, 'd-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cd' => ['label' => 'Luminous intensity'],
            'sr' => ['label' => 'Solid angle of the beam'],
            'spot' => ['label' => 'Beam diameter at that distance'],
            'avg' => ['label' => 'Average over the beam spot'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
