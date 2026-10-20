<x-calc.page
    title="Histogram Calculator - SolveKit"
    description="Free histogram maker: a histogram of your data with Sturges, Scott, Freedman–Diaconis or your own bin width."
    lede="Draw a histogram."
    about="A histogram shows how data are spread by counting values in equal-width bins. The bin width changes how the shape looks."
    :calc="['engine' => 'st-dist', 'tool' => 'histogram', 'fields' => ['data', 'rule', 'width', 'start'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many bins does Sturges’ rule give for the example?', 'answer' => '7.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data" value="4.2, 5.1, 5.5, 5.8, 6.0, 6.1, 6.3, 6.4, 6.6, 6.8, 7.0, 7.1, 7.3, 7.5, 7.9, 8.2, 8.6, 9.4" rows="3" />
        <x-calc.select name="rule" label="Bins" :options="['sturges' => 'Sturges (1 + log₂ n)', 'sqrt' => 'Square root (√n)', 'scott' => 'Scott (3.49 s n^−⅓)', 'fd' => 'Freedman–Diaconis (2 IQR n^−⅓)', 'width' => 'My own width']" selected="sturges" />
        <div data-show-when="rule:width">
            <x-calc.field name="width" label="Bin width" value="1" min="0" step="any" />
        </div>
        <x-calc.field name="start" label="First bin starts at (optional)" value="4" step="any" />
    </div>

    <x-calc.result label="Bins" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '4.2, 5.1, 5.5, 5.8, 6.0, 6.1, 6.3, 6.4, 6.6, 6.8, 7.0, 7.1, 7.3, 7.5, 7.9, 8.2, 8.6, 9.4', 'rule' => 'sturges', 'width' => 1, 'start' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Histogram" name="hist" />
        <x-calc.rows heading="Details" :rows="[
            'width' => ['label' => 'Bin width'],
            'n' => ['label' => 'Values'],
            'tallest' => ['label' => 'Tallest bin'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Bin counts" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
