<x-calc.page
    title="Note Frequency Calculator - SolveKit"
    description="Free note frequency calculator: frequency of any note (A4 = 440 Hz or your tuning) and the note for a frequency."
    lede="Find a note’s frequency."
    about="In equal temperament each semitone multiplies the frequency by the twelfth root of two."
    :calc="['engine' => 'tc-music', 'tool' => 'note_frequency', 'fields' => ['by', 'note', 'freq', 'a4'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What frequency is A4?', 'answer' => '440 Hz at standard tuning.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="From" :options="['note' => 'A note', 'freq' => 'A frequency']" selected="note" />
        <div data-show-when="by:note">
            <x-calc.field name="note" label="Note with octave" value="A4" type="text" inputmode="text" />
        </div>
        <div data-show-when="by:freq">
            <x-calc.field name="freq" label="Frequency (Hz)" value="445" min="0" step="any" />
        </div>
        <x-calc.field name="a4" label="A4 tuning (Hz)" value="440" min="1" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'note', 'note' => 'A4', 'freq' => 445, 'a4' => 440],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'midi' => ['label' => 'MIDI note number'],
            'cents' => ['label' => 'Cents from the nearest note'],
            'wavelength' => ['label' => 'Wavelength in air (20 °C)'],
            'period' => ['label' => 'Period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
