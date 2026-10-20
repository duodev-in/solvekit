<x-calc.page
    title="Process Capability Index Calculator - SolveKit"
    description="Free process capability calculator: Cp, Cpk, Cpu, Cpl and expected parts per million out of specification."
    lede="Find Cp and Cpk."
    about="Process capability compares the spread of a process with its specification limits. Cpk also penalises a mean that is off centre."
    :calc="['engine' => 'st-desc', 'tool' => 'cpk', 'fields' => ['lsl', 'usl', 'mode', 'mean', 'sd', 'data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is Cpk in the example?', 'answer' => '1.111.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lsl" label="Lower specification limit (LSL)" value="9.5" step="any" />
        <x-calc.field name="usl" label="Upper specification limit (USL)" value="10.5" step="any" />
        <x-calc.select name="mode" label="Process data" :options="['summary' => 'Mean and standard deviation', 'data' => 'Measurements']" selected="summary" />
        <div data-show-when="mode:summary">
            <x-calc.field name="mean" label="Process mean" value="10.1" step="any" />
        </div>
        <div data-show-when="mode:summary">
            <x-calc.field name="sd" label="Process standard deviation" value="0.12" min="0" step="any" />
        </div>
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="10.02, 10.11, 9.98, 10.15, 10.07, 10.21, 9.95, 10.09, 10.13, 10.04" rows="3" />
        </div>
    </div>

    <x-calc.result label="Cpk" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lsl' => 9.5, 'usl' => 10.5, 'mode' => 'summary', 'mean' => 10.1, 'sd' => 0.12, 'data' => '10.02, 10.11, 9.98, 10.15, 10.07, 10.21, 9.95, 10.09, 10.13, 10.04'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cp' => ['label' => 'Cp (potential)'],
            'cpu' => ['label' => 'Cpu'],
            'cpl' => ['label' => 'Cpl'],
            'ppm' => ['label' => 'Expected out of spec (ppm)'],
            'verdict' => ['label' => 'Rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
