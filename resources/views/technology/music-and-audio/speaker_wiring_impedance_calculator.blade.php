<x-calc.page
    title="Speaker Wiring Impedance Calculator - SolveKit"
    description="Free speaker wiring calculator: total impedance of speakers in series, parallel or series-parallel, with an amplifier check."
    lede="Wire speakers safely."
    about="Series wiring adds impedances; parallel wiring lowers them, which can overload an amplifier."
    :calc="['engine' => 'tc-music', 'tool' => 'speaker_wiring', 'fields' => ['count', 'z', 'wiring', 'amp', 'power'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What load do four 8 Ω speakers make in series-parallel?', 'answer' => '8 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="count" label="Number of speakers" value="4" min="1" step="any" />
        <x-calc.field name="z" label="Impedance of each (Ω)" value="8" min="0" step="any" />
        <x-calc.select name="wiring" label="Wiring" :options="['series' => 'All in series', 'parallel' => 'All in parallel', 'sp' => 'Series-parallel (pairs in series, pairs in parallel)']" selected="sp" />
        <x-calc.field name="amp" label="Lowest load the amplifier allows (Ω)" value="4" min="0" step="any" />
        <x-calc.field name="power" label="Amplifier power into that load (W)" value="400" min="0" step="any" />
    </div>

    <x-calc.result label="Total impedance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['count' => 4, 'z' => 8, 'wiring' => 'sp', 'amp' => 4, 'power' => 400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'safe' => ['label' => 'Safe for the amplifier?'],
            'share' => ['label' => 'Power per speaker (identical speakers)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
