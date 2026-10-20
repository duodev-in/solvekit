<x-calc.page
    title="Batting Average Calculator - SolveKit"
    description="Free batting average calculator: AVG from hits and at-bats, with the hits needed for a target average."
    lede="Find a batting average."
    about="Batting average is hits divided by at-bats, written to three decimals (.300). Walks, hit-by-pitches and sacrifices are not at-bats, so they do not change it."
    :calc="['engine' => 'sp-ball', 'tool' => 'batting_average', 'fields' => ['H', 'AB', 'target'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the average of 150 hits in 500 at-bats?', 'answer' => '.300.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="H" label="Hits" value="150" min="0" step="any" />
        <x-calc.field name="AB" label="At-bats" value="500" min="1" step="any" />
        <x-calc.field name="target" label="Target average (optional)" value="0.3" min="0" step="any" />
    </div>

    <x-calc.result label="Batting average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['H' => 150, 'AB' => 500, 'target' => 0.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pct' => ['label' => 'As a percentage'],
            'need' => ['label' => 'Hits for the target (same at-bats)'],
            'band' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
