<x-calc.page
    title="P-Hat Calculator - SolveKit"
    description="Free p-hat calculator: the sample proportion p̂ = x/n with its standard error and Wilson confidence interval."
    lede="Find the sample proportion."
    about="p̂ (p-hat) is the share of successes in a sample, x ÷ n. It estimates the population proportion p."
    :calc="['engine' => 'st-prob', 'tool' => 'p_hat', 'fields' => ['x', 'n', 'conf'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is p̂ for 42 successes in 120?', 'answer' => '0.35.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Successes x" value="42" min="0" step="any" />
        <x-calc.field name="n" label="Sample size n" value="120" min="1" step="any" />
        <x-calc.field name="conf" label="Confidence for the interval (%)" value="95" min="0" step="any" />
    </div>

    <x-calc.result label="Sample proportion p̂" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 42, 'n' => 120, 'conf' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'q' => ['label' => 'q̂ = 1 − p̂'],
            'se' => ['label' => 'Standard error'],
            'wilson' => ['label' => 'Wilson interval'],
            'wald' => ['label' => 'Wald interval'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
