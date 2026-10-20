<x-calc.page
    title="Youden Index Calculator - SolveKit"
    description="Free Youden index calculator: J = sensitivity + specificity − 1, and the best cut-off from several."
    lede="Find Youden’s J."
    about="Youden’s J summarises a diagnostic test in one number and helps choose the best cut-off."
    :calc="['engine' => 'st-inf', 'tool' => 'youden', 'fields' => ['mode', 'sens', 'spec', 'rows'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is J for 85% sensitivity and 78% specificity?', 'answer' => '0.63.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['single' => 'Sensitivity and specificity', 'cutoffs' => 'Several cut-offs']" selected="single" />
        <div data-show-when="mode:single">
            <x-calc.field name="sens" label="Sensitivity (%)" value="85" min="0" step="any" />
        </div>
        <div data-show-when="mode:single">
            <x-calc.field name="spec" label="Specificity (%)" value="78" min="0" step="any" />
        </div>
        <div data-show-when="mode:cutoffs">
            <x-calc.textarea name="rows" label="Cut-offs: value, sensitivity %, specificity %" value="5, 98, 40
10, 92, 62
15, 85, 78
20, 70, 88
25, 52, 95" rows="5" />
        </div>
    </div>

    <x-calc.result label="Youden’s J" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'single', 'sens' => 85, 'spec' => 78, 'rows' => '5, 98, 40
10, 92, 62
15, 85, 78
20, 70, 88
25, 52, 95'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'best' => ['label' => 'Best cut-off'],
            'meaning' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="J for each cut-off" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
