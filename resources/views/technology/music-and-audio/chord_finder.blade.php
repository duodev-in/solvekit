<x-calc.page
    title="Chord Finder - SolveKit"
    description="Free chord finder: name the chord from its notes, including inversions and slash chords."
    lede="Name a chord from its notes."
    about="Given the notes you play, the chord finder matches them against every chord formula and root."
    :calc="['engine' => 'tc-music', 'tool' => 'chord_finder', 'fields' => ['notes'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What chord is E G C?', 'answer' => 'C/E: C major in first inversion.'],
    ]"
>
    <x-calc.textarea name="notes" label="Notes (any order; the first is the bass)" value="E G C" rows="3" />

    <x-calc.result label="Chord" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['notes' => 'E G C'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="On the keyboard" name="keys" />
        <x-calc.rows heading="Details" :rows="[
            'all' => ['label' => 'All names'],
            'inversion' => ['label' => 'Inversion'],
            'pcs' => ['label' => 'Pitch classes'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
