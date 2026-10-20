<x-calc.page
    title="Monty Hall Problem Calculator - SolveKit"
    description="Free Monty Hall problem calculator: why switching wins 2/3 of the time, for any number of doors, with a simulation."
    lede="Solve the Monty Hall problem."
    about="You pick one of three doors; the host, who knows where the car is, opens another door showing a goat. Switching wins 2/3 of the time because the host’s choice is not random."
    :calc="['engine' => 'st-prob', 'tool' => 'monty_hall', 'fields' => ['doors', 'opened', 'choice', 'trials', 'seed'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How often does switching win with 3 doors?', 'answer' => '0.666667.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="doors" label="Doors" value="3" min="3" step="any" />
        <x-calc.field name="opened" label="Doors the host opens (all goats)" value="1" min="1" step="any" />
        <x-calc.select name="choice" label="You" :options="['switch' => 'Switch', 'stay' => 'Stay']" selected="switch" />
        <x-calc.field name="trials" label="Simulated trials" value="10000" min="1" step="any" />
        <x-calc.field name="seed" label="Simulation seed (same seed, same run)" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="P(win the car)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['doors' => 3, 'opened' => 1, 'choice' => 'switch', 'trials' => 10000, 'seed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'other' => ['label' => 'If you do the opposite'],
            'sim' => ['label' => 'Simulated wins'],
            'advantage' => ['label' => 'Switching vs staying'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
