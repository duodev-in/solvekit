<x-calc.page
    title="Speed of Sound Calculator - SolveKit"
    description="Free speed of sound calculator: sound speed in air and other gases at any temperature, and in common liquids."
    lede="Find the speed of sound."
    about="In a gas, sound travels at √(γRT/M): faster when hot and in light gases like helium. Liquids are much stiffer, so sound moves several times faster in water."
    :calc="['engine' => 'ph-wave', 'tool' => 'speed_sound', 'fields' => ['med', 'T', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['sound_media'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is sound in air at 20 °C?', 'answer' => '343.235 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="med" label="Medium" :options="['air' => 'Air (dry)', 'nitrogen' => 'Nitrogen', 'oxygen' => 'Oxygen', 'helium' => 'Helium', 'hydrogen' => 'Hydrogen', 'co2' => 'Carbon dioxide', 'methane' => 'Methane', 'water' => 'Fresh water (20 °C)', 'seawater' => 'Sea water (20 °C)', 'ethanol' => 'Ethanol (25 °C)', 'glycerol' => 'Glycerol (25 °C)', 'mercury' => 'Mercury (25 °C)']" selected="air" />
        <div data-show-when="med:air,nitrogen,oxygen,helium,hydrogen,co2,methane">
            <x-calc.field name="T" label="Temperature (gases)" value="20" placeholder="Temperature (gases)">
                <label for="calc-T-unit" class="sr-only">Temperature (gases) unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Speed of sound" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'med' => 'air', 'T' => 20, 'T-unit' => 'c'],
        'Helium' => ['out' => 'ms', 'med' => 'helium', 'T' => 20, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kmh' => ['label' => 'In km/h and mph'],
            'km' => ['label' => 'Time to travel 1 km'],
            'lambda' => ['label' => 'Wavelength at 1 kHz'],
            'thunder' => ['label' => 'Thunder rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
