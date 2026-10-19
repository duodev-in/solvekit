<x-calc.page
    title="Put-Call Parity Calculator - SolveKit"
    description="Free Put-Call Parity Calculator: C − P = S − K e^(−rT). Put-call parity links European call and put prices with the same strike and expiry (no dividends)."
    lede="Work out the implied put price from your figures."
    about="Put-call parity links European call and put prices with the same strike and expiry (no dividends). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'put_call_parity', 'fields' => ['stock', 'strike', 'rate', 't', 'call']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Stock price, Strike, Risk-free rate, Time to expiry, Call price.'],
        ['name' => 'Read the result', 'text' => 'The implied put price appears as you type, with PV of the strike below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the implied put price?', 'answer' => 'C − P = S − K e^(−rT).'],
        ['question' => 'What is the implied put price for stock price $100, strike $100, risk-free rate 5%, time to expiry 1 years, call price $10.45?', 'answer' => '$5.57. PV of the strike: $95.12.'],
        ['question' => 'And for stock price $52, strike $50, risk-free rate 4%, time to expiry 0.25 years, call price $3.40?', 'answer' => '$0.90. PV of the strike: $49.50.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A gap from parity is an arbitrage signal before costs.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stock" label="Stock price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="strike" label="Strike" value="100" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Risk-free rate" value="5" step="any" suffix="%" />
        <x-calc.field name="t" label="Time to expiry" value="1" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="call" label="Call price" value="10.45" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Implied put price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['stock' => 100, 'strike' => 100, 'rate' => 5, 't' => 1, 'call' => 10.45],
        'Example B' => ['stock' => 52, 'strike' => 50, 'rate' => 4, 't' => 0.25, 'call' => 3.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'PV of the strike'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C − P = S − K e^(−rT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
