<x-calc.page
    title="Chebyshev's Theorem Calculator - SolveKit"
    description="Free Chebyshev's theorem calculator: the minimum share of any data set within k standard deviations of the mean."
    lede="Apply Chebyshev's theorem."
    about="Chebyshev's inequality holds for every distribution: at least 1 − 1/k² of the values lie within k standard deviations of the mean."
    :calc="['engine' => 'st-prob', 'tool' => 'chebyshev', 'fields' => ['mode', 'k', 'mean', 'sd', 'lo', 'hi'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What share lies within 2 SD?', 'answer' => 'At least 75%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Given" :options="['k' => 'Number of standard deviations k', 'range' => 'Mean, SD and a range']" selected="k" />
        <div data-show-when="mode:k">
            <x-calc.field name="k" label="k (more than 1)" value="2" step="any" />
        </div>
        <div data-show-when="mode:range">
            <x-calc.field name="mean" label="Mean" value="100" step="any" />
        </div>
        <div data-show-when="mode:range">
            <x-calc.field name="sd" label="Standard deviation" value="15" min="0" step="any" />
        </div>
        <div data-show-when="mode:range">
            <x-calc.field name="lo" label="Lower limit" value="70" step="any" />
        </div>
        <div data-show-when="mode:range">
            <x-calc.field name="hi" label="Upper limit" value="130" step="any" />
        </div>
    </div>

    <x-calc.result label="At least this share is within k SD" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'k', 'k' => 2, 'mean' => 100, 'sd' => 15, 'lo' => 70, 'hi' => 130],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'k'],
            'outside' => ['label' => 'At most outside'],
            'normal' => ['label' => 'Share if the data were normal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
