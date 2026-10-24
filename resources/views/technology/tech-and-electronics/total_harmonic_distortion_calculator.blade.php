<x-calc.page
    title="Total Harmonic Distortion Calculator - SolveKit"
    description="Free THD calculator: total harmonic distortion from harmonic amplitudes or dBc, with THD+N."
    lede="Find total harmonic distortion."
    about="THD compares the combined harmonics with the fundamental: lower means a cleaner signal."
    :calc="['engine' => 'tc-elec', 'tool' => 'thd', 'fields' => ['mode', 'list', 'noise'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the THD of the example harmonics?', 'answer' => '5.535%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Harmonics entered as" :options="['volts' => 'Amplitudes (fundamental first)', 'dbc' => 'dB below the fundamental (dBc)']" selected="volts" />
        <x-calc.textarea name="list" label="Values (fundamental, 2nd, 3rd …; or dBc of 2nd, 3rd …)" value="1, 0.02, 0.05, 0.01, 0.008" rows="3" />
        <x-calc.field name="noise" label="Noise relative to the fundamental (optional, %)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="THD" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'volts', 'list' => '1, 0.02, 0.05, 0.01, 0.008', 'noise' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'db' => ['label' => 'In dB'],
            'thdn' => ['label' => 'THD+N'],
            'largest' => ['label' => 'Largest harmonic'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
