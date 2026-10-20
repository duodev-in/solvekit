<x-calc.page
    title="EIRP Calculator — Effective Isotropic Radiated Power - SolveKit"
    description="Free EIRP calculator: effective isotropic radiated power from transmitter power, cable loss and antenna gain."
    lede="Find the EIRP of a transmitter."
    about="EIRP is the power an ideal isotropic antenna would need to give the same signal in the main beam: transmitter power minus losses plus antenna gain, in decibels. ERP is relative to a dipole, 2.15 dB lower."
    :calc="['engine' => 'ph-mech', 'tool' => 'eirp', 'fields' => ['p', 'loss', 'gain'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the EIRP of 30 dBm with 2 dB loss and a 12 dBi antenna?', 'answer' => '40 dBm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Transmitter power (dBm)" value="30" step="any" />
        <x-calc.field name="loss" label="Cable and connector loss (dB)" value="2" min="0" step="any" />
        <x-calc.field name="gain" label="Antenna gain (dBi)" value="12" step="any" />
    </div>

    <x-calc.result label="EIRP" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => 30, 'loss' => 2, 'gain' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'watts' => ['label' => 'In watts'],
            'dbw' => ['label' => 'In dBW'],
            'erp' => ['label' => 'ERP (relative to a dipole)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
