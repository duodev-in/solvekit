<x-calc.page
    title="Bonferroni Correction Calculator - SolveKit"
    description="Free Bonferroni correction calculator: corrected α for multiple tests, with Holm and Šidák and which p-values survive."
    lede="Correct for multiple comparisons."
    about="Running many tests raises the chance of a false positive. The Bonferroni correction tests each at α divided by the number of tests."
    :calc="['engine' => 'st-inf', 'tool' => 'bonferroni', 'fields' => ['alpha', 'm', 'pvalues'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the corrected α for 5 tests at 0.05?', 'answer' => '0.01.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="alpha" label="Family-wise α" value="0.05" min="0" step="any" />
        <x-calc.field name="m" label="Number of tests" value="5" min="1" step="any" />
        <x-calc.textarea name="pvalues" label="p-values (optional, one per test)" value="0.003, 0.012, 0.02, 0.04, 0.3" rows="3" />
    </div>

    <x-calc.result label="Bonferroni-corrected α" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['alpha' => 0.05, 'm' => 5, 'pvalues' => '0.003, 0.012, 0.02, 0.04, 0.3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sidak' => ['label' => 'Šidák α'],
            'bonf' => ['label' => 'Significant (Bonferroni)'],
            'holm' => ['label' => 'Significant (Holm)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Each p-value" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
