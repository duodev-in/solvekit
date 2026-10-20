<x-calc.page
    title="Heart Rate Zone Calculator - SolveKit"
    description="Free heart rate zone calculator: five training zones by Karvonen or percentage of maximum."
    lede="Find your heart-rate zones."
    about="Training zones divide your heart-rate range into five bands, from easy recovery to all-out efforts."
    :calc="['engine' => 'sp-fit', 'tool' => 'hr_zones', 'fields' => ['age', 'formula', 'max', 'rest', 'method'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the maximum used for age 35?', 'answer' => '183.5 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="1" step="any" />
        <x-calc.select name="formula" label="Maximum heart rate from" :options="['tanaka' => 'Tanaka (208 − 0.7 × age)', 'fox' => 'Fox (220 − age)', 'gulati' => 'Gulati, women (206 − 0.88 × age)', 'nes' => 'Nes (211 − 0.64 × age)', 'known' => 'A measured maximum']" selected="tanaka" />
        <div data-show-when="formula:known">
            <x-calc.field name="max" label="Measured maximum heart rate" value="185" min="1" step="any" />
        </div>
        <div data-show-when="method:karvonen">
            <x-calc.field name="rest" label="Resting heart rate (for Karvonen)" value="60" min="0" step="any" />
        </div>
        <x-calc.select name="method" label="Method" :options="['karvonen' => 'Karvonen (heart-rate reserve)', 'pct' => 'Percentage of maximum']" selected="karvonen" />
    </div>

    <x-calc.result label="Maximum heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 35, 'formula' => 'tanaka', 'max' => 185, 'rest' => 60, 'method' => 'karvonen'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Training zones" name="zones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
