<x-calc.page
    title="Chord Progression Generator - SolveKit"
    description="Free chord progression generator: chords for Roman-numeral progressions in any key, with their notes."
    lede="Build a chord progression."
    about="Roman numerals describe chords by their scale degree, so a progression works in any key."
    :calc="['engine' => 'tc-music', 'tool' => 'progression', 'fields' => ['key', 'mode', 'preset', 'custom'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is I–V–vi–IV in C?', 'answer' => 'C – G – Am – F.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="key" label="Key" value="C" type="text" inputmode="text" />
        <x-calc.select name="mode" label="Mode" :options="['major' => 'Major', 'minor' => 'Minor']" selected="major" />
        <x-calc.select name="preset" label="Progression" :options="['pop' => 'I – V – vi – IV (pop)', 'doo' => 'I – vi – IV – V (50s)', 'jazz' => 'ii7 – V7 – Imaj7 (jazz)', 'canon' => 'I – V – vi – iii – IV – I – IV – V (Pachelbel)', 'minor' => 'i – VI – III – VII (minor pop)', 'andalusian' => 'i – ♭VII – ♭VI – V (Andalusian)', 'custom' => 'My own Roman numerals']" selected="pop" />
        <div data-show-when="preset:custom">
            <x-calc.field name="custom" label="Roman numerals (e.g. I vi ii V7)" value="I vi ii V7" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Chords" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['key' => 'C', 'mode' => 'major', 'preset' => 'pop', 'custom' => 'I vi ii V7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'numerals' => ['label' => 'Roman numerals'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Notes of each chord" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
