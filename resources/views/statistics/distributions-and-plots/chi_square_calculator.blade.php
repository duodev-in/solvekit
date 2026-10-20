<x-calc.page
    title="Chi-Square Calculator - SolveKit"
    description="Free chi-square calculator: goodness-of-fit and independence tests, or a p-value from a χ² statistic, with expected counts."
    lede="Run a chi-square test."
    about="The χ² statistic measures how far observed counts are from the counts expected under a hypothesis."
    :calc="['engine' => 'st-dist', 'tool' => 'chi_square', 'fields' => ['mode', 'observed', 'expected', 'table', 'yates', 'chi', 'df'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is χ² for the example counts?', 'answer' => '4.32 (p = 0.228919).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Calculate" :options="['gof' => 'Goodness of fit (observed vs expected)', 'independence' => 'Test of independence (contingency table)', 'dist' => 'p-value from a χ² value']" selected="gof" />
        <div data-show-when="mode:gof">
            <x-calc.textarea name="observed" label="Observed counts" value="18, 22, 30, 30" rows="3" />
        </div>
        <div data-show-when="mode:gof">
            <x-calc.textarea name="expected" label="Expected counts or proportions (blank = equal)" value="25, 25, 25, 25" rows="3" />
        </div>
        <div data-show-when="mode:independence">
            <x-calc.textarea name="table" label="Table: one row per line" value="12, 5, 9
7, 14, 6" rows="3" />
        </div>
        <div data-show-when="mode:independence">
            <x-calc.select name="yates" label="Yates’ continuity correction (2 × 2 only)" :options="['no' => 'No', 'yes' => 'Yes']" selected="no" />
        </div>
        <div data-show-when="mode:dist">
            <x-calc.field name="chi" label="χ² value" value="3.84" min="0" step="any" />
        </div>
        <div data-show-when="mode:dist">
            <x-calc.field name="df" label="Degrees of freedom" value="1" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="χ² statistic" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'gof', 'observed' => '18, 22, 30, 30', 'expected' => '25, 25, 25, 25', 'table' => '12, 5, 9
7, 14, 6', 'yates' => 'no', 'chi' => 3.84, 'df' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="χ² distribution (shaded: p-value)" name="dist" />
        <x-calc.rows heading="Details" :rows="[
            'df' => ['label' => 'Degrees of freedom'],
            'p' => ['label' => 'p-value'],
            'crit' => ['label' => 'Critical value (α = 0.05)'],
            'effect' => ['label' => 'Effect size'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Expected counts" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
