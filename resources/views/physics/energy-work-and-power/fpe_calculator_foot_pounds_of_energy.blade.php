<x-calc.page
    title="FPE calculator — Foot-pounds of Energy - SolveKit"
    description="Free FPE calculator: foot-pounds of energy for airsoft, airguns and arrows from weight and velocity."
    lede="Find foot-pounds of energy."
    about="Foot-pounds of energy (FPE) is the US unit for projectile energy: FPE = grains × fps² ÷ 450,240. Airgun rules often limit FPE."
    :calc="['engine' => 'ph-mech', 'tool' => 'fpe', 'fields' => ['m', 'v', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the FPE of a 14.3-grain pellet at 900 ft/s?', 'answer' => '25.715 ft·lbf.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Projectile weight" value="14.3" min="0" placeholder="Projectile weight">
            <label for="calc-m-unit" class="sr-only">Projectile weight unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gr')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Velocity" value="900" placeholder="Velocity">
            <label for="calc-v-unit" class="sr-only">Velocity unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="ftlbf" />
    </div>

    <x-calc.result label="Energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ftlbf', 'm' => 14.3, 'm-unit' => 'gr', 'v' => 900, 'v-unit' => 'fts'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'joules' => ['label' => 'In joules'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
