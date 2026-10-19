<x-calc.page
    title="Savings Goal Calculator - SolveKit"
    description="Free savings goal calculator: monthly deposit needed to reach a savings goal by a date, counting what you already have and interest."
    lede="Find how much to save each month for a goal."
    about="The monthly deposit solves goal = S(1 + r)^n + PMT[(1 + r)^n − 1] ÷ r, where S is current savings, r the monthly rate and n the number of months. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'goal', 'fields' => ['goal', 'saved', 'years', 'rate']]"
    :how-to="[
        ['name' => 'Enter the goal and time', 'text' => ''],
        ['name' => 'Add current savings and rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much a month to reach $20,000 in 4 years with $5,000 saved at 4%?', 'answer' => '$272.02.'],
        ['question' => 'And with nothing saved?', 'answer' => '$384.91.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="goal" label="Goal" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="saved" label="Saved now" value="5000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="4" min="0" step="any" suffix="years" />
        <x-calc.field name="rate" label="Interest rate" value="4" step="any" suffix="%" />
    </div>

    <x-calc.result label="Save each month" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['goal' => 20000, 'saved' => 5000, 'years' => 4, 'rate' => 4],
        'From zero' => ['goal' => 20000, 'saved' => 0, 'years' => 4, 'rate' => 4],
        'House deposit' => ['goal' => 60000, 'saved' => 15000, 'years' => 5, 'rate' => 4.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'deposits' => ['label' => 'Total deposits'],
            'interest' => ['label' => 'Interest earned'],
            'weekly' => ['label' => 'Per week'],
            'grown' => ['label' => 'Current savings grow to'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = [goal − S(1 + r)^n] × r ÷ [(1 + r)^n − 1]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
