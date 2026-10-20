<x-calc.page
    title="Resistor Voltage Drop Calculator - SolveKit"
    description="Free resistor voltage drop calculator: voltage across each resistor in a series circuit."
    lede="Find voltage drops in series."
    about="In series the same current flows through every resistor, so each drops a share of the supply proportional to its resistance."
    :calc="['engine' => 'ph-elec', 'tool' => 'resistor_drop', 'fields' => ['Vs', 'list'], 'unitFields' => ['Vs' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What current flows through 1k, 2.2k and 4.7k on 12 V?', 'answer' => '1.519 mA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vs" label="Supply voltage" value="12" placeholder="Supply voltage">
            <label for="calc-Vs-unit" class="sr-only">Supply voltage unit</label>
            <select id="calc-Vs-unit" name="Vs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.textarea name="list" label="Resistors in series, in ohms (k and M allowed)" value="1k, 2.2k, 4.7k" rows="3" />
    </div>

    <x-calc.result label="Current" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Vs' => 12, 'Vs-unit' => 'v', 'list' => '1k, 2.2k, 4.7k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'R' => ['label' => 'Total resistance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Voltage across each resistor" name="drops" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
