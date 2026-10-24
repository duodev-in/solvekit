<x-calc.page
    title="Music Transposition Calculator - SolveKit"
    description="Free music transposition calculator: concert pitch to written pitch for B♭, E♭ and F instruments, and back."
    lede="Transpose for an instrument."
    about="Transposing instruments read notes that sound lower than written, so parts must be written up."
    :calc="['engine' => 'tc-music', 'tool' => 'transposition', 'fields' => ['notes', 'instrument', 'direction', 'semis'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does a B♭ trumpet read for concert C D E F G?', 'answer' => 'D4 E4 F♯4 G4 A4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="notes" label="Notes" value="C4 D4 E4 F4 G4" rows="3" />
        <x-calc.select name="instrument" label="Instrument" :options="['bb' => 'B♭ clarinet, trumpet, soprano sax (sounds a major 2nd lower)', 'bbTenor' => 'B♭ tenor sax (sounds a major 9th lower)', 'eb' => 'E♭ alto sax (sounds a major 6th lower)', 'ebBari' => 'E♭ baritone sax (sounds an octave and a major 6th lower)', 'f' => 'F horn, cor anglais (sounds a perfect 5th lower)', 'a' => 'A clarinet (sounds a minor 3rd lower)', 'guitar' => 'Guitar, bass (sound an octave lower)', 'semis' => 'By a number of semitones']" selected="bb" />
        <x-calc.select name="direction" label="Convert" :options="['toWritten' => 'Concert pitch → written for the instrument', 'toConcert' => 'Written → concert pitch']" selected="toWritten" />
        <div data-show-when="instrument:semis">
            <x-calc.field name="semis" label="Semitones (up +)" value="2" step="any" />
        </div>
    </div>

    <x-calc.result label="Transposed notes" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['notes' => 'C4 D4 E4 F4 G4', 'instrument' => 'bb', 'direction' => 'toWritten', 'semis' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'interval' => ['label' => 'Interval used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
