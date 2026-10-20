<x-calc.page
    title="Photon Detection Efficiency Calculator (SiPM) - SolveKit"
    description="Free SiPM photon detection efficiency calculator: PDE from quantum efficiency, fill factor and avalanche probability."
    lede="Find a SiPM’s PDE."
    about="A silicon photomultiplier detects a photon only if it is absorbed in an active cell and triggers an avalanche. PDE is the product of those three probabilities."
    :calc="['engine' => 'ph-elec', 'tool' => 'sipm_pde', 'fields' => ['qe', 'ff', 'pa'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What PDE do QE 80%, FF 60% and P_a 90% give?', 'answer' => '43.2%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="qe" label="Quantum efficiency (%)" value="80" min="0" step="any" />
        <x-calc.field name="ff" label="Fill factor (%)" value="60" min="0" step="any" />
        <x-calc.field name="pa" label="Avalanche trigger probability (%)" value="90" min="0" step="any" />
    </div>

    <x-calc.result label="Photon detection efficiency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['qe' => 80, 'ff' => 60, 'pa' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lost' => ['label' => 'Largest loss'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
