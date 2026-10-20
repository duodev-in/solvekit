<x-calc.page
    title="Zener Diode Calculator - SolveKit"
    description="Free Zener diode calculator: series resistor and Zener power for a simple shunt regulator."
    lede="Design a Zener regulator."
    about="A Zener diode with a series resistor holds a nearly constant voltage. The resistor must pass the load current plus a minimum Zener current at the lowest supply."
    :calc="['engine' => 'ph-elec', 'tool' => 'zener', 'fields' => ['VsMin', 'VsMax', 'Vz', 'IL', 'Izmin', 'out'], 'unitFields' => ['VsMin' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'VsMax' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vz' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'IL' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'Izmin' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What resistor regulates 5.1 V from 11–14 V at 20 mA?', 'answer' => '236 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="VsMin" label="Minimum supply voltage" value="11" placeholder="Minimum supply voltage">
            <label for="calc-VsMin-unit" class="sr-only">Minimum supply voltage unit</label>
            <select id="calc-VsMin-unit" name="VsMin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="VsMax" label="Maximum supply voltage" value="14" placeholder="Maximum supply voltage">
            <label for="calc-VsMax-unit" class="sr-only">Maximum supply voltage unit</label>
            <select id="calc-VsMax-unit" name="VsMax-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Vz" label="Zener voltage" value="5.1" placeholder="Zener voltage">
            <label for="calc-Vz-unit" class="sr-only">Zener voltage unit</label>
            <select id="calc-Vz-unit" name="Vz-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="IL" label="Maximum load current" value="20" placeholder="Maximum load current">
            <label for="calc-IL-unit" class="sr-only">Maximum load current unit</label>
            <select id="calc-IL-unit" name="IL-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ma')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Izmin" label="Minimum Zener current" value="5" placeholder="Minimum Zener current">
            <label for="calc-Izmin-unit" class="sr-only">Minimum Zener current unit</label>
            <select id="calc-Izmin-unit" name="Izmin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ma')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="ohm" />
    </div>

    <x-calc.result label="Series resistor (maximum)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ohm', 'VsMin' => 11, 'VsMin-unit' => 'v', 'VsMax' => 14, 'VsMax-unit' => 'v', 'Vz' => 5.1, 'Vz-unit' => 'v', 'IL' => 20, 'IL-unit' => 'ma', 'Izmin' => 5, 'Izmin-unit' => 'ma'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Pz' => ['label' => 'Zener power (no load, maximum supply)'],
            'Pr' => ['label' => 'Resistor power (maximum supply)'],
            'rating' => ['label' => 'Suggested Zener rating'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
