<x-calc.page
    title="Ideal Transformer Calculator - SolveKit"
    description="Free ideal transformer calculator: secondary voltage and currents from turns or voltage ratio."
    lede="Solve an ideal transformer."
    about="An ideal transformer scales voltage by the turns ratio and current by its inverse, keeping power the same."
    :calc="['engine' => 'ph-elec', 'tool' => 'transformer', 'fields' => ['mode', 'N1', 'N2', 'V1', 'V2', 'I2', 'out'], 'unitFields' => ['V1' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'V2' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I2' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 500:25 transformer give from 230 V?', 'answer' => '11.5 V.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['turns' => 'Turns', 'ratio' => 'Voltage ratio']" selected="turns" />
        <div data-show-when="mode:turns">
            <x-calc.field name="N1" label="Primary turns" value="500" min="0" step="any" />
        </div>
        <div data-show-when="mode:turns">
            <x-calc.field name="N2" label="Secondary turns" value="25" min="0" step="any" />
        </div>
        <x-calc.field name="V1" label="Primary voltage" value="230" placeholder="Primary voltage">
            <label for="calc-V1-unit" class="sr-only">Primary voltage unit</label>
            <select id="calc-V1-unit" name="V1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:ratio">
            <x-calc.field name="V2" label="Secondary voltage (for the ratio)" value="12" placeholder="Secondary voltage (for the ratio)">
                <label for="calc-V2-unit" class="sr-only">Secondary voltage (for the ratio) unit</label>
                <select id="calc-V2-unit" name="V2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="I2" label="Secondary current" value="2" placeholder="Secondary current">
            <label for="calc-I2-unit" class="sr-only">Secondary current unit</label>
            <select id="calc-I2-unit" name="I2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
    </div>

    <x-calc.result label="Secondary voltage" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'v', 'mode' => 'turns', 'N1' => 500, 'N2' => 25, 'V1' => 230, 'V1-unit' => 'v', 'V2' => 12, 'V2-unit' => 'v', 'I2' => 2, 'I2-unit' => 'a'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Turns ratio'],
            'I1' => ['label' => 'Primary current'],
            'VA' => ['label' => 'Power (ideal)'],
            'Z' => ['label' => 'Impedance ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
