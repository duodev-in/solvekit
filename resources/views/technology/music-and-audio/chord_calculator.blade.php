<x-calc.page
    title="Chord Calculator - SolveKit"
    description="Free chord calculator: the notes of any chord (major, minor, 7th, sus, 9th …) on any root, with a keyboard diagram."
    lede="Find the notes of a chord."
    about="A chord is built by stacking set intervals on a root note."
    :calc="['engine' => 'tc-music', 'tool' => 'chord', 'fields' => ['root', 'type'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What notes are in Cmaj7?', 'answer' => 'C – E – G – B.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="root" label="Root" value="C" type="text" inputmode="text" />
        <x-calc.select name="type" label="Chord" :options="['5' => 'Power chord', '6' => 'Major 6th', '7' => 'Dominant 7th', '9' => 'Dominant 9th', '11' => 'Dominant 11th', '13' => 'Dominant 13th', 'maj' => 'Major', 'min' => 'Minor', 'dim' => 'Diminished', 'aug' => 'Augmented', 'sus2' => 'Suspended 2nd', 'sus4' => 'Suspended 4th', 'm6' => 'Minor 6th', 'maj7' => 'Major 7th', 'm7' => 'Minor 7th', 'mmaj7' => 'Minor-major 7th', 'm7b5' => 'Half-diminished 7th', 'dim7' => 'Diminished 7th', 'aug7' => 'Augmented 7th', '7sus4' => 'Dominant 7th suspended 4th', 'add9' => 'Added 9th', 'madd9' => 'Minor added 9th', 'maj9' => 'Major 9th', 'm9' => 'Minor 9th', 'm11' => 'Minor 11th', 'maj13' => 'Major 13th']" selected="maj7" />
    </div>

    <x-calc.result label="Notes" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['root' => 'C', 'type' => 'maj7'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="On the keyboard" name="keys" />
        <x-calc.rows heading="Details" :rows="[
            'symbol' => ['label' => 'Symbol'],
            'intervals' => ['label' => 'Intervals'],
            'semitones' => ['label' => 'Semitones from the root'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
