<x-calc.page
    title="BPM Calculator - SolveKit"
    description="Free BPM calculator: tempo from beats counted, with beat length and tempo marking."
    lede="Find the tempo in BPM."
    about="Tempo is counted in beats per minute: count beats over a few seconds and scale to a minute. Also known as Playback Speed Calculator."
    :calc="['engine' => 'tc-music', 'tool' => 'bpm', 'fields' => ['beats', 'seconds'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What tempo is 30 beats in 15 seconds?', 'answer' => '120 BPM.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="beats" label="Beats counted" value="30" min="1" step="any" />
        <x-calc.field name="seconds" label="In seconds" value="15" min="0" step="any" />
    </div>

    <x-calc.result label="Tempo" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['beats' => 30, 'seconds' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'beatMs' => ['label' => 'One beat'],
            'marking' => ['label' => 'Tempo marking (approximate)'],
            'barMs' => ['label' => 'One 4/4 bar'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
