<x-calc.page
    title="Thermal Stress Calculator - SolveKit"
    description="Free thermal stress calculator: stress in a restrained bar from a temperature change, σ = EαΔT."
    lede="Find stress from temperature change."
    about="A bar that cannot expand when heated builds stress EαΔT. Steel restrained against a 50 K rise sees about 120 MPa, half its yield strength."
    :calc="['engine' => 'ph-mat', 'tool' => 'thermal_stress', 'fields' => ['mat', 'E', 'alpha', 'dT', 'L', 'out'], 'unitFields' => ['E' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature_difference'])->all(), 'physics' => collect(config('physics_data'))->only(['materials'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What stress does a 50 K rise cause in restrained A36 steel?', 'answer' => '117 MPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mat" label="Material" :options="['a36' => 'Structural steel (A36)', 'steel_4140' => 'Alloy steel 4140 (quenched and tempered)', 'ss304' => 'Stainless steel 304 (annealed)', 'al6061' => 'Aluminium 6061-T6', 'al7075' => 'Aluminium 7075-T6', 'copper' => 'Copper (annealed)', 'brass' => 'Brass C360 (free-cutting)', 'ti64' => 'Titanium Ti-6Al-4V', 'cast_iron' => 'Grey cast iron (class 30)', 'concrete' => 'Concrete (30 MPa)', 'glass' => 'Soda-lime glass', 'nylon' => 'Nylon 6/6', 'pvc' => 'Rigid PVC', 'oak' => 'Oak (along the grain)', 'custom' => 'Other (enter the value)']" selected="a36" />
        <div data-show-when="mat:custom">
            <x-calc.field name="E" label="Young's modulus" value="200" min="0" placeholder="Young's modulus">
                <label for="calc-E-unit" class="sr-only">Young's modulus unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="alpha" label="Expansion coefficient (10⁻⁶/K)" value="12" step="any" />
        </div>
        <x-calc.field name="dT" label="Temperature change" value="50" placeholder="Temperature change">
            <label for="calc-dT-unit" class="sr-only">Temperature change unit</label>
            <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Length (for free expansion)" value="10" placeholder="Length (for free expansion)">
            <label for="calc-L-unit" class="sr-only">Length (for free expansion) unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
    </div>

    <x-calc.result label="Thermal stress (fully restrained)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mpa', 'mat' => 'a36', 'E' => 200, 'E-unit' => 'gpa', 'alpha' => 12, 'dT' => 50, 'dT-unit' => 'k', 'L' => 10, 'L-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'free' => ['label' => 'Free expansion over that length'],
            'strain' => ['label' => 'Thermal strain'],
            'yield' => ['label' => 'Compared with yield'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
