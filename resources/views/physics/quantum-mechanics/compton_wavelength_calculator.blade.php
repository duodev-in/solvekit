<x-calc.page
    title="Compton Wavelength Calculator - SolveKit"
    description="Free Compton wavelength calculator: h/mc for the electron, proton, neutron, muon or any mass."
    lede="Find a Compton wavelength."
    about="A particle’s Compton wavelength h/mc is the length scale where quantum field effects set in; for the electron it is 2.43 pm."
    :calc="['engine' => 'ph-quantum', 'tool' => 'compton_wavelength', 'fields' => ['particle', 'm', 'out'], 'unitFields' => ['m' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the electron’s Compton wavelength?', 'answer' => '0.00242631 nm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
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
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
    </div>

    <x-calc.result label="Compton wavelength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'particle' => 'electron', 'm' => 1, 'm-unit' => 'u'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'reduced' => ['label' => 'Reduced Compton wavelength ħ/mc'],
            'E' => ['label' => 'Rest energy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
