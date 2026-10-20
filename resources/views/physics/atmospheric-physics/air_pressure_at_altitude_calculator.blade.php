<x-calc.page
    title="Air Pressure at Altitude Calculator - SolveKit"
    description="Free air pressure at altitude calculator: standard pressure, temperature and density up to 86 km."
    lede="Find air pressure at altitude."
    about="The 1976 US Standard Atmosphere gives the average pressure and temperature with height. Pressure halves roughly every 5.5 km."
    :calc="['engine' => 'ph-thermo', 'tool' => 'pressure_altitude', 'fields' => ['z', 'out'], 'unitFields' => ['z' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the air pressure at 1,500 m?', 'answer' => '845.597 hPa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="z" label="Altitude" value="1500" placeholder="Altitude">
            <label for="calc-z-unit" class="sr-only">Altitude unit</label>
            <select id="calc-z-unit" name="z-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="hpa" />
    </div>

    <x-calc.result label="Standard air pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hpa', 'z' => 1500, 'z-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T' => ['label' => 'Standard temperature'],
            'rho' => ['label' => 'Air density'],
            'ratio' => ['label' => 'Share of sea-level pressure'],
            'boil' => ['label' => 'Boiling point of water'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
