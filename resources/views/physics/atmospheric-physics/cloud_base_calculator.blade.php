<x-calc.page
    title="Cloud Base Calculator - SolveKit"
    description="Free cloud base calculator: height of the cumulus cloud base from temperature and dew point."
    lede="Estimate the cloud base."
    about="Rising air cools until it reaches its dew point, where clouds form. The base lies about 125 m higher for every degree between temperature and dew point."
    :calc="['engine' => 'ph-thermo', 'tool' => 'cloud_base', 'fields' => ['T', 'Td', 'elev', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Td' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'elev' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How high is the cloud base at 25 °C with a 15 °C dew point?', 'answer' => '1,250 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="T" label="Surface temperature" value="25" placeholder="Surface temperature">
            <label for="calc-T-unit" class="sr-only">Surface temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Td" label="Surface dew point" value="15" placeholder="Surface dew point">
            <label for="calc-Td-unit" class="sr-only">Surface dew point unit</label>
            <select id="calc-Td-unit" name="Td-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="elev" label="Station elevation" value="0" placeholder="Station elevation">
            <label for="calc-elev-unit" class="sr-only">Station elevation unit</label>
            <select id="calc-elev-unit" name="elev-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Cloud base above the ground" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'T' => 25, 'T-unit' => 'c', 'Td' => 15, 'Td-unit' => 'c', 'elev' => 0, 'elev-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'msl' => ['label' => 'Above sea level'],
            'ft' => ['label' => 'In feet'],
            'Tbase' => ['label' => 'Temperature at the cloud base'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
