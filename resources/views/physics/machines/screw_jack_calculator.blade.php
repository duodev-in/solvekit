<x-calc.page
    title="Screw Jack Calculator - SolveKit"
    description="Free screw jack calculator: effort, torque and efficiency of a power screw, and whether it self-locks."
    lede="Find the effort to turn a screw jack."
    about="A screw jack is an inclined plane wrapped round a cylinder. Thread and collar friction cost most of the effort, but they also stop the load running back down."
    :calc="['engine' => 'ph-mach', 'tool' => 'screw_jack', 'fields' => ['F', 'thread', 'dm', 'lead', 'mu', 'dc', 'muc', 'r', 'out'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'dm' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'lead' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'dc' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'torque'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What effort lifts 10 kN with the example jack?', 'answer' => '210.57 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="F" label="Load" value="10" placeholder="Load">
            <label for="calc-F-unit" class="sr-only">Load unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="thread" label="Thread" :options="['square' => 'Square thread', 'acme' => 'ACME (29°)', 'trapezoidal' => 'Metric trapezoidal (30°)']" selected="trapezoidal" />
        <x-calc.field name="dm" label="Mean thread diameter" value="30" placeholder="Mean thread diameter">
            <label for="calc-dm-unit" class="sr-only">Mean thread diameter unit</label>
            <select id="calc-dm-unit" name="dm-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="lead" label="Lead" value="6" placeholder="Lead">
            <label for="calc-lead-unit" class="sr-only">Lead unit</label>
            <select id="calc-lead-unit" name="lead-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mu" label="Thread friction μ" value="0.15" min="0" step="any" />
        <x-calc.field name="dc" label="Collar mean diameter (0 if none)" value="40" placeholder="Collar mean diameter (0 if none)">
            <label for="calc-dc-unit" class="sr-only">Collar mean diameter (0 if none) unit</label>
            <select id="calc-dc-unit" name="dc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="muc" label="Collar friction μ" value="0.15" min="0" step="any" />
        <x-calc.field name="r" label="Handle radius" value="30" placeholder="Handle radius">
            <label for="calc-r-unit" class="sr-only">Handle radius unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Effort on the handle to raise" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'F' => 10, 'F-unit' => 'kn', 'thread' => 'trapezoidal', 'dm' => 30, 'dm-unit' => 'mm', 'lead' => 6, 'lead-unit' => 'mm', 'mu' => 0.15, 'dc' => 40, 'dc-unit' => 'mm', 'muc' => 0.15, 'r' => 30, 'r-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Tr' => ['label' => 'Torque to raise'],
            'Tl' => ['label' => 'Torque to lower'],
            'eff' => ['label' => 'Efficiency'],
            'lock' => ['label' => 'Self-locking?'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
