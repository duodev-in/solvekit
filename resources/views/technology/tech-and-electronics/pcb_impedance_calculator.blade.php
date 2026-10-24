<x-calc.page
    title="PCB Impedance Calculator - SolveKit"
    description="Free PCB impedance calculator: microstrip, stripline and differential pair impedance (IPC-2141 equations)."
    lede="Estimate PCB trace impedance."
    about="A trace’s impedance depends on its width, its height above the plane and the board material."
    :calc="['engine' => 'tc-elec', 'tool' => 'pcb_impedance', 'fields' => ['type', 'w', 't', 'h', 's', 'er'], 'unitFields' => ['w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 's' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the impedance of a 0.3 mm trace 0.2 mm above the plane on FR-4?', 'answer' => 'About 53.52 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Structure" :options="['micro' => 'Microstrip (outer layer)', 'strip' => 'Symmetric stripline (inner layer)', 'dmicro' => 'Differential microstrip', 'dstrip' => 'Differential stripline']" selected="micro" />
        <x-calc.field name="w" label="Trace width" value="0.3" placeholder="Trace width">
            <label for="calc-w-unit" class="sr-only">Trace width unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="t" label="Copper thickness" value="0.035" placeholder="Copper thickness">
            <label for="calc-t-unit" class="sr-only">Copper thickness unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Dielectric height (to the plane; stripline: each side)" value="0.2" placeholder="Dielectric height (to the plane; stripline: each side)">
            <label for="calc-h-unit" class="sr-only">Dielectric height (to the plane; stripline: each side) unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="type:dmicro,dstrip">
            <x-calc.field name="s" label="Gap between the pair (differential)" value="0.2" placeholder="Gap between the pair (differential)">
                <label for="calc-s-unit" class="sr-only">Gap between the pair (differential) unit</label>
                <select id="calc-s-unit" name="s-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="er" label="Dielectric constant εr" value="4.3" min="1" step="any" />
    </div>

    <x-calc.result label="Impedance (IPC-2141 estimate)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['type' => 'micro', 'w' => 0.3, 'w-unit' => 'mm', 't' => 0.035, 't-unit' => 'mm', 'h' => 0.2, 'h-unit' => 'mm', 's' => 0.2, 's-unit' => 'mm', 'er' => 4.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'single' => ['label' => 'Single-ended Z₀'],
            'eeff' => ['label' => 'Effective εr'],
            'delay' => ['label' => 'Delay per inch'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
