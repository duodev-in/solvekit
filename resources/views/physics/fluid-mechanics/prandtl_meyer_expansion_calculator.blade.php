<x-calc.page
    title="Prandtl Meyer Expansion Calculator - SolveKit"
    description="Free Prandtl–Meyer expansion calculator: downstream Mach number after a supersonic turn."
    lede="Solve a Prandtl–Meyer expansion."
    about="When supersonic flow turns away from itself it expands smoothly through a fan of Mach waves, speeding up and losing pressure."
    :calc="['engine' => 'ph-fluid', 'tool' => 'prandtl_meyer', 'fields' => ['M1', 'theta', 'gamma'], 'unitFields' => ['theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What Mach follows a 10° turn at Mach 2?', 'answer' => '2.3849.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M1" label="Upstream Mach number" value="2" min="1" step="any" />
        <x-calc.field name="theta" label="Turning angle" value="10" placeholder="Turning angle">
            <label for="calc-theta-unit" class="sr-only">Turning angle unit</label>
            <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gamma" label="γ" value="1.4" min="1" step="any" />
    </div>

    <x-calc.result label="Downstream Mach number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['M1' => 2, 'theta' => 10, 'theta-unit' => 'deg', 'gamma' => 1.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nu1' => ['label' => 'Prandtl–Meyer angle upstream'],
            'nu2' => ['label' => 'Prandtl–Meyer angle downstream'],
            'p' => ['label' => 'Pressure ratio p₂/p₁'],
            'T' => ['label' => 'Temperature ratio'],
            'max' => ['label' => 'Largest possible turn'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
