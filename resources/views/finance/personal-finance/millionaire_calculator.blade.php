<x-calc.page
    title="Millionaire Calculator - SolveKit"
    description="Free Millionaire Calculator: n = ln[(FV × r + PMT) ÷ (PV × r + PMT)] ÷ ln(1 + r). How long monthly saving and growth take to reach a goal (monthly compounding)."
    lede="Work out the years to reach the goal from your figures."
    about="How long monthly saving and growth take to reach a goal (monthly compounding). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'millionaire', 'fields' => ['saved', 'monthly', 'ret', 'goal']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Saved now, Monthly saving, Annual return, Goal.'],
        ['name' => 'Read the result', 'text' => 'The years to reach the goal appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the years to reach the goal?', 'answer' => 'N = ln[(FV × r + PMT) ÷ (PV × r + PMT)] ÷ ln(1 + r).'],
        ['question' => 'What is the years to reach the goal for saved now $25,000, monthly saving $800, annual return 7%, goal $1,000,000?', 'answer' => '27.91 years.'],
        ['question' => 'And for saved now $0, monthly saving $1,500, annual return 6%, goal $1,000,000?', 'answer' => '24.5 years.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Returns are not guaranteed; use a cautious rate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="saved" label="Saved now" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="monthly" label="Monthly saving" value="800" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ret" label="Annual return" value="7" step="any" suffix="%" />
        <x-calc.field name="goal" label="Goal" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Years to reach the goal" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['saved' => 25000, 'monthly' => 800, 'ret' => 7, 'goal' => 1000000],
        'Example B' => ['saved' => 0, 'monthly' => 1500, 'ret' => 6, 'goal' => 1000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = ln[(FV × r + PMT) ÷ (PV × r + PMT)] ÷ ln(1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
