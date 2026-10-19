<x-calc.page
    title="SWP Calculator — Systematic Withdrawal Plan - SolveKit"
    description="Free SWP calculator: balance left after monthly withdrawals from a mutual fund corpus, total withdrawn and how long it lasts."
    lede="See how long a corpus lasts with monthly withdrawals."
    about="Each month the withdrawal is redeemed and the rest grows at the monthly rate (annual ÷ 12). A withdrawal below the monthly return keeps the corpus intact. Each redemption is partly capital and partly gains, so tax is only on the gains part. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-india', 'tool' => 'swp', 'fields' => ['corpus', 'withdrawal', 'rate', 'years'], 'currency' => 'INR']"
    :how-to="[
        ['name' => 'Enter the corpus', 'text' => ''],
        ['name' => 'Enter withdrawal, return and years', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is left of ₹25 lakh after 15 years of ₹20,000 a month at 8%?', 'answer' => '₹13,00,401.'],
        ['question' => 'And withdrawing ₹30,000 a month?', 'answer' => 'The corpus runs out in month 121.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="corpus" label="Corpus" value="2500000" step="1" suffix="$" />
        <x-calc.field name="withdrawal" label="Monthly withdrawal" value="20000" step="1" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Expected return" value="8" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="15" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Balance at the end" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['corpus' => 2500000, 'withdrawal' => 20000, 'rate' => 8, 'years' => 15],
        'Higher withdrawal' => ['corpus' => 2500000, 'withdrawal' => 30000, 'rate' => 8, 'years' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'withdrawn' => ['label' => 'Total withdrawn'],
            'sustainable' => ['label' => 'Sustainable withdrawal'],
            'rate' => ['label' => 'Withdrawal rate'],
            'lasts' => ['label' => 'Lasts'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Bₘ₊₁ = (Bₘ − W)(1 + i)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
