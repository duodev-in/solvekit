<x-calc.page
    title="Savings Interest Rate Calculator - SolveKit"
    description="Free savings interest rate calculator: the interest rate needed for a deposit and monthly savings to reach a goal by a date."
    lede="Find the rate you need to reach a savings goal."
    about="The rate solves goal = deposit(1 + r)^n + monthly × [(1 + r)^n − 1] ÷ r, with n months and r the monthly rate. If deposits alone reach the goal, no interest is needed. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'savings_rate', 'fields' => ['deposit', 'monthly', 'goal', 'years']]"
    :how-to="[
        ['name' => 'Enter what you save', 'text' => 'Starting and monthly deposits.'],
        ['name' => 'Enter the goal', 'text' => 'And the years.'],
    ]"
    :faqs="[
        ['question' => 'What rate turns $5,000 plus $200 a month into $20,000 in 5 years?', 'answer' => '4.973%.'],
        ['question' => 'And $10,000 into $15,000 in 4 years with no deposits?', 'answer' => '10.18%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="deposit" label="Starting deposit" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="monthly" label="Monthly deposit" value="200" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="goal" label="Goal" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years" value="5" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Interest rate needed (APR)" />

    <x-calc.options :decimals="false" :examples="[
        'Goal' => ['deposit' => 5000, 'monthly' => 200, 'goal' => 20000, 'years' => 5],
        'Lump sum' => ['deposit' => 10000, 'monthly' => 0, 'goal' => 15000, 'years' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'paid' => ['label' => 'You pay in'],
            'interest' => ['label' => 'Interest needed'],
            'monthly' => ['label' => 'Monthly rate'],
            'effective' => ['label' => 'Effective annual rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>goal = D(1 + r)^n + M[(1 + r)^n − 1] ÷ r, solved for r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
