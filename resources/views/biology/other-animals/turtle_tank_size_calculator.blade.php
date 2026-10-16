<x-calc.page
    title="Turtle Tank Size Calculator - SolveKit"
    description="Free turtle tank size calculator: minimum aquarium size in gallons and liters from shell length and number of turtles."
    lede="Work out the minimum tank size for aquatic turtles."
    about="A widely used rule for aquatic turtles such as sliders is 10 US gallons of water per inch of shell, plus half again for each extra turtle. Water should be at least twice the shell length deep, and they also need a dry basking area."
    :calc="['engine' => 'animals', 'tool' => 'turtle_tank', 'fields' => ['shell', 'turtles'], 'unitFields' => ['shell' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the shell', 'text' => 'Straight length of the top shell.'],
        ['name' => 'Count the turtles', 'text' => 'Extra turtles need more room.'],
    ]"
    :faqs="[
        ['question' => 'How big a tank for a red-eared slider?', 'answer' => 'An adult of 8 to 12 in needs 80 to 120 gallons or more.'],
        ['question' => 'Do turtles outgrow tanks?', 'answer' => 'Yes, plan for the adult size, not the hatchling.'],
        ['question' => 'Is this for tortoises too?', 'answer' => 'No, tortoises live on land and need floor area, not water.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shell" label="Shell length" value="4" min="0" placeholder="Shell length">
            <label for="calc-shell-unit" class="sr-only">Shell length unit</label>
            <select id="calc-shell-unit" name="shell-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="turtles" label="Number of turtles" value="1" min="1" step="1" />
    </div>

    <x-calc.result label="Minimum tank size" />

    <x-calc.options :examples="[
        '4-inch slider' => ['shell' => 4, 'shell-unit' => 'in', 'turtles' => 1],
        'Two 6-inch turtles' => ['shell' => 6, 'shell-unit' => 'in', 'turtles' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'In liters'],
            'standard' => ['label' => 'Standard tank'],
            'depth' => ['label' => 'Water depth'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gallons = 10 × shell inches × (1 + 0.5 × extra turtles)</li>
            <li>water depth ≥ 2 × shell length</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
