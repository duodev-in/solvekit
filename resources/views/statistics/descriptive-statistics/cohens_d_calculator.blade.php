<x-calc.page
    title="Cohen's D Calculator - SolveKit"
    description="Free Cohen's d calculator: standardised mean difference with Hedges' g and a confidence interval."
    lede="Find Cohen's d."
    about="Cohen's d is the difference between two means divided by their pooled standard deviation."
    :calc="['engine' => 'st-desc', 'tool' => 'cohens_d', 'fields' => ['m1', 's1', 'n1', 'm2', 's2', 'n2'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is d in the example?', 'answer' => '0.78958.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m1" label="Mean of group 1" value="24.5" step="any" />
        <x-calc.field name="s1" label="SD of group 1" value="4.2" min="0" step="any" />
        <x-calc.field name="n1" label="Size of group 1" value="30" min="2" step="any" />
        <x-calc.field name="m2" label="Mean of group 2" value="21.3" step="any" />
        <x-calc.field name="s2" label="SD of group 2" value="3.9" min="0" step="any" />
        <x-calc.field name="n2" label="Size of group 2" value="30" min="2" step="any" />
    </div>

    <x-calc.result label="Cohen’s d" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m1' => 24.5, 's1' => 4.2, 'n1' => 30, 'm2' => 21.3, 's2' => 3.9, 'n2' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g' => ['label' => 'Hedges’ g'],
            'ci' => ['label' => '95% CI for d'],
            'sp' => ['label' => 'Pooled SD'],
            'size' => ['label' => 'Size'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
