<x-calc.page
    title="Chord Transposer - SolveKit"
    description="Free chord transposer: move a chord chart to any key or by semitones, with a capo suggestion."
    lede="Transpose a chord chart."
    about="Transposing moves every chord by the same interval; lyric lines stay as they are."
    :calc="['engine' => 'tc-music', 'tool' => 'chord_transposer', 'fields' => ['chart', 'by', 'semis', 'from', 'to', 'spell'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is G D Em C up two semitones?', 'answer' => 'A E F♯m D.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="chart" label="Chord chart (lyrics lines are left alone)" value="G      D      Em     C
Amazing grace how sweet the sound
G  D/F#  Em  C  G" rows="3" />
        <x-calc.select name="by" label="Transpose by" :options="['semis' => 'Semitones', 'keys' => 'From one key to another']" selected="semis" />
        <div data-show-when="by:semis">
            <x-calc.field name="semis" label="Semitones (up +, down −)" value="2" step="any" />
        </div>
        <div data-show-when="by:keys">
            <x-calc.field name="from" label="From key" value="G" type="text" inputmode="text" />
        </div>
        <div data-show-when="by:keys">
            <x-calc.field name="to" label="To key" value="A" type="text" inputmode="text" />
        </div>
        <x-calc.select name="spell" label="Spell with" :options="['sharps' => 'Sharps (♯)', 'flats' => 'Flats (♭)']" selected="sharps" />
    </div>

    <x-calc.result label="Transposed chart" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['chart' => 'G      D      Em     C
Amazing grace how sweet the sound
G  D/F#  Em  C  G', 'by' => 'semis', 'semis' => 2, 'from' => 'G', 'to' => 'A', 'spell' => 'sharps'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shift' => ['label' => 'Shift'],
            'capo' => ['label' => 'Or play the original shapes with a capo on fret'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
