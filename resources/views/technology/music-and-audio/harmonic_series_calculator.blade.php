<x-calc.page
    title="Harmonic Series Calculator - SolveKit"
    description="Free harmonic series calculator: frequencies of the harmonics of a note, with the nearest notes and cents."
    lede="List the harmonic series."
    about="A vibrating string or air column also sounds whole-number multiples of its fundamental."
    :calc="['engine' => 'tc-music', 'tool' => 'harmonic_series', 'fields' => ['fundamental', 'count', 'a4'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the fundamental of A2?', 'answer' => '110 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fundamental" label="Fundamental (note or Hz)" value="A2" type="text" inputmode="text" />
        <x-calc.field name="count" label="Harmonics" value="16" min="1" step="any" />
        <x-calc.field name="a4" label="A4 tuning (Hz)" value="440" min="1" step="any" />
    </div>

    <x-calc.result label="Fundamental" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fundamental' => 'A2', 'count' => 16, 'a4' => 440],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nyquist' => ['label' => 'Highest harmonic shown'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Harmonics" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
