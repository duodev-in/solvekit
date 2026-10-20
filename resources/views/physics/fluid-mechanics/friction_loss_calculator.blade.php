<x-calc.page
    title="Friction Loss Calculator - SolveKit"
    description="Free friction loss calculator: pipe and fittings head loss with typical K-values for elbows, tees and valves."
    lede="Find total pipe system loss."
    about="Total loss is pipe friction plus fittings, each fitting adding K velocity heads."
    :calc="['engine' => 'ph-fluid', 'tool' => 'friction_loss', 'fields' => ['Q', 'D', 'L', 'pipe', 'fluid', 'rho', 'mu', 'el90', 'el45', 'tee', 'gate', 'globe', 'check', 'ends', 'out'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'mu' => collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'flow', 'force', 'length', 'mass', 'pressure', 'speed', 'viscosity'])->all(), 'physics' => collect(config('physics_data'))->only(['roughness', 'fluids'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the loss in the example system?', 'answer' => '4.12639 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Q" label="Flow rate" value="200" min="0" placeholder="Flow rate">
            <label for="calc-Q-unit" class="sr-only">Flow rate unit</label>
            <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lmin')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D" label="Inside diameter" value="50" placeholder="Inside diameter">
            <label for="calc-D-unit" class="sr-only">Inside diameter unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Pipe length" value="50" placeholder="Pipe length">
            <label for="calc-L-unit" class="sr-only">Pipe length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="pipe" label="Pipe material" :options="['drawn' => 'Drawn tubing (copper, brass)', 'pvc' => 'PVC or plastic', 'steel' => 'Commercial steel', 'stainless' => 'Stainless steel', 'galvanized' => 'Galvanized iron', 'cast_iron' => 'Cast iron', 'ductile' => 'Ductile iron, cement lined', 'concrete' => 'Concrete', 'riveted' => 'Riveted steel']" selected="pvc" />
        <x-calc.select name="fluid" label="Fluid" :options="['water' => 'Water', 'seawater' => 'Sea water', 'air' => 'Air', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'engine_oil' => 'Engine oil (SAE 30)', 'olive_oil' => 'Olive oil', 'petrol' => 'Petrol (gasoline)', 'diesel' => 'Diesel', 'mercury' => 'Mercury', 'milk' => 'Milk', 'honey' => 'Honey', 'custom' => 'Other (enter the value)']" selected="water" />
        <div data-show-when="fluid:custom">
            <x-calc.field name="rho" label="Fluid density" value="1000" min="0" placeholder="Fluid density">
                <label for="calc-rho-unit" class="sr-only">Fluid density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="fluid:custom">
            <x-calc.field name="mu" label="Dynamic viscosity" value="1" min="0" placeholder="Dynamic viscosity">
                <label for="calc-mu-unit" class="sr-only">Dynamic viscosity unit</label>
                <select id="calc-mu-unit" name="mu-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.viscosity'))->only(['pas', 'mpas', 'cp', 'p', 'lbfts']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cp')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="el90" label="90° elbows (K = 0.9)" value="4" min="0" step="any" />
        <x-calc.field name="el45" label="45° elbows (K = 0.4)" value="0" min="0" step="any" />
        <x-calc.field name="tee" label="Tees, flow through branch (K = 1.8)" value="1" min="0" step="any" />
        <x-calc.field name="gate" label="Gate or ball valves, open (K = 0.2)" value="2" min="0" step="any" />
        <x-calc.field name="globe" label="Globe valves, open (K = 10)" value="0" min="0" step="any" />
        <x-calc.field name="check" label="Swing check valves (K = 2)" value="1" min="0" step="any" />
        <x-calc.select name="ends" label="Include entrance and exit (K = 0.5 + 1)" :options="['yes' => 'Yes', 'no' => 'No']" selected="yes" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Total head loss" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'Q' => 200, 'Q-unit' => 'lmin', 'D' => 50, 'D-unit' => 'mm', 'L' => 50, 'L-unit' => 'm', 'pipe' => 'pvc', 'fluid' => 'water', 'rho' => 1000, 'rho-unit' => 'kgm3', 'mu' => 1, 'mu-unit' => 'cp', 'el90' => 4, 'el45' => 0, 'tee' => 1, 'gate' => 2, 'globe' => 0, 'check' => 1, 'ends' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'major' => ['label' => 'Pipe friction loss'],
            'minor' => ['label' => 'Fittings loss'],
            'K' => ['label' => 'Sum of K values'],
            'dP' => ['label' => 'Pressure drop'],
            'v' => ['label' => 'Velocity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
