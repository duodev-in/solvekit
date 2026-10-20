<x-calc.page
    title="Electric Potential Calculator - SolveKit"
    description="Free electric potential calculator: potential from several point charges at any point, and the work to bring a charge there."
    lede="Find the electric potential."
    about="Potential is energy per unit charge. Unlike the field it is a scalar, so contributions from several charges simply add: V = Σkqᵢ/rᵢ."
    :calc="['engine' => 'ph-em', 'tool' => 'potential', 'fields' => ['list', 'px', 'py', 'q0', 'out'], 'unitFields' => ['q0' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the potential at the example point?', 'answer' => '86.9096 kV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="list" label="Charges: q in µC, x, y in metres (one per line)" value="2, 0, 0
-1, 0.3, 0" rows="3" />
        <x-calc.field name="px" label="Point x (m)" value="0.1" step="any" />
        <x-calc.field name="py" label="Point y (m)" value="0.1" step="any" />
        <x-calc.field name="q0" label="Test charge to bring there (optional)" value="1" placeholder="Test charge to bring there (optional)">
            <label for="calc-q0-unit" class="sr-only">Test charge to bring there (optional) unit</label>
            <select id="calc-q0-unit" name="q0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uc')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="kv" />
    </div>

    <x-calc.result label="Electric potential" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kv', 'list' => '2, 0, 0
-1, 0.3, 0', 'px' => 0.1, 'py' => 0.1, 'q0' => 1, 'q0-unit' => 'uc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'W' => ['label' => 'Work to bring the test charge from infinity'],
            'each' => ['label' => 'Contribution of each charge'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
