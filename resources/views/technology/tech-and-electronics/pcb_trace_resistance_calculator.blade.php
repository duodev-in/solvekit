<x-calc.page
    title="PCB Trace Resistance Calculator - SolveKit"
    description="Free PCB trace resistance calculator: resistance, voltage drop and power of a copper trace."
    lede="Find a trace’s resistance."
    about="Copper traces have resistance set by their length, width, copper thickness and temperature."
    :calc="['engine' => 'tc-elec', 'tool' => 'trace_resistance', 'fields' => ['w', 'len', 'oz', 'temp', 'current'], 'unitFields' => ['w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'len' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the resistance of 100 mm of 0.25 mm, 1 oz trace?', 'answer' => '202.05 mΩ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Trace width" value="0.25" placeholder="Trace width">
            <label for="calc-w-unit" class="sr-only">Trace width unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="len" label="Length" value="100" placeholder="Length">
            <label for="calc-len-unit" class="sr-only">Length unit</label>
            <select id="calc-len-unit" name="len-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="oz" label="Copper weight (oz/ft²)" value="1" min="0" step="any" />
        <x-calc.field name="temp" label="Temperature (°C)" value="25" step="any" />
        <x-calc.field name="current" label="Current (A, optional)" value="1" min="0" step="any" />
    </div>

    <x-calc.result label="Resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 0.25, 'w-unit' => 'mm', 'len' => 100, 'len-unit' => 'mm', 'oz' => 1, 'temp' => 25, 'current' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'drop' => ['label' => 'Voltage drop'],
            'power' => ['label' => 'Power lost'],
            'perLen' => ['label' => 'Per cm'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
