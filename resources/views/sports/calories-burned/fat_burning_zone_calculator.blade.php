<x-calc.page
    title="Fat Burning Zone Calculator - SolveKit"
    description="Free fat burning zone calculator: the heart-rate range for low-intensity, fat-fuelled exercise."
    lede="Find your fat-burning zone."
    about="At 60–70% of heart-rate reserve fat supplies more of the energy. Harder sessions still burn more total calories, so both help with weight loss."
    :calc="['engine' => 'sp-fit', 'tool' => 'fat_zone', 'fields' => ['age', 'formula', 'max', 'rest'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the fat-burning zone at age 35?', 'answer' => '134–146 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="1" step="any" />
        <x-calc.select name="formula" label="Maximum heart rate from" :options="['tanaka' => 'Tanaka (208 − 0.7 × age)', 'fox' => 'Fox (220 − age)', 'gulati' => 'Gulati, women (206 − 0.88 × age)', 'nes' => 'Nes (211 − 0.64 × age)', 'known' => 'A measured maximum']" selected="tanaka" />
        <div data-show-when="formula:known">
            <x-calc.field name="max" label="Measured maximum heart rate" value="185" min="1" step="any" />
        </div>
        <x-calc.field name="rest" label="Resting heart rate (for Karvonen)" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Fat-burning zone" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 35, 'formula' => 'tanaka', 'max' => 185, 'rest' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'max' => ['label' => 'Maximum heart rate'],
            'pct' => ['label' => 'Simple % of maximum'],
            'note' => ['label' => 'About the fat-burning zone'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="All five zones (Karvonen)" name="zones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
