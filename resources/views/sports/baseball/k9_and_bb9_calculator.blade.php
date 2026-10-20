<x-calc.page
    title="K/9 and BB/9 Calculator - SolveKit"
    description="Free K/9 and BB/9 calculator: strikeouts and walks per nine innings, with K/BB."
    lede="Find strikeouts and walks per nine."
    about="Rates per nine innings let pitchers with different workloads be compared."
    :calc="['engine' => 'sp-ball', 'tool' => 'k9', 'fields' => ['K', 'BB', 'IP'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is K/9 for 200 strikeouts in 190 innings?', 'answer' => '9.47.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="K" label="Strikeouts" value="200" min="0" step="any" />
        <x-calc.field name="BB" label="Walks" value="50" min="0" step="any" />
        <x-calc.field name="IP" label="Innings pitched (6.1 = 6⅓)" value="190" min="0" step="any" />
    </div>

    <x-calc.result label="Strikeouts per nine (K/9)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['K' => 200, 'BB' => 50, 'IP' => 190],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bb9' => ['label' => 'Walks per nine (BB/9)'],
            'kbb' => ['label' => 'Strikeout-to-walk ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
