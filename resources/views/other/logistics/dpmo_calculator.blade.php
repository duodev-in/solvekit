<x-calc.page
    title="DPMO Calculator - SolveKit"
    description="Free DPMO calculator: defects per million opportunities, sigma level and yield."
    lede="Find DPMO and sigma level."
    about="DPMO counts defects per million chances for a defect; Six Sigma quality is 3.4 DPMO."
    :calc="['engine' => 'ot-misc', 'tool' => 'dpmo', 'fields' => ['defects', 'units', 'opps'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the DPMO in the example?', 'answer' => '850 (sigma 4.638).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="defects" label="Defects found" value="34" min="0" step="any" />
        <x-calc.field name="units" label="Units inspected" value="5000" min="1" step="any" />
        <x-calc.field name="opps" label="Defect opportunities per unit" value="8" min="1" step="any" />
    </div>

    <x-calc.result label="DPMO" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['defects' => 34, 'units' => 5000, 'opps' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sigma' => ['label' => 'Sigma level (with 1.5σ shift)'],
            'yield' => ['label' => 'Process yield'],
            'dpu' => ['label' => 'Defects per unit'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
