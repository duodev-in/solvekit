<x-calc.page
    title="Uncertainty Calculator - SolveKit"
    description="Free measurement uncertainty calculator: mean ± standard and expanded uncertainty from repeated readings (GUM Type A)."
    lede="Find measurement uncertainty."
    about="Repeated readings give a mean and its standard uncertainty s/√n; multiplying by a coverage factor gives the expanded uncertainty."
    :calc="['engine' => 'st-desc', 'tool' => 'uncertainty', 'fields' => ['data', 'k'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What result do the example readings give?', 'answer' => '9.8057143 ± 0.013.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="9.81, 9.79, 9.83, 9.80, 9.82, 9.78, 9.81" rows="3" />
        <x-calc.field name="k" label="Coverage factor k" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '9.81, 9.79, 9.83, 9.80, 9.82, 9.78, 9.81', 'k' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'u' => ['label' => 'Standard uncertainty u = s/√n'],
            'U' => ['label' => 'Expanded uncertainty U = k·u'],
            'rel' => ['label' => 'Relative uncertainty'],
            'sd' => ['label' => 'SD of single readings'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
