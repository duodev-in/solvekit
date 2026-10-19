<x-calc.page
    title="Optimal Hedge Ratio Calculator - SolveKit"
    description="Free Optimal Hedge Ratio Calculator: h* = ρ × σS ÷ σF. The minimum-variance hedge ratio (Hull) chooses the futures position that most reduces the variance of the hedged position."
    lede="Work out the optimal hedge ratio from your figures."
    about="The minimum-variance hedge ratio (Hull) chooses the futures position that most reduces the variance of the hedged position. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'optimal_hedge_ratio', 'fields' => ['rho', 'sds', 'sdf', 'exposure', 'size']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Correlation of spot and futures, Standard deviation of spot, Standard deviation of futures, Exposure (units), Contract size (units).'],
        ['name' => 'Read the result', 'text' => 'The optimal hedge ratio appears as you type, with contracts below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the optimal hedge ratio?', 'answer' => 'H* = ρ × σS ÷ σF; contracts = h* × exposure ÷ contract size.'],
        ['question' => 'What is the optimal hedge ratio for correlation of spot and futures 0.9, standard deviation of spot 2.5%, standard deviation of futures 3%, exposure 1,000,000, contract size 5,000?', 'answer' => '0.75. Contracts: 150.'],
        ['question' => 'And for correlation of spot and futures 0.95, standard deviation of spot 1.8%, standard deviation of futures 2%, exposure 200,000, contract size 1,000?', 'answer' => '0.855. Contracts: 171.'],
        ['question' => 'What does the result tell me?', 'answer' => 'With ρ = 1 and equal volatilities the ratio is 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rho" label="Correlation of spot and futures" value="0.9" step="any" />
        <x-calc.field name="sds" label="Standard deviation of spot" value="2.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sdf" label="Standard deviation of futures" value="3" step="any" suffix="%" />
        <x-calc.field name="exposure" label="Exposure (units)" value="1000000" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="size" label="Contract size (units)" value="5000" step="any" />
    </div>

    <x-calc.result label="Optimal hedge ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rho' => 0.9, 'sds' => 2.5, 'sdf' => 3, 'exposure' => 1000000, 'size' => 5000],
        'Example B' => ['rho' => 0.95, 'sds' => 1.8, 'sdf' => 2, 'exposure' => 200000, 'size' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Contracts'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>h* = ρ × σS ÷ σF</li>
            <li>contracts = h* × exposure ÷ contract size</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
