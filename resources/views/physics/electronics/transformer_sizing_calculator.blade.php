<x-calc.page
    title="Transformer Sizing Calculator - SolveKit"
    description="Free transformer sizing calculator: kVA of a load with growth margin and the next standard transformer size."
    lede="Size a transformer."
    about="Transformers are sized by kVA: voltage × current (× √3 for three phase), with a margin for growth, rounded up to a standard rating."
    :calc="['engine' => 'ph-elec', 'tool' => 'transformer_size', 'fields' => ['phase', 'V', 'I', 'growth'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What transformer suits 400 V, 100 A three phase?', 'answer' => '112.5 kVA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="phase" label="Supply" :options="['single' => 'Single phase', 'three' => 'Three phase']" selected="three" />
        <x-calc.field name="V" label="Load voltage" value="400" placeholder="Load voltage">
            <label for="calc-V-unit" class="sr-only">Load voltage unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Load current" value="100" placeholder="Load current">
            <label for="calc-I-unit" class="sr-only">Load current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="growth" label="Margin for growth (%)" value="25" min="0" step="any" />
    </div>

    <x-calc.result label="Standard transformer size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['phase' => 'three', 'V' => 400, 'V-unit' => 'v', 'I' => 100, 'I-unit' => 'a', 'growth' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'load' => ['label' => 'Load'],
            'need' => ['label' => 'With margin'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
