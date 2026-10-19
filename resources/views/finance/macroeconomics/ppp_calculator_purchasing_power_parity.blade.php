<x-calc.page
    title="PPP Calculator — Purchasing Power Parity - SolveKit"
    description="Free PPP calculator: implied purchasing power parity exchange rate from the price of the same basket in two countries, and over- or undervaluation against the market rate."
    lede="Compare currencies by purchasing power."
    about="Absolute PPP: the exchange rate that equalizes prices, PPP = price in country B ÷ price in country A. If the market rate (B per A) is above PPP, currency B is undervalued. The World Bank publishes official PPP conversion factors; enter one as the price ratio to convert incomes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'ppp', 'fields' => ['price_a', 'price_b', 'rate', 'income']]"
    :how-to="[
        ['name' => 'Enter the basket price in both countries', 'text' => ''],
        ['name' => 'Enter the market rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'A Big Mac costs $5.79 in the US and ¥480 in Japan with ¥150 per dollar. Is the yen undervalued?', 'answer' => 'Implied PPP 82.9: Currency B is undervalued by 44.73% against the market rate 150.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price_a" label="Basket price in country A (A currency)" value="5.79" step="0.01" suffix="$" />
        <x-calc.field name="price_b" label="Same basket in country B (B currency)" value="480" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Market exchange rate (B per 1 A)" value="150" min="0" step="any" />
        <x-calc.field name="income" label="Income in currency B (optional)" value="5000000" min="0" step="any" />
    </div>

    <x-calc.result label="Implied PPP exchange rate (B per A)" />

    <x-calc.options :decimals="false" :examples="[
        'Big Mac' => ['price_a' => 5.79, 'price_b' => 480, 'rate' => 150, 'income' => 5000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'implied' => ['label' => 'PPP rate'],
            'valuation' => ['label' => 'Valuation of currency B'],
            'income' => ['label' => 'Income at PPP'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PPP = P_B ÷ P_A</li>
            <li>valuation = PPP ÷ market − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
