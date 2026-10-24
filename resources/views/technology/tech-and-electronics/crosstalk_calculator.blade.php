<x-calc.page
    title="Crosstalk Calculator - SolveKit"
    description="Free crosstalk calculator: estimate coupling between PCB traces from their spacing and height above the plane."
    lede="Estimate PCB crosstalk."
    about="Traces close together couple signals into each other. Wider spacing, and a reference plane close below, reduce it."
    :calc="['engine' => 'tc-elec', 'tool' => 'crosstalk', 'fields' => ['s', 'h'], 'unitFields' => ['s' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much crosstalk at 0.3 mm spacing, 0.2 mm above the plane?', 'answer' => 'About 30.8%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="s" label="Spacing between traces (edge to edge)" value="0.3" placeholder="Spacing between traces (edge to edge)">
            <label for="calc-s-unit" class="sr-only">Spacing between traces (edge to edge) unit</label>
            <select id="calc-s-unit" name="s-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Height above the reference plane" value="0.2" placeholder="Height above the reference plane">
            <label for="calc-h-unit" class="sr-only">Height above the reference plane unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Crosstalk (estimate)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['s' => 0.3, 's-unit' => 'mm', 'h' => 0.2, 'h-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Crosstalk by spacing" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'db' => ['label' => 'In dB'],
            'rule' => ['label' => 'Spacing for under 5%'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
