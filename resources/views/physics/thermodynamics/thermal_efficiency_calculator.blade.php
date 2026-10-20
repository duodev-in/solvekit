<x-calc.page
    title="Thermal Efficiency Calculator - SolveKit"
    description="Free thermal efficiency calculator: work output over heat input, compared with the Carnot limit."
    lede="Find thermal efficiency."
    about="Thermal efficiency is the share of heat input turned into work."
    :calc="['engine' => 'ph-thermo', 'tool' => 'thermal_efficiency', 'fields' => ['W', 'Q', 'Th', 'Tc'], 'unitFields' => ['W' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'Q' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all(), 'Th' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tc' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'power', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the efficiency of 35 kW from 100 kW of heat?', 'answer' => '35%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="W" label="Work output" value="35" min="0" placeholder="Work output">
            <label for="calc-W-unit" class="sr-only">Work output unit</label>
            <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Q" label="Heat input" value="100" min="0" placeholder="Heat input">
            <label for="calc-Q-unit" class="sr-only">Heat input unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kw')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Th" label="Hot temperature (optional)" value="500" placeholder="Hot temperature (optional)">
            <label for="calc-Th-unit" class="sr-only">Hot temperature (optional) unit</label>
            <select id="calc-Th-unit" name="Th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Tc" label="Cold temperature (optional)" value="30" placeholder="Cold temperature (optional)">
            <label for="calc-Tc-unit" class="sr-only">Cold temperature (optional) unit</label>
            <select id="calc-Tc-unit" name="Tc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Thermal efficiency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['W' => 35, 'W-unit' => 'kw', 'Q' => 100, 'Q-unit' => 'kw', 'Th' => 500, 'Th-unit' => 'c', 'Tc' => 30, 'Tc-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rejected' => ['label' => 'Heat rejected'],
            'carnot' => ['label' => 'Carnot limit'],
            'share' => ['label' => 'Share of the Carnot limit reached'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
