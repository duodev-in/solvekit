<x-calc.page
    title="Infectious Disease and Epidemic Calculator (SIR Model) - SolveKit"
    description="Free epidemic calculator: the SIR model of an outbreak from population, R₀, infectious period and initial cases, with the peak, final size and herd immunity threshold."
    lede="Model an epidemic with SIR."
    about="The Kermack–McKendrick SIR model splits a population into Susceptible, Infected and Recovered: β = R₀ ÷ infectious days and γ = 1 ÷ infectious days. Growth stops once 1 − 1/R₀ of people are immune (the herd immunity threshold), but the epidemic overshoots: the final size z solves z = 1 − e^(−R₀ z). It is a teaching model without interventions. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'sir', 'fields' => ['population', 'r0', 'days', 'initial', 'horizon']]"
    :how-to="[
        ['name' => 'Enter population and R₀', 'text' => ''],
        ['name' => 'Enter the infectious period and initial cases', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How large is an outbreak with R₀ 2.5 in a million people?', 'answer' => '892,645 people (89.3% of the population; peak of 233,307 infected at once on day 56).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="population" label="Population" value="1000000" min="0" step="1" />
        <x-calc.field name="r0" label="R₀" value="2.5" min="0" step="0.1" />
        <x-calc.field name="days" label="Infectious period" value="7" min="0" step="any" suffix="days" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="initial" label="Initial infected" value="10" min="0" step="1" />
        <x-calc.field name="horizon" label="Days to model" value="200" min="0" step="1" suffix="days" />
    </div>

    <x-calc.result label="Total infected (final size)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['population' => 1000000, 'r0' => 2.5, 'days' => 7, 'initial' => 10, 'horizon' => 200],
        'Flu-like' => ['population' => 500000, 'r0' => 1.4, 'days' => 4, 'initial' => 50, 'horizon' => 300],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Infected over time" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'herd' => ['label' => 'Herd immunity'],
            'peak' => ['label' => 'Peak'],
            'beta' => ['label' => 'Rates'],
            'note' => ['label' => 'Assumptions'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dS/dt = −βSI, dI/dt = βSI − γI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
