<x-calc.page
    title="Isentropic Flow Calculator - SolveKit"
    description="Free isentropic flow calculator: temperature, pressure, density and area ratios against Mach number."
    lede="Solve isentropic flow relations."
    about="In smooth, adiabatic compressible flow the stagnation-to-static ratios depend only on the Mach number. The area ratio A/A* sizes nozzles."
    :calc="['engine' => 'ph-thermo', 'tool' => 'isentropic', 'fields' => ['by', 'val', 'gamma'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What are the ratios at Mach 2?', 'answer' => 'p/p₀ = 0.1278, T/T₀ = 0.55556, A/A* = 1.6875.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="I know" :options="['M' => 'Mach number', 'T' => 'Temperature ratio T/T₀', 'p' => 'Pressure ratio p/p₀', 'A' => 'Area ratio A/A* (subsonic)', 'As' => 'Area ratio A/A* (supersonic)']" selected="M" />
        <x-calc.field name="val" label="Value" value="2" min="0" step="any" />
        <x-calc.field name="gamma" label="γ" value="1.4" min="1" step="any" />
    </div>

    <x-calc.result label="Mach number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'M', 'val' => 2, 'gamma' => 1.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'T/T₀'],
            'p' => ['label' => 'p/p₀'],
            'rho' => ['label' => 'ρ/ρ₀'],
            'A' => ['label' => 'A/A*'],
            'mu' => ['label' => 'Mach angle'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
