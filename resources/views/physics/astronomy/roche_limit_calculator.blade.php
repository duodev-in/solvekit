<x-calc.page
    title="Roche Limit Calculator - SolveKit"
    description="Free Roche limit calculator: how close a moon can orbit before tides tear it apart, for fluid and rigid bodies."
    lede="Find the Roche limit."
    about="Inside the Roche limit the planet’s tidal pull exceeds the moon’s own gravity. Saturn’s rings lie inside Saturn’s Roche limit."
    :calc="['engine' => 'ph-astro', 'tool' => 'roche', 'fields' => ['Rp', 'rhoM', 'rhom', 'kind', 'out'], 'unitFields' => ['Rp' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'rhoM' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'rhom' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Roche limit of the Moon around Earth?', 'answer' => '18,368.2 km (fluid model).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Rp" label="Primary radius" value="6371" min="0" placeholder="Primary radius">
            <label for="calc-Rp-unit" class="sr-only">Primary radius unit</label>
            <select id="calc-Rp-unit" name="Rp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rhoM" label="Primary density" value="5.51" min="0" placeholder="Primary density">
            <label for="calc-rhoM-unit" class="sr-only">Primary density unit</label>
            <select id="calc-rhoM-unit" name="rhoM-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rhom" label="Satellite density" value="3.34" min="0" placeholder="Satellite density">
            <label for="calc-rhom-unit" class="sr-only">Satellite density unit</label>
            <select id="calc-rhom-unit" name="rhom-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="kind" label="Satellite" :options="['fluid' => 'Fluid (held together by gravity only)', 'rigid' => 'Rigid']" selected="fluid" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="km" />
    </div>

    <x-calc.result label="Roche limit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'Rp' => 6371, 'Rp-unit' => 'km', 'rhoM' => 5.51, 'rhoM-unit' => 'gcm3', 'rhom' => 3.34, 'rhom-unit' => 'gcm3', 'kind' => 'fluid'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'radii' => ['label' => 'In primary radii'],
            'other' => ['label' => 'Other model'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
