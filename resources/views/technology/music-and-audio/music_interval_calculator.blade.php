<x-calc.page
    title="Music Interval Calculator - SolveKit"
    description="Free music interval calculator: interval name between two notes, with semitones, ratio and inversion."
    lede="Name a music interval."
    about="Intervals are named by the letter distance (third, fifth) and quality (major, minor, perfect)."
    :calc="['engine' => 'tc-music', 'tool' => 'interval', 'fields' => ['a', 'b'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is C4 to G4?', 'answer' => 'A perfect fifth.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Lower note" value="C4" type="text" inputmode="text" />
        <x-calc.field name="b" label="Upper note" value="G4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Interval" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 'C4', 'b' => 'G4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'semitones' => ['label' => 'Semitones'],
            'ratio' => ['label' => 'Equal-tempered ratio'],
            'just' => ['label' => 'Nearest simple ratio (just)'],
            'cents' => ['label' => 'Cents'],
            'inversion' => ['label' => 'Inversion'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
