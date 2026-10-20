<x-calc.page
    title="Water Heating Calculator - SolveKit"
    description="Free water heating calculator: energy and time to heat water with a heater of given power."
    lede="Find time to heat water."
    about="Heating water takes 4.18 kJ per kg per degree. A 3 kW heater warms a 150 L tank by 45 °C in about 2.6 hours."
    :calc="['engine' => 'ph-thermo', 'tool' => 'water_heating', 'fields' => ['V', 'T1', 'T2', 'P', 'eff', 'out'], 'unitFields' => ['V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'T2' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed', 'temperature', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 3 kW heater take for 150 L from 15 to 60 °C?', 'answer' => '2.749 h (164.93 min).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="V" label="Water volume" value="150" min="0" placeholder="Water volume">
            <label for="calc-V-unit" class="sr-only">Water volume unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T1" label="Starting temperature" value="15" placeholder="Starting temperature">
            <label for="calc-T1-unit" class="sr-only">Starting temperature unit</label>
            <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T2" label="Target temperature" value="60" placeholder="Target temperature">
            <label for="calc-T2-unit" class="sr-only">Target temperature unit</label>
            <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="P" label="Heater power" value="3" min="0" placeholder="Heater power">
            <label for="calc-P-unit" class="sr-only">Heater power unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eff" label="Efficiency (%)" value="95" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kwh" />
    </div>

    <x-calc.result label="Energy needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kwh', 'V' => 150, 'V-unit' => 'l', 'T1' => 15, 'T1-unit' => 'c', 'T2' => 60, 'T2-unit' => 'c', 'P' => 3, 'P-unit' => 'kw', 'eff' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            't' => ['label' => 'Heating time'],
            'mass' => ['label' => 'Water mass'],
            'boil' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
