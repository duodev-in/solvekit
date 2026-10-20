<x-calc.page
    title="Magic Number Calculator - SolveKit"
    description="Free magic number calculator: wins and rival losses a leader needs to clinch."
    lede="Find a team’s magic number."
    about="The magic number counts how many combined leader wins and second-place losses clinch the title: games + 1 − leader wins − second-place losses."
    :calc="['engine' => 'sp-ball', 'tool' => 'magic_number', 'fields' => ['G', 'W', 'L2'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the magic number in the example?', 'answer' => '13.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="G" label="Games in the season" value="162" min="1" step="any" />
        <x-calc.field name="W" label="Leader’s wins" value="90" min="0" step="any" />
        <x-calc.field name="L2" label="Second team’s losses" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Magic number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['G' => 162, 'W' => 90, 'L2' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tragic' => ['label' => 'Meaning'],
            'clinched' => ['label' => 'Status'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
