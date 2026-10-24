<x-calc.page
    title="Pay Gap Calculator - SolveKit"
    description="Free pay gap calculator: the percentage gap between two pay levels and the raise needed to close it."
    lede="Find a pay gap."
    about="A pay gap compares two groups’ average pay as a share of the higher one."
    :calc="['engine' => 'ot-misc', 'tool' => 'pay_gap', 'fields' => ['higher', 'lower'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What gap do 60,000 and 48,000 give?', 'answer' => '20%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="higher" label="Higher-paid group’s average pay" value="60000" min="0" step="any" suffix="$" />
        <x-calc.field name="lower" label="Lower-paid group’s average pay" value="48000" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Pay gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['higher' => 60000, 'lower' => 48000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'amount' => ['label' => 'Difference per year'],
            'ratio' => ['label' => 'Lower ÷ higher'],
            'raise' => ['label' => 'Raise needed to close it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
