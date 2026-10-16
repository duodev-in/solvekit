<x-calc.page
    title="Population Growth Calculator - SolveKit"
    description="Free population growth calculator: exponential and logistic growth from starting size, growth rate, carrying capacity and time."
    lede="Project a population with exponential or logistic growth."
    about="Exponential growth N = N₀eʳᵗ assumes unlimited resources. Logistic growth slows as the population nears the carrying capacity K. r is the per-capita growth rate per unit of time; use the same time unit for r and t."
    :calc="['engine' => 'ecology', 'tool' => 'population_growth', 'fields' => ['model', 'start', 'rate', 'time', 'capacity']]"
    :how-to="[
        ['name' => 'Pick a model', 'text' => 'Exponential or logistic.'],
        ['name' => 'Enter N₀, r and t', 'text' => 'Use the same time unit for r and t.'],
        ['name' => 'Add K', 'text' => 'For logistic growth.'],
    ]"
    :faqs="[
        ['question' => 'What is r?', 'answer' => 'Births minus deaths per individual per unit time.'],
        ['question' => 'What is carrying capacity?', 'answer' => 'The largest population the environment can sustain.'],
        ['question' => 'How long to double?', 'answer' => 'ln 2 ÷ r while growth is still exponential.'],
    ]"
>
    <x-calc.segmented name="model" legend="Model" :options="['exponential' => 'Exponential', 'logistic' => 'Logistic']" selected="logistic" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting population N₀" value="100" min="0" />
        <x-calc.field name="rate" label="Growth rate r (per unit time)" value="0.1" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="time" label="Time t" value="24" min="0" />
        <div data-show-when="model:logistic">
            <x-calc.field name="capacity" label="Carrying capacity K" value="1000" min="0" />
        </div>
    </div>

    <x-calc.result label="Population" />

    <x-calc.options :examples="[
        'Logistic K = 1000' => ['model' => 'logistic', 'start' => 100, 'rate' => 0.1, 'time' => 24, 'capacity' => 1000],
        'Exponential 5%' => ['model' => 'exponential', 'start' => 50, 'rate' => 0.05, 'time' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'doubling' => ['label' => 'Doubling time (early)'],
            'change' => ['label' => 'Change'],
        ]" />
        <x-calc.quick-ref heading="Over time" name="quick-ref" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = N₀ × eʳᵗ</li>
            <li>N = K ÷ (1 + ((K − N₀) ÷ N₀) × e^(−rt))</li>
            <li>doubling = ln 2 ÷ r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
