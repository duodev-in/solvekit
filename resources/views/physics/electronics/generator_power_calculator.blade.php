<x-calc.page
    title="Generator Power Calculator - SolveKit"
    description="Free generator size calculator: kW and kVA of a load, with a margin for sizing a generator."
    lede="Size a generator."
    about="Generators are rated in kVA (apparent power) and kW (real power at PF 0.8 for most sets). Motor starting surges may need a bigger set."
    :calc="['engine' => 'ph-elec', 'tool' => 'generator', 'fields' => ['phase', 'V', 'I', 'pf', 'margin'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What generator suits 400 V, 30 A three phase?', 'answer' => '16.63 kW of real power.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="phase" label="Supply" :options="['single' => 'Single phase', 'three' => 'Three phase']" selected="three" />
        <x-calc.field name="V" label="Voltage" value="400" placeholder="Voltage">
            <label for="calc-V-unit" class="sr-only">Voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Current" value="30" placeholder="Current">
            <label for="calc-I-unit" class="sr-only">Current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pf" label="Power factor" value="0.8" min="0" step="any" />
        <x-calc.field name="margin" label="Margin (%)" value="25" min="0" step="any" />
    </div>

    <x-calc.result label="Generator rating" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['phase' => 'three', 'V' => 400, 'V-unit' => 'v', 'I' => 30, 'I-unit' => 'a', 'pf' => 0.8, 'margin' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kw' => ['label' => 'Real power'],
            'kva' => ['label' => 'Apparent power'],
            'size' => ['label' => 'Suggested size with margin'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
