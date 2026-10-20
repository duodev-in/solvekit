<x-calc.page
    title="Photoelectric Effect Calculator - SolveKit"
    description="Free photoelectric effect calculator: maximum electron energy, stopping voltage and threshold wavelength."
    lede="Solve the photoelectric effect."
    about="Light ejects electrons only if each photon carries more energy than the work function. Einstein explained this in 1905: K_max = hf − φ."
    :calc="['engine' => 'ph-quantum', 'tool' => 'photoelectric', 'fields' => ['lambda', 'metal', 'phi', 'out'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['work_functions'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What energy do 400 nm photons give electrons from sodium?', 'answer' => '0.739605 eV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lambda" label="Light wavelength" value="400" placeholder="Light wavelength">
            <label for="calc-lambda-unit" class="sr-only">Light wavelength unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="metal" label="Metal" :options="['cs' => 'Caesium', 'k' => 'Potassium', 'na' => 'Sodium', 'ca' => 'Calcium', 'li' => 'Lithium', 'mg' => 'Magnesium', 'ag' => 'Silver', 'al' => 'Aluminium', 'zn' => 'Zinc', 'fe' => 'Iron', 'w' => 'Tungsten', 'cu' => 'Copper', 'au' => 'Gold', 'pt' => 'Platinum', 'custom' => 'Other (enter the value)']" selected="na" />
        <div data-show-when="metal:custom">
            <x-calc.field name="phi" label="Work function (eV)" value="2.3" min="0" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ev' => 'eV', 'mev_milli' => 'meV', 'kev' => 'keV', 'mev' => 'MeV', 'gev' => 'GeV', 'j' => 'J', 'zj' => 'zJ']" selected="ev" />
    </div>

    <x-calc.result label="Maximum kinetic energy of the electrons" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ev', 'lambda' => 400, 'lambda-unit' => 'nm', 'metal' => 'na', 'phi' => 2.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'photon' => ['label' => 'Photon energy'],
            'stop' => ['label' => 'Stopping voltage'],
            'cut' => ['label' => 'Threshold wavelength'],
            'v' => ['label' => 'Fastest electron speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
