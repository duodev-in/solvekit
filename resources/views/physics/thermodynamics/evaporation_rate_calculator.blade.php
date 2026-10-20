<x-calc.page
    title="Evaporation Rate Calculator - SolveKit"
    description="Free evaporation rate calculator: water lost from a pool or tank by the Carrier equation."
    lede="Estimate evaporation from water."
    about="Water evaporates in proportion to the difference between its own vapour pressure and that of the air, faster with air movement and splashing."
    :calc="['engine' => 'ph-thermo', 'tool' => 'evaporation', 'fields' => ['A', 'Tw', 'Ta', 'rh', 'v', 'use'], 'unitFields' => ['A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'Tw' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Ta' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does the example pool lose per day?', 'answer' => '188.8 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="A" label="Water surface area" value="50" min="0" placeholder="Water surface area">
            <label for="calc-A-unit" class="sr-only">Water surface area unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Tw" label="Water temperature" value="28" placeholder="Water temperature">
            <label for="calc-Tw-unit" class="sr-only">Water temperature unit</label>
            <select id="calc-Tw-unit" name="Tw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Ta" label="Air temperature" value="25" placeholder="Air temperature">
            <label for="calc-Ta-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-Ta-unit" name="Ta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rh" label="Relative humidity (%)" value="50" min="0" step="any" />
        <x-calc.field name="v" label="Air speed over the water" value="0.1" placeholder="Air speed over the water">
            <label for="calc-v-unit" class="sr-only">Air speed over the water unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="use" label="Activity factor" :options="['1' => 'Public or school pool', '0.5' => 'Unoccupied pool (cover off)', '0.65' => 'Residential pool', '0.8' => 'Hotel or condominium pool', '1.5' => 'Wave pool or water park']" selected="0.5" />
    </div>

    <x-calc.result label="Evaporation rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['A' => 50, 'A-unit' => 'm2', 'Tw' => 28, 'Tw-unit' => 'c', 'Ta' => 25, 'Ta-unit' => 'c', 'rh' => 50, 'v' => 0.1, 'v-unit' => 'ms', 'use' => '0.5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'day' => ['label' => 'Per day'],
            'depth' => ['label' => 'Water level drop per day'],
            'heat' => ['label' => 'Heat lost'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
