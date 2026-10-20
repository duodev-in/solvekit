<x-calc.page
    title="Thermal Expansion Calculator - SolveKit"
    description="Free thermal expansion calculator: length, area and volume change of materials with temperature."
    lede="Find thermal expansion."
    about="Most materials grow when heated: ΔL = αLΔT. A 10 m steel rail grows about 5 mm for 40 K."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_expansion', 'fields' => ['mat', 'alpha', 'L', 'dT', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature_difference'])->all(), 'physics' => collect(config('physics_data'))->only(['thermal'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does 10 m of steel grow for 40 K?', 'answer' => '4.8 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mat" label="Material" :options="['copper' => 'Copper', 'aluminium' => 'Aluminium', 'brass' => 'Brass', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'glass' => 'Glass', 'granite' => 'Granite', 'concrete' => 'Concrete', 'brick' => 'Brick', 'gypsum' => 'Gypsum plasterboard', 'pine' => 'Softwood (pine)', 'plywood' => 'Plywood', 'pvc' => 'PVC', 'mineral_wool' => 'Mineral wool', 'eps' => 'Expanded polystyrene (EPS)', 'pir' => 'Polyisocyanurate (PIR) board', 'ice' => 'Ice (0 °C)', 'water' => 'Water', 'air' => 'Air (still)', 'custom' => 'Other (enter the value)']" selected="steel" />
        <div data-show-when="mat:custom">
            <x-calc.field name="alpha" label="Expansion coefficient (10⁻⁶/K)" value="12" step="any" />
        </div>
        <x-calc.field name="L" label="Length" value="10" placeholder="Length">
            <label for="calc-L-unit" class="sr-only">Length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="dT" label="Temperature change" value="40" placeholder="Temperature change">
            <label for="calc-dT-unit" class="sr-only">Temperature change unit</label>
            <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Change in length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'mat' => 'steel', 'alpha' => 12, 'L' => 10, 'L-unit' => 'm', 'dT' => 40, 'dT-unit' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'newL' => ['label' => 'New length'],
            'area' => ['label' => 'Area change (2α)'],
            'vol' => ['label' => 'Volume change (3α)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
