<x-calc.page
    title="WHIP Calculator for Baseball - SolveKit"
    description="Free WHIP calculator: walks plus hits per inning pitched."
    lede="Find a pitcher’s WHIP."
    about="WHIP counts walks plus hits per inning: how many runners a pitcher allows. Under 1.00 is elite."
    :calc="['engine' => 'sp-ball', 'tool' => 'whip', 'fields' => ['BB', 'H', 'IP'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is WHIP for 45 walks and 160 hits in 180 innings?', 'answer' => '1.14.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="BB" label="Walks" value="45" min="0" step="any" />
        <x-calc.field name="H" label="Hits allowed" value="160" min="0" step="any" />
        <x-calc.field name="IP" label="Innings pitched (6.1 = 6⅓)" value="180" min="0" step="any" />
    </div>

    <x-calc.result label="WHIP" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['BB' => 45, 'H' => 160, 'IP' => 180],
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
