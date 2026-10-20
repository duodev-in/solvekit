<x-calc.page
    title="Thermal Conductivity Calculator - SolveKit"
    description="Free thermal conductivity calculator: k from a heat-flow test, or typical values for common materials."
    lede="Find thermal conductivity."
    about="Thermal conductivity says how well a material conducts heat. Metals are hundreds of W/(m·K), insulation a few hundredths."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_conductivity', 'fields' => ['mode', 'Q', 'A', 'L', 'dT', 'mat', 'out'], 'unitFields' => ['Q' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dT' => collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'power', 'speed', 'temperature_difference', 'thermal_conductivity'])->all(), 'physics' => collect(config('physics_data'))->only(['thermal'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What k gives 50 W through 1 m² × 20 mm at 25 K?', 'answer' => '0.04 W/(m·K).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['fourier' => 'A heat-flow measurement', 'material' => 'The material']" selected="fourier" />
        <div data-show-when="mode:fourier">
            <x-calc.field name="Q" label="Heat flow" value="50" min="0" placeholder="Heat flow">
                <label for="calc-Q-unit" class="sr-only">Heat flow unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:fourier">
            <x-calc.field name="A" label="Area" value="1" min="0" placeholder="Area">
                <label for="calc-A-unit" class="sr-only">Area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:fourier">
            <x-calc.field name="L" label="Thickness" value="20" placeholder="Thickness">
                <label for="calc-L-unit" class="sr-only">Thickness unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:fourier">
            <x-calc.field name="dT" label="Temperature difference" value="25" placeholder="Temperature difference">
                <label for="calc-dT-unit" class="sr-only">Temperature difference unit</label>
                <select id="calc-dT-unit" name="dT-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature_difference'))->only(['k', 'c', 'f', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:material">
            <x-calc.select name="mat" label="Material" :options="['copper' => 'Copper', 'aluminium' => 'Aluminium', 'brass' => 'Brass', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'glass' => 'Glass', 'granite' => 'Granite', 'concrete' => 'Concrete', 'brick' => 'Brick', 'gypsum' => 'Gypsum plasterboard', 'pine' => 'Softwood (pine)', 'plywood' => 'Plywood', 'pvc' => 'PVC', 'mineral_wool' => 'Mineral wool', 'eps' => 'Expanded polystyrene (EPS)', 'pir' => 'Polyisocyanurate (PIR) board', 'ice' => 'Ice (0 °C)', 'water' => 'Water', 'air' => 'Air (still)']" selected="brick" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['wmk' => 'W/(m·K)', 'btuhftf' => 'BTU/(h·ft·°F)', 'calscmc' => 'cal/(s·cm·°C)', 'mwmk' => 'mW/(m·K)']" selected="wmk" />
    </div>

    <x-calc.result label="Thermal conductivity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'wmk', 'mode' => 'fourier', 'Q' => 50, 'Q-unit' => 'w', 'A' => 1, 'A-unit' => 'm2', 'L' => 20, 'L-unit' => 'mm', 'dT' => 25, 'dT-unit' => 'k', 'mat' => 'brick'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'R' => ['label' => 'Thermal resistance of 100 mm'],
            'class' => ['label' => 'Class'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
