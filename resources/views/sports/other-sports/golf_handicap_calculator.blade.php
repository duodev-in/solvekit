<x-calc.page
    title="Golf Handicap Calculator - SolveKit"
    description="Free golf handicap calculator: World Handicap System index from your scores, and course handicap."
    lede="Find your Handicap Index."
    about="The World Handicap System averages your best score differentials (8 of the last 20), each adjusted for course rating and slope."
    :calc="['engine' => 'sp-misc', 'tool' => 'golf_handicap', 'fields' => ['rounds', 'cr', 'slope', 'par'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What index do the example rounds give?', 'answer' => '12.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="rounds" label="Rounds: adjusted gross score, course rating, slope (one per line, newest first)" value="88, 71.2, 128
92, 70.4, 125
85, 71.2, 128
90, 72.0, 131
87, 70.4, 125
91, 71.2, 128" rows="6" />
        <x-calc.field name="cr" label="Course rating of the tee you play next (optional)" value="71.2" min="0" step="any" />
        <x-calc.field name="slope" label="Slope of that tee (optional)" value="128" min="55" step="any" />
        <x-calc.field name="par" label="Par of that course (optional)" value="72" min="0" step="any" />
    </div>

    <x-calc.result label="Handicap Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rounds' => '88, 71.2, 128
92, 70.4, 125
85, 71.2, 128
90, 72.0, 131
87, 70.4, 125
91, 71.2, 128', 'cr' => 71.2, 'slope' => 128, 'par' => 72],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'used' => ['label' => 'Differentials used'],
            'course' => ['label' => 'Course handicap for the next tee'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
