<x-calc.page
    title="Buckling Calculator - SolveKit"
    description="Free column buckling calculator: Euler critical load with end conditions, and the Johnson formula for short columns."
    lede="Find the load a column buckles at."
    about="A slender column fails by bowing sideways at the Euler load π²EI/(KL)², long before the material crushes. Fixed ends raise the load; a free end lowers it a lot. Stocky columns fail by yielding first, which the Johnson formula covers."
    :calc="['engine' => 'ph-mat', 'tool' => 'buckling', 'fields' => ['L', 'ends', 'mat', 'E', 'sy', 'section', 'sd', 'st', 'sb', 'sh', 'sI', 'sA', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'E' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'sy' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'sd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'st' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'sb' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'sh' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'sI' => collect(config('units.area_moment'))->only(['m4', 'cm4', 'mm4', 'in4', 'ft4'])->all(), 'sA' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'area_moment', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['materials'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What load buckles the example 3 m steel tube?', 'answer' => '60.8109 kN.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Column length" value="3" placeholder="Column length">
            <label for="calc-L-unit" class="sr-only">Column length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="ends" label="End conditions" :options="['pp' => 'Pinned–pinned (K = 1)', 'ff' => 'Fixed–fixed (K = 0.5)', 'fp' => 'Fixed–pinned (K = 0.7)', 'fc' => 'Fixed–free, a flagpole (K = 2)']" selected="pp" />
        <x-calc.select name="mat" label="Material" :options="['a36' => 'Structural steel (A36)', 'steel_4140' => 'Alloy steel 4140 (quenched and tempered)', 'ss304' => 'Stainless steel 304 (annealed)', 'al6061' => 'Aluminium 6061-T6', 'al7075' => 'Aluminium 7075-T6', 'copper' => 'Copper (annealed)', 'brass' => 'Brass C360 (free-cutting)', 'ti64' => 'Titanium Ti-6Al-4V', 'cast_iron' => 'Grey cast iron (class 30)', 'concrete' => 'Concrete (30 MPa)', 'glass' => 'Soda-lime glass', 'nylon' => 'Nylon 6/6', 'pvc' => 'Rigid PVC', 'oak' => 'Oak (along the grain)', 'custom' => 'Other (enter the value)']" selected="a36" />
        <div data-show-when="mat:custom">
            <x-calc.field name="E" label="Young's modulus" value="200" min="0" placeholder="Young's modulus">
                <label for="calc-E-unit" class="sr-only">Young's modulus unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mat:custom">
            <x-calc.field name="sy" label="Yield strength (optional)" value="250" min="0" placeholder="Yield strength (optional)">
                <label for="calc-sy-unit" class="sr-only">Yield strength (optional) unit</label>
                <select id="calc-sy-unit" name="sy-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="section" label="Section" :options="['round' => 'Solid round bar', 'tube' => 'Round tube', 'rect' => 'Solid rectangle', 'box' => 'Square hollow section', 'given' => 'I and A known']" selected="tube" />
        <div data-show-when="section:round,tube,box">
            <x-calc.field name="sd" label="Outer diameter or width" value="60" placeholder="Outer diameter or width">
                <label for="calc-sd-unit" class="sr-only">Outer diameter or width unit</label>
                <select id="calc-sd-unit" name="sd-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="section:tube,box">
            <x-calc.field name="st" label="Wall thickness" value="4" placeholder="Wall thickness">
                <label for="calc-st-unit" class="sr-only">Wall thickness unit</label>
                <select id="calc-st-unit" name="st-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="section:rect">
            <x-calc.field name="sb" label="Width b" value="50" placeholder="Width b">
                <label for="calc-sb-unit" class="sr-only">Width b unit</label>
                <select id="calc-sb-unit" name="sb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="section:rect">
            <x-calc.field name="sh" label="Depth h" value="100" placeholder="Depth h">
                <label for="calc-sh-unit" class="sr-only">Depth h unit</label>
                <select id="calc-sh-unit" name="sh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="section:given">
            <x-calc.field name="sI" label="Least second moment I" value="30" min="0" placeholder="Least second moment I">
                <label for="calc-sI-unit" class="sr-only">Least second moment I unit</label>
                <select id="calc-sI-unit" name="sI-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area_moment'))->only(['m4', 'cm4', 'mm4', 'in4', 'ft4']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm4')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="section:given">
            <x-calc.field name="sA" label="Area A" value="7" min="0" placeholder="Area A">
                <label for="calc-sA-unit" class="sr-only">Area A unit</label>
                <select id="calc-sA-unit" name="sA-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="kn" />
    </div>

    <x-calc.result label="Euler critical load" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kn', 'L' => 3, 'L-unit' => 'm', 'ends' => 'pp', 'mat' => 'a36', 'E' => 200, 'E-unit' => 'gpa', 'sy' => 250, 'sy-unit' => 'mpa', 'section' => 'tube', 'sd' => 60, 'sd-unit' => 'mm', 'st' => 4, 'st-unit' => 'mm', 'sb' => 50, 'sb-unit' => 'mm', 'sh' => 100, 'sh-unit' => 'mm', 'sI' => 30, 'sI-unit' => 'cm4', 'sA' => 7, 'sA-unit' => 'cm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sigma' => ['label' => 'Critical stress'],
            'slender' => ['label' => 'Slenderness ratio KL/r'],
            'regime' => ['label' => 'Check'],
            'johnson' => ['label' => 'Johnson load (short columns)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
