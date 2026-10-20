<x-calc.page
    title="Arrow FOC Calculator - SolveKit"
    description="Free arrow FOC calculator: front-of-centre balance percentage."
    lede="Find your arrow’s FOC."
    about="FOC is how far the balance point sits ahead of the arrow’s middle, as a percentage of its length."
    :calc="['engine' => 'sp-misc', 'tool' => 'arrow_foc', 'fields' => ['L', 'B'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'B' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is FOC for a 29 in arrow balancing at 16.5 in?', 'answer' => '6.9%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Arrow length (nock throat to end of shaft)" value="29" placeholder="Arrow length (nock throat to end of shaft)">
            <label for="calc-L-unit" class="sr-only">Arrow length (nock throat to end of shaft) unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="B" label="Balance point from the nock throat" value="16.5" placeholder="Balance point from the nock throat">
            <label for="calc-B-unit" class="sr-only">Balance point from the nock throat unit</label>
            <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Front of centre (FOC)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['L' => 29, 'L-unit' => 'in', 'B' => 16.5, 'B-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'centre' => ['label' => 'Centre of the arrow'],
            'use' => ['label' => 'Typical'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
