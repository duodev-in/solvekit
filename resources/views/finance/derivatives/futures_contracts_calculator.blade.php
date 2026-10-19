<x-calc.page
    title="Futures Contracts Calculator - SolveKit"
    description="Free Futures Contracts Calculator: P/L = (exit − entry) × multiplier × contracts. Futures profit depends on the price move times the contract multiplier (the E-mini S&P 500 is $50 a point)."
    lede="Work out the profit or loss from your figures."
    about="Futures profit depends on the price move times the contract multiplier (the E-mini S&P 500 is $50 a point). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'futures_contracts', 'fields' => ['entry', 'exit', 'multiplier', 'contracts']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Entry price, Exit price, Contract multiplier, Contracts (negative for short).'],
        ['name' => 'Read the result', 'text' => 'The profit or loss appears as you type, with per contract, notional value at entry below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the profit or loss?', 'answer' => 'P/L = (exit − entry) × multiplier × contracts.'],
        ['question' => 'What is the profit or loss for entry price 5,200, exit price 5,250, contract multiplier 50, contracts 2?', 'answer' => '$5,000.00. Per contract: $2,500.00.'],
        ['question' => 'And for entry price 78.4, exit price 76.9, contract multiplier 1,000, contracts -3?', 'answer' => '$4,500.00. Per contract: −$1,500.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Fees and slippage are not included.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="entry" label="Entry price" value="5200" step="any" />
        <x-calc.field name="exit" label="Exit price" value="5250" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="multiplier" label="Contract multiplier" value="50" step="any" />
        <x-calc.field name="contracts" label="Contracts (negative for short)" value="2" step="any" />
    </div>

    <x-calc.result label="Profit or loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['entry' => 5200, 'exit' => 5250, 'multiplier' => 50, 'contracts' => 2],
        'Example B' => ['entry' => 78.4, 'exit' => 76.9, 'multiplier' => 1000, 'contracts' => -3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Per contract'],
            'r2' => ['label' => 'Notional value at entry'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P/L = (exit − entry) × multiplier × contracts</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
