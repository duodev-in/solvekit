<x-calc.page
    title="MET Minutes Calculator - SolveKit"
    description="Free MET-minutes calculator: weekly MET-minutes against the WHO activity guideline."
    lede="Total your weekly MET-minutes."
    about="MET-minutes multiply each activity’s intensity by its minutes. The WHO guideline of 150 minutes of moderate activity is about 600 MET-minutes a week."
    :calc="['engine' => 'sp-fit', 'tool' => 'met_minutes', 'fields' => ['list'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many MET-minutes in the example week?', 'answer' => '1,275.'],
    ]"
>
    <x-calc.textarea name="list" label="Activities: MET value, minutes per week (one per line)" value="3.5, 150
8.0, 60
6.0, 45" rows="3" />

    <x-calc.result label="MET-minutes per week" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '3.5, 150
8.0, 60
6.0, 45'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'goal' => ['label' => 'Against the WHO guideline'],
            'mod' => ['label' => 'Moderate minutes equivalent'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
