<x-calc.page
    title="LCR Calculator - SolveKit"
    description="Free LCR Calculator: LCR = HQLA ÷ 30-day net cash outflows. Basel III requires banks to hold enough high-quality liquid assets to survive 30 days of stress."
    lede="Work out the liquidity coverage ratio from high-quality liquid assets and net cash outflows over 30 days."
    about="Basel III requires banks to hold enough high-quality liquid assets to survive 30 days of stress. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'lcr', 'fields' => ['hqla', 'outflows']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'High-quality liquid assets, Net cash outflows over 30 days.'],
        ['name' => 'Read the result', 'text' => 'The liquidity coverage ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the liquidity coverage ratio?', 'answer' => 'LCR = HQLA ÷ 30-day net cash outflows.'],
        ['question' => 'What is the liquidity coverage ratio for high-quality liquid assets $120,000,000, net cash outflows over 30 days $100,000,000?', 'answer' => '120%.'],
        ['question' => 'And for high-quality liquid assets $85, net cash outflows over 30 days $100?', 'answer' => '85%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The minimum is 100%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hqla" label="High-quality liquid assets" value="120000000" step="0.01" suffix="$" />
        <x-calc.field name="outflows" label="Net cash outflows over 30 days" value="100000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Liquidity coverage ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['hqla' => 120000000, 'outflows' => 100000000],
        'Example B' => ['hqla' => 85, 'outflows' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LCR = HQLA ÷ 30-day net cash outflows</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
