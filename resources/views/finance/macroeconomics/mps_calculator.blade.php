<x-calc.page
    title="MPS Calculator - SolveKit"
    description="Free MPS Calculator: MPS = ΔS ÷ ΔY. The share of extra income saved."
    lede="Work out the marginal propensity to save from change in saving and change in income."
    about="The share of extra income saved. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'mps', 'fields' => ['ds', 'dy']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Change in saving, Change in income.'],
        ['name' => 'Read the result', 'text' => 'The marginal propensity to save appears as you type, with MPC, spending multiplier below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the marginal propensity to save?', 'answer' => 'MPS = ΔS ÷ ΔY.'],
        ['question' => 'What is the marginal propensity to save for change in saving $200, change in income $1,000?', 'answer' => '0.2. MPC: 0.8.'],
        ['question' => 'And for change in saving $90, change in income $600?', 'answer' => '0.15. MPC: 0.85.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The simple multiplier is 1 ÷ MPS.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ds" label="Change in saving" value="200" step="0.01" suffix="$" />
        <x-calc.field name="dy" label="Change in income" value="1000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Marginal propensity to save" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ds' => 200, 'dy' => 1000],
        'Example B' => ['ds' => 90, 'dy' => 600],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'MPC'],
            'r2' => ['label' => 'Spending multiplier'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MPS = ΔS ÷ ΔY</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
