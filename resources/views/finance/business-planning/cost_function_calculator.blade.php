<x-calc.page
    title="Cost Function Calculator - SolveKit"
    description="Free cost function calculator: total, average, average fixed, average variable and marginal cost from a linear or quadratic cost function."
    lede="Evaluate a cost function."
    about="C(Q) = FC + VC × Q (+ a Q² for rising marginal cost). Average cost = C ÷ Q; marginal cost = dC/dQ = VC + 2aQ. With a quadratic term, average cost is lowest at Q = √(FC ÷ a). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'cost_function', 'fields' => ['fixed', 'variable', 'quadratic', 'quantity']]"
    :how-to="[
        ['name' => 'Enter the cost function', 'text' => ''],
        ['name' => 'Enter the quantity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the cost of 1,500 units with C = 10,000 + 12Q + 0.002Q²?', 'answer' => '$32,500.00; marginal cost $18.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fixed" label="Fixed cost" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="variable" label="Variable cost per unit" value="12" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="quadratic" label="Quadratic coefficient a (optional)" value="0.002" step="any" />
        <x-calc.field name="quantity" label="Quantity" value="1500" min="0" step="any" />
    </div>

    <x-calc.result label="Total cost" />

    <x-calc.options :decimals="false" :examples="[
        'Quadratic' => ['fixed' => 10000, 'variable' => 12, 'quadratic' => 0.002, 'quantity' => 1500],
        'Linear' => ['fixed' => 10000, 'variable' => 12, 'quadratic' => 0, 'quantity' => 1500],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Total cost" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'average' => ['label' => 'Average cost'],
            'afc' => ['label' => 'Average fixed cost'],
            'avc' => ['label' => 'Average variable cost'],
            'marginal' => ['label' => 'Marginal cost'],
            'minimum' => ['label' => 'Lowest average cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C = FC + VC Q + a Q²</li>
            <li>MC = VC + 2aQ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
