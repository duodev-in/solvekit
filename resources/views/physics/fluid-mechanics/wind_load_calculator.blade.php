<x-calc.page
    title="Wind Load Calculator - SolveKit"
    description="Free wind load calculator: physics estimate of wind force on a sign, panel or object, F = ½ρv²C_dA."
    lede="Estimate wind force on an object."
    about="Wind pushes with the dynamic pressure ½ρv² times the drag coefficient and area. This is a physics estimate; building design must follow a wind code such as ASCE 7 or Eurocode 1."
    :calc="['engine' => 'ph-fluid', 'tool' => 'wind_load', 'fields' => ['v', 'A', 'shape', 'Cd', 'rho', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force does 100 km/h wind put on a 2 m² board?', 'answer' => 'About 1,105.9 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Wind speed" value="100" placeholder="Wind speed">
            <label for="calc-v-unit" class="sr-only">Wind speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="A" label="Area facing the wind" value="2" min="0" placeholder="Area facing the wind">
            <label for="calc-A-unit" class="sr-only">Area facing the wind unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="shape" label="Shape" :options="['plate' => 'Flat plate facing the wind (square)', 'long_plate' => 'Long flat plate or sign', 'cylinder' => 'Long cylinder (pole)', 'sphere' => 'Sphere', 'cube' => 'Cube', 'person' => 'Standing person', 'car' => 'Car (typical)', 'custom' => 'Other (enter C_d)']" selected="plate" />
        <div data-show-when="shape:custom">
            <x-calc.field name="Cd" label="Drag coefficient" value="1.2" min="0" step="any" />
        </div>
        <x-calc.field name="rho" label="Air density" value="1.225" min="0" placeholder="Air density">
            <label for="calc-rho-unit" class="sr-only">Air density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Wind force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'v' => 100, 'v-unit' => 'kmh', 'A' => 2, 'A-unit' => 'm2', 'shape' => 'plate', 'Cd' => 1.2, 'rho' => 1.225, 'rho-unit' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'q' => ['label' => 'Dynamic pressure ½ρv²'],
            'kg' => ['label' => 'As a weight'],
            'note' => ['label' => 'Important'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
