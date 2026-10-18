<x-calc.page
    title="Bath vs Shower Calculator - SolveKit"
    description="Free bath vs shower calculator: water, heating energy and cost of a bath compared with a shower, and how long a shower uses as much water as a bath."
    lede="Compare the water and cost of a bath and a shower."
    about="Shower water = flow × minutes. US federal rules cap showerheads at 2.5 gallons a minute, and WaterSense models use 2.0 or less. A bath uses whatever you fill it to; a 60-inch tub filled for bathing typically holds 30–50 gallons, so measure yours. Heating energy = water × 4.186 kJ/kg·K × temperature rise ÷ heater efficiency, counting only the hot share of the water."
    :calc="['engine' => 'ev-care', 'tool' => 'bath_shower', 'fields' => ['bath', 'minutes', 'flow', 'flow_unit', 'cold', 'hot', 'used', 'efficiency', 'energy_price', 'energy_unit', 'water_price', 'water_unit'], 'unitFields' => ['bath' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all(), 'cold' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'hot' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'used' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Enter the bath and the shower', 'text' => 'Bath volume, flow and minutes.'],
        ['name' => 'Enter temperatures and prices', 'text' => 'For the heating cost.'],
    ]"
    :faqs="[
        ['question' => 'Is a bath or shower better for water?', 'answer' => 'An 8-minute shower at 2.0 gpm uses 16 gallons, less than a 40-gallon bath.'],
        ['question' => 'How long a shower equals a bath?', 'answer' => 'A 40-gallon bath equals 20 minutes at 2.0 gpm.'],
        ['question' => 'What is the maximum showerhead flow?', 'answer' => '2.5 gallons per minute under US federal rules.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bath" label="Bath water" value="40" min="0" placeholder="Bath water">
            <label for="calc-bath-unit" class="sr-only">Bath water unit</label>
            <select id="calc-bath-unit" name="bath-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="minutes" label="Shower length" value="8" min="0.5" step="0.5" suffix="min" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="flow" label="Shower flow" value="2.0" min="0.1" step="0.1" />
        <x-calc.select name="flow_unit" label="Flow unit" :options="['gpm' => 'US gal/min', 'lpm' => 'L/min']" selected="gpm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cold" label="Cold water" value="55" min="0" placeholder="Cold water">
            <label for="calc-cold-unit" class="sr-only">Cold water unit</label>
            <select id="calc-cold-unit" name="cold-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hot" label="Water heater setting" value="120" min="0" placeholder="Water heater setting">
            <label for="calc-hot-unit" class="sr-only">Water heater setting unit</label>
            <select id="calc-hot-unit" name="hot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="used" label="Bath or shower temperature" value="104" min="0" placeholder="Bath or shower temperature">
            <label for="calc-used-unit" class="sr-only">Bath or shower temperature unit</label>
            <select id="calc-used-unit" name="used-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="efficiency" label="Heater efficiency" value="90" min="30" max="400" step="1" suffix="%" />
        <x-calc.field name="energy_price" label="Energy price" value="0.17" min="0" step="0.01" suffix="$" />
        <x-calc.select name="energy_unit" label="Energy" :options="['kwh' => 'per kWh (electric)', 'therm' => 'per therm (gas)']" selected="kwh" />
        <x-calc.field name="water_price" label="Water price" value="12" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.select name="water_unit" label="Water price" :options="['kgal' => 'per 1,000 US gal', 'm3' => 'per m³']" selected="kgal" />

    <x-calc.result label="Water saved" />

    <x-calc.options :examples="[
        '8 min shower vs 40 gal bath' => ['bath' => 40, 'bath-unit' => 'gal_us', 'minutes' => 8, 'flow' => 2.0, 'flow_unit' => 'gpm', 'cold' => 55, 'cold-unit' => 'f', 'hot' => 120, 'hot-unit' => 'f', 'used' => 104, 'used-unit' => 'f', 'efficiency' => 90, 'energy_price' => 0.17, 'energy_unit' => 'kwh', 'water_price' => 12, 'water_unit' => 'kgal'],
        'Long shower, gas heater' => ['bath' => 35, 'bath-unit' => 'gal_us', 'minutes' => 20, 'flow' => 2.5, 'flow_unit' => 'gpm', 'cold' => 50, 'cold-unit' => 'f', 'hot' => 120, 'hot-unit' => 'f', 'used' => 104, 'used-unit' => 'f', 'efficiency' => 60, 'energy_price' => 1.5, 'energy_unit' => 'therm', 'water_price' => 12, 'water_unit' => 'kgal'],
        'Metric' => ['bath' => 150, 'bath-unit' => 'l', 'minutes' => 7, 'flow' => 9, 'flow_unit' => 'lpm', 'cold' => 10, 'cold-unit' => 'c', 'hot' => 60, 'hot-unit' => 'c', 'used' => 40, 'used-unit' => 'c', 'efficiency' => 95, 'energy_price' => 0.3, 'energy_unit' => 'kwh', 'water_price' => 4, 'water_unit' => 'm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'bath' => ['label' => 'Bath'],
            'shower' => ['label' => 'Shower'],
            'breakEven' => ['label' => 'Break-even'],
            'metric' => ['label' => 'In liters'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>shower = flow × minutes</li>
            <li>kWh = L × hot share × 4.186 × ΔT ÷ 3,600 ÷ efficiency</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
