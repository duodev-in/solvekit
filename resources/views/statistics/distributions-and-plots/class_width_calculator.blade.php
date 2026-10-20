<x-calc.page
    title="Class Width Calculator - SolveKit"
    description="Free class width calculator: the width of each class for a frequency table, with Sturges’ rule and class limits."
    lede="Find the class width."
    about="Class width = (maximum − minimum) ÷ number of classes, rounded up so that the classes cover all the data."
    :calc="['engine' => 'st-dist', 'tool' => 'class_width', 'fields' => ['data', 'min', 'max', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What class width suits the example data in 5 classes?', 'answer' => '13.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (or leave blank and enter min and max)" value="12, 15, 22, 27, 31, 34, 38, 41, 45, 48, 52, 55, 61, 66, 72" rows="3" />
        <x-calc.field name="min" label="Minimum (if no data)" value="12" step="any" />
        <x-calc.field name="max" label="Maximum (if no data)" value="72" step="any" />
        <x-calc.field name="k" label="Number of classes (0 = Sturges’ rule)" value="5" min="0" step="any" />
    </div>

    <x-calc.result label="Class width" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '12, 15, 22, 27, 31, 34, 38, 41, 45, 48, 52, 55, 61, 66, 72', 'min' => 12, 'max' => 72, 'k' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'raw' => ['label' => 'Exact (max − min) ÷ k'],
            'k' => ['label' => 'Classes'],
            'sturges' => ['label' => 'Sturges’ suggestion'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Class limits" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
