<x-calc.page
    title="Electrical Mobility Calculator - SolveKit"
    description="Free electrical mobility calculator: carrier mobility from drift velocity and field, or from collision time."
    lede="Find carrier mobility."
    about="Mobility measures how fast charge carriers drift per unit field: μ = v_d/E = qτ/m."
    :calc="['engine' => 'ph-thermo', 'tool' => 'mobility', 'fields' => ['mode', 'vd', 'E', 'q', 'm', 'tau'], 'unitFields' => ['vd' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'E' => collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm'])->all(), 'q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all(), 'tau' => collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'electric_field', 'energy', 'force', 'length', 'mass', 'particle_mass', 'short_time', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What mobility gives 0.14 m/s in 1 kV/m?', 'answer' => '0.00014 m²/(V·s).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['vd' => 'Drift velocity and field', 'tau' => 'Charge, mass and collision time']" selected="vd" />
        <div data-show-when="mode:vd">
            <x-calc.field name="vd" label="Drift velocity" value="0.14" placeholder="Drift velocity">
                <label for="calc-vd-unit" class="sr-only">Drift velocity unit</label>
                <select id="calc-vd-unit" name="vd-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:vd">
            <x-calc.field name="E" label="Electric field" value="1000" placeholder="Electric field">
                <label for="calc-E-unit" class="sr-only">Electric field unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'vpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tau">
            <x-calc.field name="q" label="Charge" value="1" placeholder="Charge">
                <label for="calc-q-unit" class="sr-only">Charge unit</label>
                <select id="calc-q-unit" name="q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'e')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tau">
            <x-calc.field name="m" label="Effective mass" value="0.26" min="0" placeholder="Effective mass">
                <label for="calc-m-unit" class="sr-only">Effective mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'me')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tau">
            <x-calc.field name="tau" label="Mean collision time" value="0.2" min="0" placeholder="Mean collision time">
                <label for="calc-tau-unit" class="sr-only">Mean collision time unit</label>
                <select id="calc-tau-unit" name="tau-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.short_time'))->only(['s', 'ms', 'us', 'ns', 'ps', 'min', 'h']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ps')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Electrical mobility" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'vd', 'vd' => 0.14, 'vd-unit' => 'ms', 'E' => 1000, 'E-unit' => 'vpm', 'q' => 1, 'q-unit' => 'e', 'm' => 0.26, 'm-unit' => 'me', 'tau' => 0.2, 'tau-unit' => 'ps'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cm' => ['label' => 'In cm²/(V·s)'],
            'typical' => ['label' => 'Typical values'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
