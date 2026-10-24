<x-calc.page
    title="Gender Pay Gap Calculator - SolveKit"
    description="Free gender pay gap calculator: the pay gap between men and women and the Equal Pay Day it implies."
    lede="Find the gender pay gap."
    about="The gender pay gap compares the average (or median) pay of men and women."
    :calc="['engine' => 'ot-misc', 'tool' => 'gender_pay_gap', 'fields' => ['men', 'women'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What gap do 52,000 and 45,000 give?', 'answer' => '13.46%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="men" label="Average (or median) pay of men" value="52000" min="0" step="any" suffix="$" />
        <x-calc.field name="women" label="Average (or median) pay of women" value="45000" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Gender pay gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['men' => 52000, 'women' => 45000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Women earn per 1 earned by men'],
            'days' => ['label' => 'Days in a year worked “unpaid”'],
            'equalPay' => ['label' => 'Equal Pay Day (this gap)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
