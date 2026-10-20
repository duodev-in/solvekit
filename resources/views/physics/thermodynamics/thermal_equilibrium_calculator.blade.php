<x-calc.page
    title="Thermal Equilibrium Calculator - SolveKit"
    description="Free thermal equilibrium calculator: final temperature when several bodies exchange heat."
    lede="Find the equilibrium temperature."
    about="Bodies in contact settle at a common temperature where the heat lost equals the heat gained."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_equilibrium', 'fields' => ['bodies', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What temperature do the example bodies reach?', 'answer' => '26.9019 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="bodies" label="Bodies: mass in kg, specific heat in J/(kg·K), temperature in °C (one per line)" value="0.5, 4182, 20
0.2, 900, 100
0.1, 385, 60" rows="3" />
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Equilibrium temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'bodies' => '0.5, 4182, 20
0.2, 900, 100
0.1, 385, 60'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'C' => ['label' => 'Total heat capacity'],
            'each' => ['label' => 'Heat gained (+) or lost (−) by each'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
