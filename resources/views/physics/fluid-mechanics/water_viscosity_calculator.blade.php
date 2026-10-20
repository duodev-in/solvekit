<x-calc.page
    title="Water Viscosity Calculator - SolveKit"
    description="Free water viscosity calculator: dynamic and kinematic viscosity of water at any temperature."
    lede="Find water viscosity."
    about="Water gets much runnier as it warms: its viscosity halves between 20 °C and 50 °C."
    :calc="['engine' => 'ph-fluid', 'tool' => 'water_viscosity', 'fields' => ['T', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'kinematic_viscosity', 'length', 'mass', 'speed', 'temperature', 'viscosity'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the viscosity of water at 20 °C?', 'answer' => '1.00175 mPa·s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Water temperature" value="20" placeholder="Water temperature">
            <label for="calc-T-unit" class="sr-only">Water temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pas' => 'Pa·s', 'mpas' => 'mPa·s', 'cp' => 'cP', 'p' => 'P', 'lbfts' => 'lb/(ft·s)']" selected="mpas" />
    </div>

    <x-calc.result label="Dynamic viscosity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mpas', 'T' => 20, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nu' => ['label' => 'Kinematic viscosity'],
            'rho' => ['label' => 'Density used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
