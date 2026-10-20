<x-calc.page
    title="kVA Calculator - SolveKit"
    description="Free kVA calculator: apparent power from voltage and current, single or three phase, with kW and kVAR."
    lede="Find apparent power in kVA."
    about="Apparent power S = VI (× √3 for three phase) sizes generators, transformers and cables."
    :calc="['engine' => 'ph-em', 'tool' => 'kva', 'fields' => ['phase', 'V', 'I', 'pf'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 400 V × 50 A three phase?', 'answer' => '34.641 kVA kVA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="phase" label="Supply" :options="['single' => 'Single phase', 'three' => 'Three phase (line-to-line voltage)']" selected="three" />
        <x-calc.field name="V" label="Voltage" value="400" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Current" value="50" placeholder="Current">
            <label for="calc-I-unit" class="sr-only">Current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pf" label="Power factor (for kW)" value="0.8" min="0" step="any" />
    </div>

    <x-calc.result label="Apparent power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['phase' => 'three', 'V' => 400, 'V-unit' => 'v', 'I' => 50, 'I-unit' => 'a', 'pf' => 0.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kw' => ['label' => 'Real power'],
            'kvar' => ['label' => 'Reactive power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
