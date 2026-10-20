<x-calc.page
    title="Goalie Save Percentage Calculator - SolveKit"
    description="Free goalie save percentage calculator for hockey and football."
    lede="Find a goalie’s save percentage."
    about="Save percentage is saves divided by shots on goal."
    :calc="['engine' => 'sp-ball', 'tool' => 'goalie_save', 'fields' => ['S', 'GA'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 30 saves with 2 goals against?', 'answer' => '.938.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="S" label="Saves" value="30" min="0" step="any" />
        <x-calc.field name="GA" label="Goals against" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Save percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['S' => 30, 'GA' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shots' => ['label' => 'Shots on goal'],
            'band' => ['label' => 'Rating (ice hockey)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
