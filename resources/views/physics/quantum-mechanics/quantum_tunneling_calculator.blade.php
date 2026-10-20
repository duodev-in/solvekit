<x-calc.page
    title="Quantum Tunneling Calculator - SolveKit"
    description="Free quantum tunnelling calculator: transmission probability through a rectangular barrier."
    lede="Find tunnelling probability."
    about="A quantum particle can cross a barrier higher than its energy, with a probability that falls exponentially with the barrier width. Tunnelling microscopes and flash memory rely on it."
    :calc="['engine' => 'ph-quantum', 'tool' => 'tunneling', 'fields' => ['V0', 'a', 'E', 'particle', 'm'], 'unitFields' => ['V0' => collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj'])->all(), 'a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'E' => collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What fraction of 5 eV electrons tunnel through a 10 eV, 0.5 nm barrier?', 'answer' => '0.0000423528.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="V0" label="Barrier height" value="10" min="0" placeholder="Barrier height">
            <label for="calc-V0-unit" class="sr-only">Barrier height unit</label>
            <select id="calc-V0-unit" name="V0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ev')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="a" label="Barrier width" value="0.5" placeholder="Barrier width">
            <label for="calc-a-unit" class="sr-only">Barrier width unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="E" label="Particle energy" value="5" min="0" placeholder="Particle energy">
            <label for="calc-E-unit" class="sr-only">Particle energy unit</label>
            <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ev')>{{ $unit['symbol'] }}</option>
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
    </div>

    <x-calc.result label="Transmission probability" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['V0' => 10, 'V0-unit' => 'ev', 'a' => 0.5, 'a-unit' => 'nm', 'E' => 5, 'E-unit' => 'ev', 'particle' => 'electron', 'm' => 1, 'm-unit' => 'u'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'R' => ['label' => 'Reflection probability'],
            'kappa' => ['label' => 'Decay constant κ'],
            'approx' => ['label' => 'Thick-barrier approximation 16(E/V)(1 − E/V)e^(−2κa)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
