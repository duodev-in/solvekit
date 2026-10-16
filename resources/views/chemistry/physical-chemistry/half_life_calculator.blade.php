<x-calc.page
    title="Half-Life Calculator - SolveKit"
    description="Free half-life calculator: remaining amount, half-life, time or initial amount for exponential decay, with the decay constant."
    lede="Work out half-life, time or amount remaining for any first-order decay."
    about="For any first-order process, N = N₀ (½)^(t ÷ t½). Use the same time unit for t and t½. The decay constant is λ = ln 2 ÷ t½ and the mean life τ = 1 ÷ λ. For a named radioactive isotope use the Radioactive Decay Calculator."
    :calc="['engine' => 'chem-physical', 'tool' => 'half_life', 'fields' => ['solve', 'initial', 'remaining', 'time', 'half_life']]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'Any one of the four.'],
        ['name' => 'Enter the other three', 'text' => 'Times in the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is a half-life?', 'answer' => 'The time for half of the substance to decay or react.'],
        ['question' => 'How much is left after 3 half-lives?', 'answer' => '12.5%, one eighth.'],
        ['question' => 'Does half-life depend on the amount?', 'answer' => 'Not for first-order processes such as radioactive decay.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['remaining' => 'Amount remaining', 'half' => 'Half-life', 'time' => 'Time', 'initial' => 'Initial amount']" selected="remaining" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:remaining,half,time">
            <x-calc.field name="initial" label="Initial amount N₀" value="100" min="0" />
        </div>
        <div data-show-when="solve:half,time,initial" hidden>
            <x-calc.field name="remaining" label="Amount remaining N" value="25" min="0" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:remaining,half,initial">
            <x-calc.field name="time" label="Time elapsed" value="30" min="0" />
        </div>
        <div data-show-when="solve:remaining,time,initial">
            <x-calc.field name="half_life" label="Half-life" value="10" min="0" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '100 g after 3 half-lives' => ['solve' => 'remaining', 'initial' => 100, 'time' => 30, 'half_life' => 10],
        'Find the half-life' => ['solve' => 'half', 'initial' => 80, 'remaining' => 10, 'time' => 24],
        'Time to fall to 1%' => ['solve' => 'time', 'initial' => 100, 'remaining' => 1, 'half_life' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lambda' => ['label' => 'Decay constant λ'],
            'mean' => ['label' => 'Mean life'],
            'fraction' => ['label' => 'Remaining'],
        ]" />
        <x-calc.quick-ref heading="After each half-life" name="halves" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = N₀ (½)^(t ÷ t½)</li>
            <li>λ = ln 2 ÷ t½</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
