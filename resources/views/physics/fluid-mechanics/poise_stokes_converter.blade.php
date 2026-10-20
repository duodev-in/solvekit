<x-calc.page
    title="Poise-Stokes Converter - SolveKit"
    description="Free poise to stokes converter: convert dynamic and kinematic viscosity with density."
    lede="Convert dynamic and kinematic viscosity."
    about="Dynamic viscosity (poise, Pa·s) and kinematic viscosity (stokes, m²/s) differ by the density: ν = μ/ρ."
    :calc="['engine' => 'ph-fluid', 'tool' => 'poise_stokes', 'fields' => ['mode', 'mu', 'nu', 'rho'], 'unitFields' => ['mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all(), 'nu' => collect(config('units.kinematic_viscosity'))->only(['m2s', 'mm2s', 'cst', 'st', 'ft2s'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'kinematic_viscosity', 'length', 'mass', 'speed', 'viscosity'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 1 cP of water in cSt?', 'answer' => '1.0018 cSt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Convert" :options="['dyn' => 'Dynamic → kinematic', 'kin' => 'Kinematic → dynamic']" selected="dyn" />
        <div data-show-when="mode:dyn">
            <x-calc.field name="mu" label="Dynamic viscosity" value="1" min="0" placeholder="Dynamic viscosity">
                <label for="calc-mu-unit" class="sr-only">Dynamic viscosity unit</label>
                <select id="calc-mu-unit" name="mu-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cp')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:kin">
            <x-calc.field name="nu" label="Kinematic viscosity" value="1" min="0" placeholder="Kinematic viscosity">
                <label for="calc-nu-unit" class="sr-only">Kinematic viscosity unit</label>
                <select id="calc-nu-unit" name="nu-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.kinematic_viscosity'))->only(['m2s', 'mm2s', 'cst', 'st', 'ft2s']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cst')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="rho" label="Density" value="998.2" min="0" placeholder="Density">
            <label for="calc-rho-unit" class="sr-only">Density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'dyn', 'mu' => 1, 'mu-unit' => 'cp', 'nu' => 1, 'nu-unit' => 'cst', 'rho' => 998.2, 'rho-unit' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mu' => ['label' => 'Dynamic viscosity'],
            'nu' => ['label' => 'Kinematic viscosity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
