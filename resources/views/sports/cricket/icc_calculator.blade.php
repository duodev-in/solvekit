<x-calc.page
    title="ICC Calculator - SolveKit"
    description="Free ICC rankings calculator: rating points each team earns from an ODI or T20I match."
    lede="Find ICC ranking points for a match."
    about="ICC team ratings are total points divided by matches. Each match earns points from the opponent’s rating, with a different rule when the ratings are 40 or more apart."
    :calc="['engine' => 'sp-ball', 'tool' => 'icc_rating', 'fields' => ['ra', 'rb', 'result'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does team A earn by beating a side rated 105?', 'answer' => '155 points.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ra" label="Team A rating" value="115" min="0" step="any" />
        <x-calc.field name="rb" label="Team B rating" value="105" min="0" step="any" />
        <x-calc.select name="result" label="Result" :options="['a' => 'Team A won', 'b' => 'Team B won', 'tie' => 'Tie or no result with a result decided']" selected="a" />
    </div>

    <x-calc.result label="Points earned by team A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ra' => 115, 'rb' => 105, 'result' => 'a'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pb' => ['label' => 'Points earned by team B'],
            'gap' => ['label' => 'Rating gap'],
            'rule' => ['label' => 'Rule used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
