<x-calc.page
    title="Current Divider Calculator - SolveKit"
    description="Free current divider calculator: how current splits among parallel branches."
    lede="Split current between branches."
    about="In parallel branches current divides in inverse proportion to resistance: Iₓ = I R_T/Rₓ."
    :calc="['engine' => 'ph-elec', 'tool' => 'current_divider', 'fields' => ['I', 'list'], 'unitFields' => ['I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How does 1 A split among 100, 220 and 470 Ω?', 'answer' => 'See the table; the total resistance is 59.977 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="I" label="Total current" value="1" placeholder="Total current">
            <label for="calc-I-unit" class="sr-only">Total current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.textarea name="list" label="Branch resistances in ohms (k and M allowed)" value="100, 220, 470" rows="3" />
    </div>

    <x-calc.result label="Equivalent resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['I' => 1, 'I-unit' => 'a', 'list' => '100, 220, 470'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'V' => ['label' => 'Voltage across the branches'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Current in each branch" name="branches" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
