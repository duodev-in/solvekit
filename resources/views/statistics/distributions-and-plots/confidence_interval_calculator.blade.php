<x-calc.page
    title="Confidence Interval Calculator - SolveKit"
    description="Free confidence interval calculator: intervals for a mean (t or z) or a proportion (Wilson) at any confidence level, from summaries or raw data."
    lede="Find a confidence interval."
    about="A confidence interval gives a range of plausible values for a population parameter: estimate ± critical value × standard error. Also known as 90% Confidence Interval Calculator, 95% Confidence Interval Calculator and 99% Confidence Interval Calculator."
    :calc="['engine' => 'st-dist', 'tool' => 'confidence_interval', 'fields' => ['mode', 'mean', 's', 'n', 'data', 'x', 'nprop', 'conf'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the 95% interval for a mean of 50, s = 8, n = 25?', 'answer' => '46.6978 to 53.3022.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Data" :options="['mean_s' => 'Mean with sample SD (t)', 'mean_sigma' => 'Mean with known σ (z)', 'data' => 'Raw data (t)', 'prop' => 'A proportion']" selected="mean_s" />
        <div data-show-when="mode:mean_s,mean_sigma">
            <x-calc.field name="mean" label="Sample mean" value="50" step="any" />
        </div>
        <div data-show-when="mode:mean_s,mean_sigma">
            <x-calc.field name="s" label="Standard deviation" value="8" min="0" step="any" />
        </div>
        <div data-show-when="mode:mean_s,mean_sigma">
            <x-calc.field name="n" label="Sample size" value="25" min="1" step="any" />
        </div>
        <div data-show-when="mode:data">
            <x-calc.textarea name="data" label="Data" value="48, 52, 51, 47, 55, 50, 49, 53, 46, 54" rows="3" />
        </div>
        <div data-show-when="mode:prop">
            <x-calc.field name="x" label="Successes" value="42" min="0" step="any" />
        </div>
        <div data-show-when="mode:prop">
            <x-calc.field name="nprop" label="Sample size" value="120" min="1" step="any" />
        </div>
        <x-calc.field name="conf" label="Confidence level (%)" value="95" min="0" step="any" />
    </div>

    <x-calc.result label="Confidence interval" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'mean_s', 'mean' => 50, 's' => 8, 'n' => 25, 'data' => '48, 52, 51, 47, 55, 50, 49, 53, 46, 54', 'x' => 42, 'nprop' => 120, 'conf' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'centre' => ['label' => 'Point estimate'],
            'moe' => ['label' => 'Margin of error'],
            'crit' => ['label' => 'Critical value'],
            'se' => ['label' => 'Standard error'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
