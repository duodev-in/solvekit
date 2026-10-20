<x-calc.page
    title="Oblique Shock Calculator - SolveKit"
    description="Free oblique shock calculator: shock angle, downstream Mach and property ratios from the θ–β–M relation."
    lede="Solve an oblique shock."
    about="A supersonic flow turned by a wedge forms an oblique shock. The θ–β–M relation links the turn, the shock angle and the Mach number; beyond the maximum turn the shock detaches."
    :calc="['engine' => 'ph-fluid', 'tool' => 'oblique_shock', 'fields' => ['M1', 'theta', 'gamma', 'out'], 'unitFields' => ['theta' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What shock angle does Mach 2 and a 10° wedge give?', 'answer' => '39.3139 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M1" label="Upstream Mach number" value="2" min="1" step="any" />
        <x-calc.field name="theta" label="Wedge (deflection) angle" value="10" placeholder="Wedge (deflection) angle">
            <label for="calc-theta-unit" class="sr-only">Wedge (deflection) angle unit</label>
            <select id="calc-theta-unit" name="theta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gamma" label="γ" value="1.4" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Shock angle β (weak shock)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'M1' => 2, 'theta' => 10, 'theta-unit' => 'deg', 'gamma' => 1.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'M2' => ['label' => 'Downstream Mach number'],
            'p' => ['label' => 'Pressure ratio p₂/p₁'],
            'rho' => ['label' => 'Density ratio'],
            'T' => ['label' => 'Temperature ratio'],
            'max' => ['label' => 'Largest deflection for an attached shock'],
            'p0' => ['label' => 'Stagnation pressure ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
