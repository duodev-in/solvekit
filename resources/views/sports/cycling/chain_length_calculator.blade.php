<x-calc.page
    title="Chain Length Calculator - SolveKit"
    description="Free bike chain length calculator: links needed from chainstay length and the largest chainring and cog."
    lede="Find bike chain length."
    about="Park Tool’s formula sizes a derailleur chain from the chainstay and the biggest chainring and cog, rounded up to a whole inch."
    :calc="['engine' => 'sp-cycle', 'tool' => 'chain_length', 'fields' => ['C', 'F', 'R'], 'unitFields' => ['C' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long a chain for a 16.5 in chainstay, 50T and 28T?', 'answer' => '108 links.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="C" label="Chainstay length (centre of bottom bracket to rear axle)" value="16.5" placeholder="Chainstay length (centre of bottom bracket to rear axle)">
            <label for="calc-C-unit" class="sr-only">Chainstay length (centre of bottom bracket to rear axle) unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="F" label="Largest chainring teeth" value="50" min="1" step="any" />
        <x-calc.field name="R" label="Largest cog teeth" value="28" min="1" step="any" />
    </div>

    <x-calc.result label="Chain length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['C' => 16.5, 'C-unit' => 'in', 'F' => 50, 'R' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'inches' => ['label' => 'Length in inches'],
            'links' => ['label' => 'Links (half-inch pitch)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
