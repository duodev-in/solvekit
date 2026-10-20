<x-calc.page
    title="Percentile Rank Calculator - SolveKit"
    description="Free percentile rank calculator: the percentage of a data set below a value."
    lede="Find a percentile rank."
    about="A percentile rank gives the percentage of values below a score, counting ties as half."
    :calc="['engine' => 'st-desc', 'tool' => 'percentile_rank', 'fields' => ['data', 'value'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the percentile rank of 74 in the example?', 'answer' => '55.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="55, 62, 68, 70, 70, 74, 78, 81, 85, 92" rows="3" />
        <x-calc.field name="value" label="Value" value="74" step="any" />
    </div>

    <x-calc.result label="Percentile rank" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '55, 62, 68, 70, 70, 74, 78, 81, 85, 92', 'value' => 74],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'below' => ['label' => 'Values below'],
            'equal' => ['label' => 'Values equal'],
            'strict' => ['label' => 'Share strictly below'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
