<x-calc.page
    title="LMTD Calculator – Log Mean Temperature Difference - SolveKit"
    description="Free LMTD calculator: log mean temperature difference for counterflow and parallel heat exchangers."
    lede="Find the LMTD."
    about="Along a heat exchanger the temperature difference changes. The log mean difference is the right average for Q = UA·LMTD."
    :calc="['engine' => 'ph-thermo', 'tool' => 'lmtd', 'fields' => ['flow', 'Thi', 'Tho', 'Tci', 'Tco', 'out'], 'unitFields' => ['Thi' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tho' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tci' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tco' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature', 'temperature_difference'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the LMTD of the example counterflow exchanger?', 'answer' => '39.1523 K.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="flow" label="Arrangement" :options="['counter' => 'Counterflow', 'parallel' => 'Parallel flow']" selected="counter" />
        <x-calc.field name="Thi" label="Hot inlet" value="90" placeholder="Hot inlet">
            <label for="calc-Thi-unit" class="sr-only">Hot inlet unit</label>
            <select id="calc-Thi-unit" name="Thi-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Tho" label="Hot outlet" value="50" placeholder="Hot outlet">
            <label for="calc-Tho-unit" class="sr-only">Hot outlet unit</label>
            <select id="calc-Tho-unit" name="Tho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Tci" label="Cold inlet" value="20" placeholder="Cold inlet">
            <label for="calc-Tci-unit" class="sr-only">Cold inlet unit</label>
            <select id="calc-Tci-unit" name="Tci-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Tco" label="Cold outlet" value="40" placeholder="Cold outlet">
            <label for="calc-Tco-unit" class="sr-only">Cold outlet unit</label>
            <select id="calc-Tco-unit" name="Tco-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['k' => 'K', 'c' => '°C', 'f' => '°F', 'r' => '°R']" selected="k" />
    </div>

    <x-calc.result label="Log mean temperature difference" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'k', 'flow' => 'counter', 'Thi' => 90, 'Thi-unit' => 'c', 'Tho' => 50, 'Tho-unit' => 'c', 'Tci' => 20, 'Tci-unit' => 'c', 'Tco' => 40, 'Tco-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'd1' => ['label' => 'ΔT₁'],
            'd2' => ['label' => 'ΔT₂'],
            'arith' => ['label' => 'Arithmetic mean (less accurate)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
