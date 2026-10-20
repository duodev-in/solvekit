<x-calc.page
    title="Power Dissipation Calculator - SolveKit"
    description="Free power dissipation calculator: power in each resistor of a series or parallel circuit."
    lede="Find power in each resistor."
    about="In series the same current flows and the largest resistor gets the most power; in parallel the same voltage sits across each and the smallest gets the most."
    :calc="['engine' => 'ph-em', 'tool' => 'power_dissipation', 'fields' => ['list', 'wiring', 'V'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What total power do 100, 220 and 470 Ω in series take from 12 V?', 'answer' => '0.182278 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="list" label="Resistors in ohms (k and M allowed)" value="100, 220, 470" rows="3" />
        <x-calc.select name="wiring" label="Connected in" :options="['series' => 'Series', 'parallel' => 'Parallel']" selected="series" />
        <x-calc.field name="V" label="Supply voltage" value="12" placeholder="Supply voltage">
            <label for="calc-V-unit" class="sr-only">Supply voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Total power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '100, 220, 470', 'wiring' => 'series', 'V' => 12, 'V-unit' => 'v'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'R' => ['label' => 'Equivalent resistance'],
            'I' => ['label' => 'Supply current'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Power in each resistor" name="each" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
