<x-calc.page
    title="Black Scholes Calculator - SolveKit"
    description="Free Black–Scholes calculator: European call and put values with delta, gamma, vega, theta and rho, including a dividend yield."
    lede="Price European options with Black–Scholes."
    about="Black–Scholes–Merton: C = S e^(−qT) N(d₁) − K e^(−rT) N(d₂), P = K e^(−rT) N(−d₂) − S e^(−qT) N(−d₁), with d₁ = [ln(S/K) + (r − q + σ²/2)T] ÷ (σ√T) and d₂ = d₁ − σ√T. It assumes constant volatility and rates, and no early exercise. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'black_scholes', 'fields' => ['spot', 'strike', 'days', 'rate', 'vol', 'divyield']]"
    :how-to="[
        ['name' => 'Enter stock, strike and expiry', 'text' => ''],
        ['name' => 'Enter rate, volatility and dividend yield', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a 1-year at-the-money call worth at 5% and 20% volatility?', 'answer' => '$10.45; put $5.57.'],
        ['question' => 'What is its delta?', 'answer' => 'call 0.6368, put −0.3632.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spot" label="Stock price" value="100" step="0.01" suffix="$" />
        <x-calc.field name="strike" label="Strike" value="100" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days to expiry" value="365" min="1" step="1" suffix="days" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="Risk-free rate" value="5" step="any" suffix="%" />
        <x-calc.field name="vol" label="Volatility" value="20" step="any" suffix="%" />
        <x-calc.field name="divyield" label="Dividend yield" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Call value" />

    <x-calc.options :decimals="false" :examples="[
        'Textbook' => ['spot' => 100, 'strike' => 100, 'days' => 365, 'rate' => 5, 'vol' => 20, 'divyield' => 0],
        'Short-dated OTM' => ['spot' => 180, 'strike' => 200, 'days' => 30, 'rate' => 4.3, 'vol' => 35, 'divyield' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'put' => ['label' => 'Put value'],
            'delta' => ['label' => 'Delta'],
            'gamma' => ['label' => 'Gamma'],
            'vega' => ['label' => 'Vega'],
            'theta' => ['label' => 'Theta'],
            'rho' => ['label' => 'Rho'],
            'd' => ['label' => 'd₁, d₂'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C = Se^(−qT)N(d₁) − Ke^(−rT)N(d₂)</li>
            <li>d₁ = [ln(S/K) + (r − q + σ²/2)T] ÷ σ√T</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
