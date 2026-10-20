<x-calc.page
    title="Upper Control Limit Calculator - SolveKit"
    description="Free upper control limit calculator: UCL, LCL and centre line for X̄–R, X̄–S and individuals control charts."
    lede="Find control limits."
    about="Control limits sit three standard errors either side of the process mean. Points outside them signal a special cause."
    :calc="['engine' => 'st-dist', 'tool' => 'ucl', 'fields' => ['chart', 'subgroups', 'values', 'mean', 'sd', 'n', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'statistics' => collect(config('statistics_data'))->only(['control_charts'])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the UCL for the example subgroups?', 'answer' => '10.37898 (LCL 9.83102).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="chart" label="Chart" :options="['xbar_r' => 'X̄ and R (subgroups)', 'xbar_s' => 'X̄ and S (subgroups)', 'imr' => 'Individuals and moving range', 'summary' => 'From a mean, SD and subgroup size']" selected="xbar_r" />
        <div data-show-when="chart:xbar_r,xbar_s">
            <x-calc.textarea name="subgroups" label="Subgroups: one per line" value="10.2, 10.4, 9.9, 10.1, 10.0
10.3, 10.1, 10.2, 9.8, 10.0
9.9, 10.0, 10.2, 10.1, 10.3
10.1, 10.4, 10.0, 9.9, 10.2" rows="4" />
        </div>
        <div data-show-when="chart:imr">
            <x-calc.textarea name="values" label="Individual values" value="20.1, 19.8, 20.4, 20.0, 19.7, 20.3, 20.2, 19.9, 20.5, 20.0" rows="3" />
        </div>
        <div data-show-when="chart:summary">
            <x-calc.field name="mean" label="Process mean" value="50" step="any" />
        </div>
        <div data-show-when="chart:summary">
            <x-calc.field name="sd" label="Process standard deviation" value="2" min="0" step="any" />
        </div>
        <div data-show-when="chart:summary">
            <x-calc.field name="n" label="Subgroup size" value="4" min="1" step="any" />
        </div>
        <x-calc.field name="k" label="Sigma multiplier" value="3" min="0" step="any" />
    </div>

    <x-calc.result label="Upper control limit (UCL)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['chart' => 'xbar_r', 'subgroups' => '10.2, 10.4, 9.9, 10.1, 10.0
10.3, 10.1, 10.2, 9.8, 10.0
9.9, 10.0, 10.2, 10.1, 10.3
10.1, 10.4, 10.0, 9.9, 10.2', 'values' => '20.1, 19.8, 20.4, 20.0, 19.7, 20.3, 20.2, 19.9, 20.5, 20.0', 'mean' => 50, 'sd' => 2, 'n' => 4, 'k' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Control chart" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'centre' => ['label' => 'Centre line'],
            'lcl' => ['label' => 'Lower control limit (LCL)'],
            'spread' => ['label' => 'Spread chart limits'],
            'out' => ['label' => 'Points outside the limits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
