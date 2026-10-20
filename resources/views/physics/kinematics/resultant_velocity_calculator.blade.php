<x-calc.page
    title="Resultant Velocity Calculator - SolveKit"
    description="Free resultant velocity calculator: add any number of velocity vectors to get the resultant speed and direction."
    lede="Add velocity vectors."
    about="Velocities add as vectors: split each into x and y components, add the components and recombine. A boat at 10 m/s across a river flowing at 5 m/s moves at √125 ≈ 11.2 m/s over the ground."
    :calc="['engine' => 'ph-mech', 'tool' => 'resultant_velocity', 'fields' => ['vectors', 'unit'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 10 m/s at 0° plus 5 m/s at 90°?', 'answer' => '11.1803 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="vectors" label="Velocities: speed, direction in degrees (one per line, in the unit below)" value="10, 0
5, 90" rows="3" />
        <x-calc.select name="unit" label="Speed unit" :options="['ms' => 'm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'knot' => 'knots']" selected="ms" />
    </div>

    <x-calc.result label="Resultant velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['vectors' => '10, 0
5, 90', 'unit' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Vector diagram" name="vectors" />
        <x-calc.rows heading="Details" :rows="[
            'dir' => ['label' => 'Direction'],
            'comps' => ['label' => 'Components (x, y)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
