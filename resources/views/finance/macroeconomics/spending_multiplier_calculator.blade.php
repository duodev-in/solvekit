<x-calc.page
    title="Spending Multiplier Calculator - SolveKit"
    description="Free Spending Multiplier Calculator: k = 1 ÷ (1 − MPC). The simple Keynesian multiplier shows how a change in spending ripples through income."
    lede="Work out the spending multiplier from marginal propensity to consume and change in spending (optional)."
    about="The simple Keynesian multiplier shows how a change in spending ripples through income. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'spending_multiplier', 'fields' => ['mpc', 'spending']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Marginal propensity to consume, Change in spending (optional).'],
        ['name' => 'Read the result', 'text' => 'The spending multiplier appears as you type, with change in GDP below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the spending multiplier?', 'answer' => 'K = 1 ÷ (1 − MPC).'],
        ['question' => 'What is the spending multiplier for marginal propensity to consume 0.8, change in spending $100?', 'answer' => '5×. Change in GDP: $500.00.'],
        ['question' => 'And for marginal propensity to consume 0.6, change in spending $50?', 'answer' => '2.5×. Change in GDP: $125.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Taxes and imports make real multipliers smaller.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mpc" label="Marginal propensity to consume" value="0.8" step="any" />
        <x-calc.field name="spending" label="Change in spending (optional)" value="100" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Spending multiplier" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['mpc' => 0.8, 'spending' => 100],
        'Example B' => ['mpc' => 0.6, 'spending' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Change in GDP'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>k = 1 ÷ (1 − MPC)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
