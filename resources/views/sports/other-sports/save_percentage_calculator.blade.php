<x-calc.page
    title="Save Percentage Calculator - SolveKit"
    description="Free save percentage calculator: baseball relievers’ saves converted."
    lede="Find a closer’s save percentage."
    about="A reliever’s save percentage is saves divided by save opportunities."
    :calc="['engine' => 'sp-ball', 'tool' => 'save_pct', 'fields' => ['SV', 'BS'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 35 saves and 5 blown?', 'answer' => '87.5%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="SV" label="Saves" value="35" min="0" step="any" />
        <x-calc.field name="BS" label="Blown saves" value="5" min="0" step="any" />
    </div>

    <x-calc.result label="Save percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['SV' => 35, 'BS' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'opp' => ['label' => 'Save opportunities'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
