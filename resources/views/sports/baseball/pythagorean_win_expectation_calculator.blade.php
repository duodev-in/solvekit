<x-calc.page
    title="Pythagorean Win Expectation Calculator - SolveKit"
    description="Free Pythagorean expectation calculator: expected winning percentage from runs scored and allowed."
    lede="Find expected wins from runs."
    about="Bill James found that runs scored and allowed predict a team’s record: RS² ÷ (RS² + RA²), refined to an exponent of about 1.83."
    :calc="['engine' => 'sp-ball', 'tool' => 'pythagorean', 'fields' => ['RS', 'RA', 'G', 'W', 'exp'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How many wins do 800 runs scored and 700 allowed suggest?', 'answer' => '90.85.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="RS" label="Runs scored" value="800" min="0" step="any" />
        <x-calc.field name="RA" label="Runs allowed" value="700" min="0" step="any" />
        <x-calc.field name="G" label="Games" value="162" min="1" step="any" />
        <x-calc.field name="W" label="Actual wins (optional)" value="92" min="0" step="any" />
        <x-calc.field name="exp" label="Exponent" value="1.83" min="0.5" step="any" />
    </div>

    <x-calc.result label="Expected winning percentage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['RS' => 800, 'RA' => 700, 'G' => 162, 'W' => 92, 'exp' => 1.83],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wins' => ['label' => 'Expected wins'],
            'luck' => ['label' => 'Actual minus expected'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
