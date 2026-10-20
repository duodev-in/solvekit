<x-calc.page
    title="Optical Density Calculator - SolveKit"
    description="Free optical density calculator: convert between OD and transmittance for filters and laser goggles."
    lede="Convert OD and transmittance."
    about="Optical density is −log₁₀ of the transmittance: OD 1 passes 10%, OD 3 passes 0.1%. Laser safety eyewear is rated by OD at the laser wavelength."
    :calc="['engine' => 'ph-wave', 'tool' => 'optical_density', 'fields' => ['mode', 'T', 'OD'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What OD passes 10%?', 'answer' => '1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['T' => 'Transmittance', 'OD' => 'Optical density']" selected="T" />
        <div data-show-when="mode:T">
            <x-calc.field name="T" label="Transmittance (%)" value="10" min="0" step="any" />
        </div>
        <div data-show-when="mode:OD">
            <x-calc.field name="OD" label="Optical density" value="3" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Optical density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'T', 'T' => 10, 'OD' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Transmittance'],
            'db' => ['label' => 'Attenuation'],
            'blocked' => ['label' => 'Light blocked'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
