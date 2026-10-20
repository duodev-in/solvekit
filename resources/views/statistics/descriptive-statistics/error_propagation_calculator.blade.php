<x-calc.page
    title="Error Propagation Calculator - SolveKit"
    description="Free error propagation calculator: the uncertainty of any formula from the uncertainties of its inputs (GUM first-order method)."
    lede="Propagate uncertainties."
    about="Each input’s uncertainty contributes to the result in proportion to how sensitive the formula is to that input; the contributions add in quadrature."
    :calc="['engine' => 'st-desc', 'tool' => 'error_prop', 'fields' => ['formula', 'vars'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is mgh with the example uncertainties?', 'answer' => '29.43 ± 1.25.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formula" label="Formula (use the variable names below)" value="m * g * h" type="text" inputmode="text" />
        <x-calc.textarea name="vars" label="Variables: name = value ± uncertainty (one per line)" value="m = 2.50 ± 0.02
g = 9.81 ± 0.01
h = 1.20 ± 0.05" rows="3" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['formula' => 'm * g * h', 'vars' => 'm = 2.50 ± 0.02
g = 9.81 ± 0.01
h = 1.20 ± 0.05'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'u' => ['label' => 'Uncertainty (1σ)'],
            'rel' => ['label' => 'Relative uncertainty'],
            'largest' => ['label' => 'Largest contributor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Contribution of each variable" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
