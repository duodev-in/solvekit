<x-calc.page
    title="Music Scale Calculator - SolveKit"
    description="Free music scale calculator: the notes of major, minor, modal, pentatonic and blues scales on any root."
    lede="Find the notes of a scale."
    about="A scale is a pattern of whole and half steps from a root."
    :calc="['engine' => 'tc-music', 'tool' => 'scale', 'fields' => ['root', 'type'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What are the notes of A minor?', 'answer' => 'A – B – C – D – E – F – G.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="root" label="Root" value="A" type="text" inputmode="text" />
        <x-calc.select name="type" label="Scale" :options="['major' => 'Major (Ionian)', 'minor' => 'Natural minor (Aeolian)', 'harmonic' => 'Harmonic minor', 'melodic' => 'Melodic minor (ascending)', 'dorian' => 'Dorian', 'phrygian' => 'Phrygian', 'lydian' => 'Lydian', 'mixolydian' => 'Mixolydian', 'locrian' => 'Locrian', 'pent_major' => 'Major pentatonic', 'pent_minor' => 'Minor pentatonic', 'blues' => 'Blues', 'whole' => 'Whole tone']" selected="minor" />
    </div>

    <x-calc.result label="Notes" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['root' => 'A', 'type' => 'minor'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="On the keyboard" name="keys" />
        <x-calc.rows heading="Details" :rows="[
            'steps' => ['label' => 'Step pattern (W = whole, H = half)'],
            'chords' => ['label' => 'Triads on each degree'],
            'degrees' => ['label' => 'Intervals'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
