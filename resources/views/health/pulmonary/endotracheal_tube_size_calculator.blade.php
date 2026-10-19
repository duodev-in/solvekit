<x-calc.page
    title="Endotracheal Tube Size Calculator - SolveKit"
    description="Free endotracheal tube size calculator: cuffed and uncuffed ETT size and insertion depth for children by age (Cole formula), and typical adult sizes."
    lede="Estimate endotracheal tube size."
    about="For children aged 1 and over: uncuffed tube = age ÷ 4 + 4 mm (Cole), cuffed = age ÷ 4 + 3.5 mm, and oral depth ≈ age ÷ 2 + 12 cm (or 3 × the tube size). Typical adult sizes are 7.0–7.5 mm for women and 7.5–8.0 mm for men. Always have a half-size above and below ready. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'ett', 'fields' => ['group', 'age', 'sex']]"
    :how-to="[
        ['name' => 'Choose child or adult', 'text' => ''],
        ['name' => 'Enter age', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What size tube for a 6-year-old?', 'answer' => '5.0 mm cuffed (Uncuffed 5.5 mm (Cole formula); oral depth about 15 cm).'],
    ]"
>
    <x-calc.segmented name="group" legend="Patient" :options="['child' => 'Child (1–16)', 'adult' => 'Adult']" selected="child" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="group:child">
            <x-calc.field name="age" label="Age" value="6" min="0" step="1" suffix="years" />
        </div>
        <div data-show-when="group:adult" hidden>
            <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        </div>
    </div>

    <x-calc.result label="Endotracheal tube" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['group' => 'child', 'age' => 6, 'sex' => 'male'],
        'Adult woman' => ['group' => 'adult', 'age' => 6, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'depth' => ['label' => 'Insertion depth'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cuffed = age ÷ 4 + 3.5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
