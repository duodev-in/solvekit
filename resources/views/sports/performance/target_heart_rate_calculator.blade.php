<x-calc.page
    title="Target Heart Rate Calculator - SolveKit"
    description="Free target heart rate calculator: the heart-rate range for a chosen exercise intensity (Karvonen)."
    lede="Find your target heart rate."
    about="Karvonen’s method sets targets within your heart-rate reserve, the gap between resting and maximum."
    :calc="['engine' => 'sp-fit', 'tool' => 'target_hr', 'fields' => ['age', 'formula', 'max', 'rest', 'lo', 'hi'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 60–80% at age 35, resting 60?', 'answer' => '134–159 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="1" step="any" />
        <x-calc.select name="formula" label="Maximum heart rate from" :options="['tanaka' => 'Tanaka (208 − 0.7 × age)', 'fox' => 'Fox (220 − age)', 'gulati' => 'Gulati, women (206 − 0.88 × age)', 'nes' => 'Nes (211 − 0.64 × age)', 'known' => 'A measured maximum']" selected="tanaka" />
        <div data-show-when="formula:known">
            <x-calc.field name="max" label="Measured maximum heart rate" value="185" min="1" step="any" />
        </div>
        <x-calc.field name="rest" label="Resting heart rate (for Karvonen)" value="60" min="0" step="any" />
        <x-calc.field name="lo" label="Intensity from (%)" value="60" min="0" step="any" />
        <x-calc.field name="hi" label="Intensity to (%)" value="80" min="0" step="any" />
    </div>

    <x-calc.result label="Target heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 35, 'formula' => 'tanaka', 'max' => 185, 'rest' => 60, 'lo' => 60, 'hi' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'max' => ['label' => 'Maximum heart rate'],
            'pct' => ['label' => 'Simple % of maximum'],
            'per10' => ['label' => 'Beats in 10 seconds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
