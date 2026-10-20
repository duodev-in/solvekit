<x-calc.page
    title="Fermi Level Calculator - SolveKit"
    description="Free Fermi energy calculator: Fermi energy, temperature and velocity of free-electron metals."
    lede="Find the Fermi energy of a metal."
    about="In a metal, electrons fill states up to the Fermi energy. For copper it is about 7 eV, equivalent to a temperature of 80,000 K."
    :calc="['engine' => 'ph-quantum', 'tool' => 'fermi', 'fields' => ['metal', 'n', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['metals'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Fermi energy of copper?', 'answer' => '7.03276 eV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="metal" label="Metal" :options="['li' => 'Lithium', 'na' => 'Sodium', 'k' => 'Potassium', 'cu' => 'Copper', 'ag' => 'Silver', 'au' => 'Gold', 'mg' => 'Magnesium', 'zn' => 'Zinc', 'al' => 'Aluminium', 'fe' => 'Iron', 'custom' => 'Other (enter the value)']" selected="cu" />
        <div data-show-when="metal:custom">
            <x-calc.field name="n" label="Electron density (per m³)" value="8.47e+28" min="0" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ev' => 'eV', 'mev_milli' => 'meV', 'kev' => 'keV', 'mev' => 'MeV', 'gev' => 'GeV', 'j' => 'J', 'zj' => 'zJ']" selected="ev" />
    </div>

    <x-calc.result label="Fermi energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ev', 'metal' => 'cu', 'n' => 8.47e+28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'TF' => ['label' => 'Fermi temperature'],
            'vF' => ['label' => 'Fermi velocity'],
            'kF' => ['label' => 'Fermi wave number'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
