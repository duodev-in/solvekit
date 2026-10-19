<x-calc.page
    title="Optimal Price Calculator - SolveKit"
    description="Free optimal price calculator: the profit-maximizing price for linear demand Q = a − bP and a constant marginal cost (MR = MC)."
    lede="Find the profit-maximizing price."
    about="With linear demand Q = a − bP, revenue is P(a − bP) and marginal revenue equals marginal cost at P* = (a ÷ b + MC) ÷ 2. At the optimum, the markup over cost relates to demand elasticity: (P − MC) ÷ P = 1 ÷ |ε|. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'optimal_price', 'fields' => ['a', 'b', 'mc', 'fixed']]"
    :how-to="[
        ['name' => 'Enter the demand curve', 'text' => ''],
        ['name' => 'Enter marginal cost', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What price maximizes profit for Q = 10,000 − 100P with $30 cost?', 'answer' => '$65.00, selling 3,500.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Demand intercept a (units at price 0)" value="10000" step="any" />
        <x-calc.field name="b" label="Demand slope b (units lost per $1)" value="100" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mc" label="Marginal cost" value="30" step="0.01" suffix="$" />
        <x-calc.field name="fixed" label="Fixed costs (optional)" value="50000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Profit-maximizing price" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => 10000, 'b' => 100, 'mc' => 30, 'fixed' => 50000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'quantity' => ['label' => 'Quantity sold'],
            'profit' => ['label' => 'Profit'],
            'elasticity' => ['label' => 'Price elasticity'],
            'markup' => ['label' => 'Margin over cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P* = (a/b + MC) ÷ 2</li>
            <li>Q* = a − bP*</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
