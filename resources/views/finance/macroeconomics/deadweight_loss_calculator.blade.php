<x-calc.page
    title="Deadweight Loss Calculator - SolveKit"
    description="Free Deadweight Loss Calculator: DWL = ½ × ΔP × ΔQ. Deadweight loss is the surplus lost when a tax, tariff or price control moves the market away from equilibrium (linear curves)."
    lede="Work out the deadweight loss from your figures."
    about="Deadweight loss is the surplus lost when a tax, tariff or price control moves the market away from equilibrium (linear curves). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'deadweight_loss', 'fields' => ['p1', 'p0', 'q0', 'q1']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price with the distortion, Equilibrium price, Equilibrium quantity, Quantity with the distortion.'],
        ['name' => 'Read the result', 'text' => 'The deadweight loss appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the deadweight loss?', 'answer' => 'DWL = ½ × ΔP × ΔQ.'],
        ['question' => 'What is the deadweight loss for price with the distortion $12, equilibrium price $10, equilibrium quantity 1,000, quantity with the distortion 800?', 'answer' => '$200.00.'],
        ['question' => 'And for price with the distortion $5, equilibrium price $3, equilibrium quantity 20,000, quantity with the distortion 15,000?', 'answer' => '$5,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'For a tax, use the wedge between buyer and seller prices as ΔP.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="Price with the distortion" value="12" step="0.01" suffix="$" />
        <x-calc.field name="p0" label="Equilibrium price" value="10" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q0" label="Equilibrium quantity" value="1000" step="any" />
        <x-calc.field name="q1" label="Quantity with the distortion" value="800" step="any" />
    </div>

    <x-calc.result label="Deadweight loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['p1' => 12, 'p0' => 10, 'q0' => 1000, 'q1' => 800],
        'Example B' => ['p1' => 5, 'p0' => 3, 'q0' => 20000, 'q1' => 15000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DWL = ½ × ΔP × ΔQ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
