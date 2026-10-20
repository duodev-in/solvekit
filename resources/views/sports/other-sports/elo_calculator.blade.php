<x-calc.page
    title="Elo Calculator - SolveKit"
    description="Free Elo calculator: new chess rating after a game, with the expected score (FIDE)."
    lede="Update an Elo rating."
    about="Elo predicts the score between two players from their ratings and moves each rating by K × (result − expected)."
    :calc="['engine' => 'sp-misc', 'tool' => 'elo', 'fields' => ['R', 'O', 'result', 'K'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the new rating after a 1600 beats a 1700 (K 20)?', 'answer' => '1,612.8.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Your rating" value="1600" min="0" step="any" />
        <x-calc.field name="O" label="Opponent rating" value="1700" min="0" step="any" />
        <x-calc.select name="result" label="Result" :options="['0' => 'Loss', '1' => 'Win', '0.5' => 'Draw']" selected="1" />
        <x-calc.select name="K" label="K-factor" :options="['10' => '10 (rated 2400 or more)', '20' => '20 (standard)', '40' => '40 (new players, juniors under 2300)']" selected="20" />
    </div>

    <x-calc.result label="New rating" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['R' => 1600, 'O' => 1700, 'result' => '1', 'K' => '20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'E' => ['label' => 'Expected score'],
            'change' => ['label' => 'Change'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
