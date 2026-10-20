<x-calc.page
    title="Knudsen Number Calculator - SolveKit"
    description="Free Knudsen number calculator: mean free path over length scale, and whether flow is continuum or rarefied."
    lede="Find the Knudsen number."
    about="When the mean free path becomes comparable to the size of a channel, gas stops behaving as a continuum. The Knudsen number tells which regime applies."
    :calc="['engine' => 'ph-fluid', 'tool' => 'knudsen', 'fields' => ['gas', 'd', 'P', 'T', 'L'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['gases'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Kn for air in a 1 µm channel?', 'answer' => '0.0674848.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="['air' => 'Air', 'nitrogen' => 'Nitrogen', 'oxygen' => 'Oxygen', 'co2' => 'Carbon dioxide', 'methane' => 'Methane', 'propane' => 'Propane', 'hydrogen' => 'Hydrogen', 'helium' => 'Helium', 'argon' => 'Argon', 'steam' => 'Water vapour', 'ammonia' => 'Ammonia', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="gas:custom">
            <x-calc.field name="d" label="Molecular diameter" value="0.365" placeholder="Molecular diameter">
                <label for="calc-d-unit" class="sr-only">Molecular diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="P" label="Pressure" value="101325" min="0" placeholder="Pressure">
            <label for="calc-P-unit" class="sr-only">Pressure unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'pa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="20" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Characteristic length" value="1" placeholder="Characteristic length">
            <label for="calc-L-unit" class="sr-only">Characteristic length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'um')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Knudsen number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['gas' => 'air', 'd' => 0.365, 'd-unit' => 'nm', 'P' => 101325, 'P-unit' => 'pa', 'T' => 20, 'T-unit' => 'c', 'L' => 1, 'L-unit' => 'um'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lambda' => ['label' => 'Mean free path'],
            'regime' => ['label' => 'Flow regime'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
