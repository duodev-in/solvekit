<x-calc.page
    title="Effectiveness-NTU Calculator - SolveKit"
    description="Free ε-NTU calculator: heat exchanger effectiveness, heat duty and outlet temperatures."
    lede="Rate a heat exchanger."
    about="The ε-NTU method rates an exchanger from its size (UA) and the two flow capacities, without knowing the outlet temperatures first."
    :calc="['engine' => 'ph-thermo', 'tool' => 'ntu', 'fields' => ['type', 'UA', 'Ch', 'Cc', 'Thi', 'Tci'], 'unitFields' => ['Thi' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Tci' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What effectiveness does the example counterflow exchanger reach?', 'answer' => '0.7398.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Exchanger" :options="['counter' => 'Counterflow', 'parallel' => 'Parallel flow', 'shell' => 'Shell and tube (1 shell pass)', 'cross' => 'Crossflow, both fluids unmixed']" selected="counter" />
        <x-calc.field name="UA" label="UA (W/K)" value="2000" min="0" step="any" />
        <x-calc.field name="Ch" label="Hot stream capacity ṁc_p (W/K)" value="1000" min="0" step="any" />
        <x-calc.field name="Cc" label="Cold stream capacity ṁc_p (W/K)" value="1500" min="0" step="any" />
        <x-calc.field name="Thi" label="Hot inlet" value="90" placeholder="Hot inlet">
            <label for="calc-Thi-unit" class="sr-only">Hot inlet unit</label>
            <select id="calc-Thi-unit" name="Thi-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
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
    </div>

    <x-calc.result label="Effectiveness ε" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'counter', 'UA' => 2000, 'Ch' => 1000, 'Cc' => 1500, 'Thi' => 90, 'Thi-unit' => 'c', 'Tci' => 20, 'Tci-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Q' => ['label' => 'Heat transferred'],
            'Tho' => ['label' => 'Hot outlet'],
            'Tco' => ['label' => 'Cold outlet'],
            'NTU' => ['label' => 'NTU'],
            'Cr' => ['label' => 'Capacity ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
