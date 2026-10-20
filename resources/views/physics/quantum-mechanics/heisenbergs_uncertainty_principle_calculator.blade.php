<x-calc.page
    title="Heisenberg's Uncertainty Principle Calculator - SolveKit"
    description="Free Heisenberg uncertainty calculator: minimum momentum or position uncertainty from Δx Δp ≥ ħ/2."
    lede="Apply the uncertainty principle."
    about="Position and momentum cannot both be sharp: Δx Δp ≥ ħ/2. Confining an electron to an atom forces a velocity spread of hundreds of km/s."
    :calc="['engine' => 'ph-quantum', 'tool' => 'heisenberg', 'fields' => ['mode', 'dx', 'dp', 'particle', 'm'], 'unitFields' => ['dx' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dp' => collect(config('units.momentum'))->only(['kgms', 'gcms', 'lbfts', 'lbfs'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'momentum', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the minimum Δp for an electron confined to 0.1 nm?', 'answer' => '5.27286 × 10⁻²⁵ kg·m/s (Δp).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['x' => 'Position uncertainty', 'p' => 'Momentum uncertainty']" selected="x" />
        <div data-show-when="mode:x">
            <x-calc.field name="dx" label="Position uncertainty Δx" value="0.1" placeholder="Position uncertainty Δx">
                <label for="calc-dx-unit" class="sr-only">Position uncertainty Δx unit</label>
                <select id="calc-dx-unit" name="dx-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:p">
            <x-calc.field name="dp" label="Momentum uncertainty Δp" value="1e-24" placeholder="Momentum uncertainty Δp">
                <label for="calc-dp-unit" class="sr-only">Momentum uncertainty Δp unit</label>
                <select id="calc-dp-unit" name="dp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.momentum'))->only(['kgms', 'gcms', 'lbfts', 'lbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="particle" label="Particle" :options="['electron' => 'Electron', 'proton' => 'Proton', 'neutron' => 'Neutron', 'muon' => 'Muon', 'custom' => 'Other (enter the mass)']" selected="electron" />
        <div data-show-when="particle:custom">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'u')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Minimum uncertainty" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'x', 'dx' => 0.1, 'dx-unit' => 'nm', 'dp' => 1e-24, 'dp-unit' => 'kgms', 'particle' => 'electron', 'm' => 1, 'm-unit' => 'u'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dv' => ['label' => 'Velocity uncertainty'],
            'E' => ['label' => 'Kinetic energy scale (Δp)²/2m'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
