<x-calc.page
    title="ERA Calculator – Earned Run Average - SolveKit"
    description="Free ERA calculator: earned run average from earned runs and innings pitched, with innings written as 6.1 and 6.2."
    lede="Find a pitcher’s ERA."
    about="ERA is the earned runs a pitcher allows per nine innings. Innings are written in thirds: 6.1 means 6⅓ innings and 6.2 means 6⅔."
    :calc="['engine' => 'sp-ball', 'tool' => 'era', 'fields' => ['ER', 'IP', 'G'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the ERA for 60 earned runs in 180 innings?', 'answer' => '3.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ER" label="Earned runs" value="60" min="0" step="any" />
        <x-calc.field name="IP" label="Innings pitched (6.1 = 6⅓)" value="180" min="0" step="any" />
        <x-calc.field name="G" label="Innings in a game" value="9" min="1" step="any" />
    </div>

    <x-calc.result label="Earned run average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ER' => 60, 'IP' => 180, 'G' => 9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ip' => ['label' => 'Innings as a number'],
            'band' => ['label' => 'Rating (9-inning games)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
