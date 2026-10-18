<x-calc.page
    title="Lotka-Volterra Calculator - SolveKit"
    description="Free Lotka-Volterra calculator: simulate predator–prey population cycles, with equilibrium sizes, peaks and cycle period."
    lede="Simulate predator and prey populations with the Lotka–Volterra model."
    about="Prey grow at rate α and are eaten at rate β × prey × predators; predators grow by δ × prey × predators and die at rate γ. The equations are integrated with the fourth-order Runge–Kutta method. The populations cycle around the equilibrium (γ ÷ δ prey, α ÷ β predators)."
    :calc="['engine' => 'eco-science', 'tool' => 'lotka_volterra', 'fields' => ['prey', 'predators', 'alpha', 'beta', 'gamma', 'delta', 'time']]"
    :how-to="[
        ['name' => 'Enter the starting sizes', 'text' => 'Prey and predators.'],
        ['name' => 'Set the four rates', 'text' => 'And how long to run.'],
    ]"
    :faqs="[
        ['question' => 'What does Lotka–Volterra show?', 'answer' => 'Predator and prey numbers rise and fall in linked cycles, predators lagging prey.'],
        ['question' => 'What is the equilibrium?', 'answer' => 'γ ÷ δ prey and α ÷ β predators, where both stay constant.'],
        ['question' => 'Is it realistic?', 'answer' => 'It is a simple model; real systems have limits like carrying capacity.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prey" label="Starting prey" value="10" min="0" />
        <x-calc.field name="predators" label="Starting predators" value="10" min="0" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="alpha" label="Prey growth α" value="1.1" min="0" step="0.01" />
        <x-calc.field name="beta" label="Predation β" value="0.4" min="0" step="0.01" />
        <x-calc.field name="gamma" label="Predator death γ" value="0.4" min="0" step="0.01" />
        <x-calc.field name="delta" label="Predator growth δ" value="0.1" min="0" step="0.01" />
    </div>

    <x-calc.field name="time" label="Time span" value="50" min="1" />

    <x-calc.result label="Equilibrium populations" />

    <x-calc.options :examples="[
        'Classic example' => ['prey' => 10, 'predators' => 10, 'alpha' => 1.1, 'beta' => 0.4, 'gamma' => 0.4, 'delta' => 0.1, 'time' => 50],
        'Hares and lynx' => ['prey' => 30, 'predators' => 4, 'alpha' => 0.55, 'beta' => 0.028, 'gamma' => 0.84, 'delta' => 0.026, 'time' => 40],
        'Near equilibrium' => ['prey' => 4, 'predators' => 2.75, 'alpha' => 1.1, 'beta' => 0.4, 'gamma' => 0.4, 'delta' => 0.1, 'time' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Populations over time" name="populations" />
        <x-calc.rows heading="Details" :rows="[
            'prey_max' => ['label' => 'Prey peak'],
            'pred_max' => ['label' => 'Predator peak'],
            'period' => ['label' => 'Cycle period'],
            'end' => ['label' => 'At the end'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dx/dt = αx − βxy</li>
            <li>dy/dt = δxy − γy</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
