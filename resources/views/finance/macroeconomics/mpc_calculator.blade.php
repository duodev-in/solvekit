<x-calc.page
    title="MPC Calculator - SolveKit"
    description="Free MPC Calculator: MPC = ΔC ÷ ΔY. The MPC is the share of extra income spent; MPC + MPS = 1."
    lede="Work out the marginal propensity to consume from change in consumption and change in income."
    about="The MPC is the share of extra income spent; MPC + MPS = 1. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'mpc', 'fields' => ['dc', 'dy']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Change in consumption, Change in income.'],
        ['name' => 'Read the result', 'text' => 'The marginal propensity to consume appears as you type, with MPS, spending multiplier below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the marginal propensity to consume?', 'answer' => 'MPC = ΔC ÷ ΔY.'],
        ['question' => 'What is the marginal propensity to consume for change in consumption $800, change in income $1,000?', 'answer' => '0.8. MPS: 0.2.'],
        ['question' => 'And for change in consumption $450, change in income $600?', 'answer' => '0.75. MPS: 0.25.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A higher MPC means a bigger spending multiplier.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dc" label="Change in consumption" value="800" step="0.01" suffix="$" />
        <x-calc.field name="dy" label="Change in income" value="1000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Marginal propensity to consume" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['dc' => 800, 'dy' => 1000],
        'Example B' => ['dc' => 450, 'dy' => 600],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'MPS'],
            'r2' => ['label' => 'Spending multiplier'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MPC = ΔC ÷ ΔY</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
