<x-calc.page
    title="Particle in a Box Calculator - SolveKit"
    description="Free particle in a box calculator: energy levels and probability density of a particle in a 1D infinite well."
    lede="Solve a particle in a box."
    about="A particle trapped between walls can only have energies n²h²/8mL². Smaller boxes and lighter particles have more widely spaced levels."
    :calc="['engine' => 'ph-quantum', 'tool' => 'particle_box', 'fields' => ['L', 'particle', 'm', 'n', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the ground-state energy of an electron in a 1 nm box?', 'answer' => '0.37603 eV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Box length" value="1" placeholder="Box length">
            <label for="calc-L-unit" class="sr-only">Box length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
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
        <x-calc.field name="n" label="Level n" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['ev' => 'eV', 'mev_milli' => 'meV', 'kev' => 'keV', 'mev' => 'MeV', 'gev' => 'GeV', 'j' => 'J', 'zj' => 'zJ']" selected="ev" />
    </div>

    <x-calc.result label="Energy of level n" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ev', 'L' => 1, 'L-unit' => 'nm', 'particle' => 'electron', 'm' => 1, 'm-unit' => 'u', 'n' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Probability density |ψ|² for level n" name="psi" />
        <x-calc.rows heading="Details" :rows="[
            'E1' => ['label' => 'Ground state'],
            'levels' => ['label' => 'First five levels'],
            'gap' => ['label' => 'Photon for n → n − 1 (or 2 → 1)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
