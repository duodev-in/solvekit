<x-calc.page
    title="Semitone Calculator - SolveKit"
    description="Free semitone calculator: semitones and cents between two notes or frequencies."
    lede="Count semitones."
    about="Each semitone is a frequency ratio of 2^(1/12); an octave is 12 semitones."
    :calc="['engine' => 'tc-music', 'tool' => 'semitone', 'fields' => ['a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many semitones from C4 to F♯4?', 'answer' => '6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First note (or Hz)" value="C4" type="text" inputmode="text" />
        <x-calc.field name="b" label="Second note (or Hz)" value="F#4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Semitones" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 'C4', 'b' => 'F#4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cents' => ['label' => 'Cents'],
            'ratio' => ['label' => 'Frequency ratio'],
            'octaves' => ['label' => 'Octaves'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
