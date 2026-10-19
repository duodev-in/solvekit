<x-calc.page
    title="Post Judgment Interest Calculator - SolveKit"
    description="Free post-judgment interest calculator: interest on a court judgment at the federal rate (compounded annually) or a state simple rate."
    lede="Work out interest on a court judgment."
    about="Federal courts use the weekly average 1-year constant-maturity Treasury yield for the week before the judgment, computed daily and compounded annually (28 U.S.C. 1961). Most states set a fixed statutory rate, usually simple interest. Enter the rate that applies to your judgment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'post_judgment', 'fields' => ['amount', 'rate', 'days', 'method']]"
    :how-to="[
        ['name' => 'Enter the judgment and rate', 'text' => ''],
        ['name' => 'Enter days and method', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What interest has a $100,000 federal judgment at 3.75% earned after 400 days?', 'answer' => '$4,123.07.'],
        ['question' => 'And at a 9% state simple rate?', 'answer' => '$9,863.01.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Judgment amount" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="3.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Days since judgment" value="400" min="0" step="1" suffix="days" />
        <x-calc.select name="method" label="Method" :options="['federal' => 'Federal (compounded annually)', 'simple' => 'Simple interest (state)']" selected="federal" />
    </div>

    <x-calc.result label="Post-judgment interest" />

    <x-calc.options :decimals="false" :examples="[
        'Federal' => ['amount' => 100000, 'rate' => 3.75, 'days' => 400, 'method' => 'federal'],
        'State 9%' => ['amount' => 100000, 'rate' => 9, 'days' => 400, 'method' => 'simple'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'daily' => ['label' => 'Interest per day'],
            'total' => ['label' => 'Judgment plus interest'],
            'years' => ['label' => 'Years'],
            'basis' => ['label' => 'Rate basis'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>federal: A[(1 + r)^y × (1 + r × f) − 1]</li>
            <li>state: A × r × days ÷ 365</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
