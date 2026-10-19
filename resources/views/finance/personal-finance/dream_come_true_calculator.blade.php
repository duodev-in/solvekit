<x-calc.page
    title="Dream Come True Calculator - SolveKit"
    description="Free dream come true calculator: how much to save each month to afford a dream (trip, car, home deposit) by a target date."
    lede="Find the monthly saving for your dream."
    about="Monthly saving = PMT that grows today's savings and monthly deposits into the goal: goal = S(1 + r)^n + PMT[(1 + r)^n − 1] ÷ r, with r the monthly rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'goal', 'fields' => ['goal', 'saved', 'years', 'rate']]"
    :how-to="[
        ['name' => 'Enter the cost and time', 'text' => ''],
        ['name' => 'Add savings and interest', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much a month for a $15,000 dream in 3 years with $2,000 saved at 4%?', 'answer' => '$333.81.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="goal" label="Dream cost" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="saved" label="Saved already" value="2000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years to go" value="3" min="0" step="any" suffix="years" />
        <x-calc.field name="rate" label="Interest on savings" value="4" step="any" suffix="%" />
    </div>

    <x-calc.result label="Save each month" />

    <x-calc.options :decimals="false" :examples="[
        'Trip' => ['goal' => 15000, 'saved' => 2000, 'years' => 3, 'rate' => 4],
        'Car' => ['goal' => 30000, 'saved' => 5000, 'years' => 4, 'rate' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'deposits' => ['label' => 'Total you put in'],
            'interest' => ['label' => 'Interest earned'],
            'weekly' => ['label' => 'Per week'],
            'grown' => ['label' => 'Savings grow to'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = [goal − S(1 + r)^n] × r ÷ [(1 + r)^n − 1]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
