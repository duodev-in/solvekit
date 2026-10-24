<x-calc.page
    title="SGPA to CGPA Calculator - SolveKit"
    description="Free SGPA to CGPA calculator: cumulative GPA from semester GPAs weighted by credits."
    lede="Combine semester GPAs."
    about="CGPA weights each semester’s SGPA by its credits."
    :calc="['engine' => 'ot-edu', 'tool' => 'sgpa_cgpa', 'fields' => ['sems'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What CGPA do the example semesters give?', 'answer' => '8.362.'],
    ]"
>
    <x-calc.textarea name="sems" label="Semesters: SGPA, credits (one per line)" value="8.2, 22
7.9, 24
8.6, 23
8.8, 21" rows="4" />

    <x-calc.result label="CGPA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sems' => '8.2, 22
7.9, 24
8.6, 23
8.8, 21'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'credits' => ['label' => 'Total credits'],
            'simple' => ['label' => 'Simple average of SGPAs'],
            'cbse' => ['label' => 'Percentage at × 9.5 (CBSE rule)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
