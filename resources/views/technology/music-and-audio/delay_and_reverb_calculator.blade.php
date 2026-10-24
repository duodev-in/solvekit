<x-calc.page
    title="Delay and Reverb Calculator - SolveKit"
    description="Free delay and reverb calculator: tempo-synced delay times (straight, dotted, triplet), pre-delay and decay."
    lede="Sync delay to the tempo."
    about="Delay repeats that land on the beat sound tight; their times follow from the tempo."
    :calc="['engine' => 'tc-music', 'tool' => 'delay_reverb', 'fields' => ['bpm'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is a quarter-note delay at 120 BPM?', 'answer' => '500 ms.'],
    ]"
>
    <x-calc.field name="bpm" label="Tempo (BPM)" value="120" min="1" step="any" />

    <x-calc.result label="Quarter-note delay" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bpm' => 120],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'predelay' => ['label' => 'Reverb pre-delay (1/64 – 1/32 note)'],
            'decay' => ['label' => 'Reverb decay that ends on the beat'],
            'lfo' => ['label' => 'Quarter-note LFO rate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Delay times by note value" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
