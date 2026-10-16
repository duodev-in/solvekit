<x-calc.page
    title="Chi-Square Test for Genetics - SolveKit"
    description="Free chi-square calculator for genetics: test observed offspring counts against an expected Mendelian ratio, with the p-value."
    lede="Test whether observed offspring counts fit an expected ratio."
    about="The χ² statistic sums (observed − expected)² ÷ expected over all classes. With classes − 1 degrees of freedom it gives a p-value; below 0.05 the counts differ significantly from the expected ratio. Expected counts should be at least 5 in each class."
    :calc="['engine' => 'genetics', 'tool' => 'chi_square', 'fields' => ['observed', 'ratio']]"
    :how-to="[
        ['name' => 'Enter the observed counts', 'text' => 'One per phenotype class.'],
        ['name' => 'Enter the expected ratio', 'text' => 'In the same order.'],
        ['name' => 'Read the p-value', 'text' => 'Below 0.05 means a poor fit.'],
    ]"
    :faqs="[
        ['question' => 'What does p > 0.05 mean?', 'answer' => 'The difference from the expected ratio is small enough to be chance.'],
        ['question' => 'How many degrees of freedom?', 'answer' => 'The number of classes minus one.'],
        ['question' => 'What were Mendel\'s pea counts?', 'answer' => '315 round yellow, 108 round green, 101 wrinkled yellow, 32 wrinkled green: χ² ≈ 0.47, a good fit to 9:3:3:1.'],
    ]"
>
    <x-calc.field name="observed" label="Observed counts" value="315, 108, 101, 32" type="text" help="Separate with commas or spaces" />

    <x-calc.field name="ratio" label="Expected ratio" value="9:3:3:1" type="text" help="Same number of parts, e.g. 3:1 or 9:3:3:1" />

    <x-calc.result label="Chi-square" />

    <x-calc.options :examples="[
        'Mendel 9:3:3:1' => ['observed' => '315, 108, 101, 32', 'ratio' => '9:3:3:1'],
        'Monohybrid 3:1' => ['observed' => '705, 224', 'ratio' => '3:1'],
        'Poor fit 1:1' => ['observed' => '70, 30', 'ratio' => '1:1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'p' => ['label' => 'p-value'],
            'df' => ['label' => 'Degrees of freedom'],
            'total' => ['label' => 'Total observed'],
        ]" />
        <x-calc.quick-ref heading="Observed and expected" name="classes" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>χ² = Σ (O − E)² ÷ E</li>
            <li>df = classes − 1</li>
            <li>p = Q(df ÷ 2, χ² ÷ 2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
