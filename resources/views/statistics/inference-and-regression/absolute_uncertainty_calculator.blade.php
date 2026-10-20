<x-calc.page
    title="Absolute Uncertainty Calculator - SolveKit"
    description="Free absolute uncertainty calculator: ± uncertainty from a relative uncertainty or from repeated readings."
    lede="Find the absolute uncertainty."
    about="Absolute uncertainty is the ± amount in the units of the measurement. It equals the relative uncertainty times the value."
    :calc="['engine' => 'st-inf', 'tool' => 'abs_uncertainty', 'fields' => ['mode', 'value', 'rel', 'data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is 25.4 with 2% uncertainty?', 'answer' => '25.4 ± 0.508.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['relative' => 'A value and its relative (%) uncertainty', 'readings' => 'Repeated readings']" selected="relative" />
        <div data-show-when="mode:relative">
            <x-calc.field name="value" label="Measured value" value="25.4" step="any" />
        </div>
        <div data-show-when="mode:relative">
            <x-calc.field name="rel" label="Relative uncertainty (%)" value="2" min="0" step="any" />
        </div>
        <div data-show-when="mode:readings">
            <x-calc.textarea name="data" label="Readings" value="9.8, 10.1, 9.9, 10.3, 10.0" rows="3" />
        </div>
    </div>

    <x-calc.result label="Result with absolute uncertainty" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'relative', 'value' => 25.4, 'rel' => 2, 'data' => '9.8, 10.1, 9.9, 10.3, 10.0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'abs' => ['label' => 'Absolute uncertainty'],
            'rel' => ['label' => 'Relative uncertainty'],
            'se' => ['label' => 'Standard error (readings)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
