<x-calc.page
    title="Key Signature Calculator - SolveKit"
    description="Free key signature calculator: sharps or flats of any major or minor key, with relative and parallel keys."
    lede="Find a key signature."
    about="A key signature lists the sharps or flats of a key, in circle-of-fifths order."
    :calc="['engine' => 'tc-music', 'tool' => 'key_signature', 'fields' => ['by', 'tonic', 'mode', 'count'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the key signature of E major?', 'answer' => '4 sharps: F♯ C♯ G♯ D♯.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="From" :options="['key' => 'A key', 'count' => 'A number of sharps or flats']" selected="key" />
        <div data-show-when="by:key">
            <x-calc.field name="tonic" label="Key (tonic)" value="E" type="text" inputmode="text" />
        </div>
        <div data-show-when="by:key">
            <x-calc.select name="mode" label="Mode" :options="['major' => 'Major', 'minor' => 'Minor']" selected="major" />
        </div>
        <div data-show-when="by:count">
            <x-calc.field name="count" label="Sharps (+) or flats (−)" value="3" step="any" />
        </div>
    </div>

    <x-calc.result label="Key signature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'key', 'tonic' => 'E', 'mode' => 'major', 'count' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'accidentals' => ['label' => 'Accidentals in order'],
            'relative' => ['label' => 'Relative key'],
            'parallel' => ['label' => 'Parallel key'],
            'scale' => ['label' => 'Scale'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
