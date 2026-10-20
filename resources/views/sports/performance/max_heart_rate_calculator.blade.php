<x-calc.page
    title="Max Heart Rate Calculator - SolveKit"
    description="Free max heart rate calculator: maximum heart rate by Tanaka, Fox, Gulati and Nes formulas."
    lede="Estimate maximum heart rate."
    about="Maximum heart rate falls with age. Tanaka’s 208 − 0.7 × age fits better than the old 220 − age, but individuals differ by 10 beats or more."
    :calc="['engine' => 'sp-fit', 'tool' => 'max_hr', 'fields' => ['age', 'sex'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the maximum at 35?', 'answer' => '184 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="1" step="any" />
        <x-calc.select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Maximum heart rate (Tanaka)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 35, 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'tanaka' => ['label' => 'Tanaka (208 − 0.7 × age)'],
            'fox' => ['label' => 'Fox (220 − age)'],
            'gulati' => ['label' => 'Gulati, women (206 − 0.88 × age)'],
            'nes' => ['label' => 'Nes (211 − 0.64 × age)'],
            'note' => ['label' => 'Accuracy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
