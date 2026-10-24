<x-calc.page
    title="Music Duration Calculator - SolveKit"
    description="Free music duration calculator: length of a piece from bars, time signature and tempo."
    lede="Find how long a piece lasts."
    about="A piece’s length follows from its bars, beats per bar and tempo."
    :calc="['engine' => 'tc-music', 'tool' => 'music_duration', 'fields' => ['bars', 'beatsPerBar', 'bpm', 'target'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long are 64 bars of 4/4 at 120 BPM?', 'answer' => '2:08.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bars" label="Bars" value="64" min="0" step="any" />
        <x-calc.field name="beatsPerBar" label="Beats per bar (time signature top)" value="4" min="1" step="any" />
        <x-calc.field name="bpm" label="Tempo (BPM)" value="120" min="1" step="any" />
        <x-calc.field name="target" label="Target length (seconds, optional)" value="180" min="0" step="any" />
    </div>

    <x-calc.result label="Duration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bars' => 64, 'beatsPerBar' => 4, 'bpm' => 120, 'target' => 180],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'beats' => ['label' => 'Beats'],
            'bar' => ['label' => 'One bar'],
            'barsFor' => ['label' => 'Bars for the target length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
