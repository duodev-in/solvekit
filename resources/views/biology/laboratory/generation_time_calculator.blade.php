<x-calc.page
    title="Generation Time Calculator - SolveKit"
    description="Free generation time calculator: bacterial generation time, number of generations and growth rate from start and end counts."
    lede="Work out the generation time of a growing culture."
    about="During exponential growth the population doubles every generation, so the number of generations is log₂(N ÷ N₀) and the generation time is the elapsed time ÷ generations. Use counts from within the log phase."
    :calc="['engine' => 'lab', 'tool' => 'generation_time', 'fields' => ['start', 'end', 'time']]"
    :how-to="[
        ['name' => 'Enter the counts', 'text' => 'Cells or CFU per mL at two times in log phase.'],
        ['name' => 'Enter the time', 'text' => 'Hours between the two counts.'],
    ]"
    :faqs="[
        ['question' => 'What is the generation time of E. coli?', 'answer' => 'About 20 minutes in rich medium at 37 °C.'],
        ['question' => 'Where does 3.3 come from?', 'answer' => 'log₂ x = 3.32 × log₁₀ x, so g = t ÷ (3.3 × log₁₀(N ÷ N₀)).'],
        ['question' => 'Is generation time the same as doubling time?', 'answer' => 'Yes, for a whole population growing exponentially.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting count N₀" value="1000" min="0" />
        <x-calc.field name="end" label="Final count N" value="128000" min="0" />
    </div>

    <x-calc.field name="time" label="Time between counts" value="3.5" min="0" suffix="h" />

    <x-calc.result label="Generation time" />

    <x-calc.options :examples="[
        'E. coli 7 generations' => ['start' => 1000, 'end' => 128000, 'time' => 3.5],
        'Slow grower' => ['start' => 50000, 'end' => 400000, 'time' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'generations' => ['label' => 'Generations'],
            'rate' => ['label' => 'Growth rate'],
            'hours' => ['label' => 'In hours'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = log₁₀(N ÷ N₀) ÷ log₁₀ 2</li>
            <li>g = t ÷ n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
