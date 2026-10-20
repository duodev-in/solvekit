<x-calc.page
    title="GAA Calculator (Goals Against Average) - SolveKit"
    description="Free GAA calculator: goals against average per game."
    lede="Find goals against average."
    about="GAA is goals allowed per full game, scaled by minutes played."
    :calc="['engine' => 'sp-ball', 'tool' => 'gaa', 'fields' => ['GA', 'MIN', 'len'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the GAA for 120 goals in 3,600 minutes?', 'answer' => '2.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="GA" label="Goals against" value="120" min="0" step="any" />
        <x-calc.field name="MIN" label="Minutes played" value="3600" min="1" step="any" />
        <x-calc.select name="len" label="Game length" :options="['32' => '32 minutes (high school)', '48' => '48 minutes', '60' => '60 minutes (ice hockey)', '90' => '90 minutes (football)']" selected="60" />
    </div>

    <x-calc.result label="Goals against average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['GA' => 120, 'MIN' => 3600, 'len' => '60'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'games' => ['label' => 'Full games played'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
