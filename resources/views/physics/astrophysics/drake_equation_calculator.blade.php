<x-calc.page
    title="Drake Equation Calculator - SolveKit"
    description="Free Drake equation calculator: estimate the number of communicating civilisations in the Milky Way with your own or preset values."
    lede="Evaluate the Drake equation."
    about="Frank Drake’s 1961 equation organises our ignorance about extraterrestrial life into seven factors. Their product is the number of civilisations signalling at any one time."
    :calc="['engine' => 'ph-astro', 'tool' => 'drake', 'fields' => ['preset', 'Rs', 'fp', 'ne', 'fl', 'fi', 'fc', 'L'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does the middle-of-the-road set give?', 'answer' => '12.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="preset" label="Values" :options="['custom' => 'Your own values', 'pessimistic' => 'Pessimistic', 'middle' => 'Middle of the road', 'optimistic' => 'Optimistic']" selected="middle" />
        <div data-show-when="preset:custom">
            <x-calc.field name="Rs" label="R*: new stars per year in the Milky Way" value="1.5" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fp" label="f_p: share of stars with planets" value="1" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="ne" label="n_e: habitable planets per such system" value="0.4" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fl" label="f_l: share that develop life" value="0.1" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fi" label="f_i: share that develop intelligence" value="0.1" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="fc" label="f_c: share that communicate" value="0.2" min="0" step="any" />
        </div>
        <div data-show-when="preset:custom">
            <x-calc.field name="L" label="L: years a civilisation communicates" value="10000" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Communicating civilisations in the Milky Way" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['preset' => 'middle', 'Rs' => 1.5, 'fp' => 1, 'ne' => 0.4, 'fl' => 0.1, 'fi' => 0.1, 'fc' => 0.2, 'L' => 10000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'values' => ['label' => 'Factors used'],
            'note' => ['label' => 'Caveat'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
