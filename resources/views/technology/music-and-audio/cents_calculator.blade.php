<x-calc.page
    title="Cents Calculator - SolveKit"
    description="Free cents calculator: cents between two frequencies, ratios and cents conversions."
    lede="Measure intervals in cents."
    about="Cents divide each semitone into 100 equal steps on a logarithmic scale."
    :calc="['engine' => 'tc-music', 'tool' => 'cents', 'fields' => ['by', 'f1', 'f2', 'ratio', 'cents'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many cents from 440 to 445 Hz?', 'answer' => '19.562 cents.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="From" :options="['freqs' => 'Two frequencies', 'ratio' => 'A ratio', 'cents' => 'Cents']" selected="freqs" />
        <div data-show-when="by:freqs">
            <x-calc.field name="f1" label="First frequency (Hz)" value="440" min="0" step="any" />
        </div>
        <div data-show-when="by:freqs">
            <x-calc.field name="f2" label="Second frequency (Hz)" value="445" min="0" step="any" />
        </div>
        <div data-show-when="by:ratio">
            <x-calc.field name="ratio" label="Ratio" value="3:2" type="text" inputmode="text" />
        </div>
        <div data-show-when="by:cents">
            <x-calc.field name="cents" label="Cents" value="50" step="any" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'freqs', 'f1' => 440, 'f2' => 445, 'ratio' => '3:2', 'cents' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Frequency ratio'],
            'semitones' => ['label' => 'Semitones'],
            'nearest' => ['label' => 'Nearest equal-tempered interval'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
