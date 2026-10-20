<x-calc.page
    title="Assist to Turnover Ratio Calculator - SolveKit"
    description="Free assist-to-turnover ratio calculator for basketball."
    lede="Find the assist-to-turnover ratio."
    about="The assist-to-turnover ratio shows how well a playmaker creates without giving the ball away. Above 3 is elite."
    :calc="['engine' => 'sp-ball', 'tool' => 'ast_to', 'fields' => ['AST', 'TOV'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 8 assists to 3 turnovers?', 'answer' => '2.67.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="AST" label="Assists" value="8" min="0" step="any" />
        <x-calc.field name="TOV" label="Turnovers" value="3" min="0" step="any" />
    </div>

    <x-calc.result label="Assist-to-turnover ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['AST' => 8, 'TOV' => 3],
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
