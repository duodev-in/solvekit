<x-calc.page
    title="Game Score Calculator – Basketball Performance Indicator - SolveKit"
    description="Free basketball Game Score calculator: John Hollinger’s single-game rating from a box score."
    lede="Rate a game with Game Score."
    about="Game Score turns a box-score line into one number on a points-like scale: 10 is an average game, 40 an outstanding one."
    :calc="['engine' => 'sp-ball', 'tool' => 'game_score', 'fields' => ['PTS', 'FG', 'FGA', 'FT', 'FTA', 'ORB', 'DRB', 'STL', 'AST', 'BLK', 'PF', 'TOV'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Game Score of the example line?', 'answer' => '20.8.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="PTS" label="Points" value="25" min="0" step="any" />
        <x-calc.field name="FG" label="Field goals made" value="9" min="0" step="any" />
        <x-calc.field name="FGA" label="Field-goal attempts" value="18" min="0" step="any" />
        <x-calc.field name="FT" label="Free throws made" value="5" min="0" step="any" />
        <x-calc.field name="FTA" label="Free-throw attempts" value="6" min="0" step="any" />
        <x-calc.field name="ORB" label="Offensive rebounds" value="2" min="0" step="any" />
        <x-calc.field name="DRB" label="Defensive rebounds" value="6" min="0" step="any" />
        <x-calc.field name="STL" label="Steals" value="2" min="0" step="any" />
        <x-calc.field name="AST" label="Assists" value="5" min="0" step="any" />
        <x-calc.field name="BLK" label="Blocks" value="1" min="0" step="any" />
        <x-calc.field name="PF" label="Personal fouls" value="3" min="0" step="any" />
        <x-calc.field name="TOV" label="Turnovers" value="3" min="0" step="any" />
    </div>

    <x-calc.result label="Game Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['PTS' => 25, 'FG' => 9, 'FGA' => 18, 'FT' => 5, 'FTA' => 6, 'ORB' => 2, 'DRB' => 6, 'STL' => 2, 'AST' => 5, 'BLK' => 1, 'PF' => 3, 'TOV' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'band' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
