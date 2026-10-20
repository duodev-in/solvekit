<x-calc.page
    title="Compressibility Factor Calculator - SolveKit"
    description="Free compressibility factor calculator: Z of real gases from the Peng–Robinson equation of state."
    lede="Find the compressibility factor Z."
    about="Real gases deviate from PV = nRT at high pressure. Z = PV/nRT measures the deviation; the Peng–Robinson equation predicts it from critical properties."
    :calc="['engine' => 'ph-thermo', 'tool' => 'compressibility', 'fields' => ['gas', 'P', 'T'], 'unitFields' => ['P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['gases'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Z for methane at 100 bar and 25 °C?', 'answer' => '0.82977.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="['air' => 'Air', 'nitrogen' => 'Nitrogen', 'oxygen' => 'Oxygen', 'co2' => 'Carbon dioxide', 'methane' => 'Methane', 'propane' => 'Propane', 'hydrogen' => 'Hydrogen', 'helium' => 'Helium', 'argon' => 'Argon', 'steam' => 'Water vapour', 'ammonia' => 'Ammonia', 'custom' => 'Other (enter the value)']" selected="methane" />
        <x-calc.field name="P" label="Pressure" value="100" min="0" placeholder="Pressure">
            <label for="calc-P-unit" class="sr-only">Pressure unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'bar')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="25" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Compressibility factor Z" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['gas' => 'methane', 'P' => 100, 'P-unit' => 'bar', 'T' => 25, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Tr' => ['label' => 'Reduced temperature'],
            'Pr' => ['label' => 'Reduced pressure'],
            'rho' => ['label' => 'Density'],
            'ideal' => ['label' => 'Ideal-gas density'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
