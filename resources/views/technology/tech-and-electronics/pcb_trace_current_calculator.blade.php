<x-calc.page
    title="PCB Trace Current Calculator - SolveKit"
    description="Free PCB trace current calculator: maximum current for a trace width, copper weight and temperature rise (IPC-2221)."
    lede="Find a trace’s current limit."
    about="A trace heats up as current flows. IPC-2221 relates the current, cross-section and temperature rise."
    :calc="['engine' => 'tc-elec', 'tool' => 'trace_current', 'fields' => ['w', 'oz', 'dT', 'layer', 'len'], 'unitFields' => ['w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'len' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much current can a 0.5 mm, 1 oz trace carry at 10 °C rise?', 'answer' => 'About 1.447 A.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Trace width" value="0.5" placeholder="Trace width">
            <label for="calc-w-unit" class="sr-only">Trace width unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="oz" label="Copper weight (oz/ft²)" value="1" min="0" step="any" />
        <x-calc.field name="dT" label="Allowed temperature rise (°C)" value="10" min="0" step="any" />
        <x-calc.select name="layer" label="Layer" :options="['external' => 'External (outer)', 'internal' => 'Internal']" selected="external" />
        <x-calc.field name="len" label="Trace length (for resistance)" value="50" placeholder="Trace length (for resistance)">
            <label for="calc-len-unit" class="sr-only">Trace length (for resistance) unit</label>
            <select id="calc-len-unit" name="len-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Maximum current (IPC-2221)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 0.5, 'w-unit' => 'mm', 'oz' => 1, 'dT' => 10, 'layer' => 'external', 'len' => 50, 'len-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Cross-section'],
            'resistance' => ['label' => 'Resistance at 25 °C'],
            'drop' => ['label' => 'Voltage drop at that current'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
