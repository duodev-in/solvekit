<x-calc.page
    title="Pneumatic Cylinder Force Calculator - SolveKit"
    description="Free pneumatic cylinder calculator: push and pull force and air use per cycle."
    lede="Find pneumatic cylinder force."
    about="Force is pressure times piston area, less friction. The rod side has less area, so pull is weaker; single-acting cylinders also fight their spring."
    :calc="['engine' => 'ph-fluid', 'tool' => 'pneumatic_cylinder', 'fields' => ['P', 'bore', 'rod', 'action', 'spring', 'stroke', 'eff', 'out'], 'unitFields' => ['P' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'bore' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rod' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'spring' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'stroke' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 50 mm cylinder push at 6 bar?', 'answer' => '1,060.29 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="P" label="Supply pressure (gauge)" value="6" min="0" placeholder="Supply pressure (gauge)">
            <label for="calc-P-unit" class="sr-only">Supply pressure (gauge) unit</label>
            <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'bar')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bore" label="Bore" value="50" placeholder="Bore">
            <label for="calc-bore-unit" class="sr-only">Bore unit</label>
            <select id="calc-bore-unit" name="bore-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rod" label="Rod diameter" value="20" placeholder="Rod diameter">
            <label for="calc-rod-unit" class="sr-only">Rod diameter unit</label>
            <select id="calc-rod-unit" name="rod-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="action" label="Action" :options="['double' => 'Double acting', 'single' => 'Single acting (spring return)']" selected="double" />
        <div data-show-when="action:single">
            <x-calc.field name="spring" label="Spring force at full stroke" value="80" placeholder="Spring force at full stroke">
                <label for="calc-spring-unit" class="sr-only">Spring force at full stroke unit</label>
                <select id="calc-spring-unit" name="spring-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="stroke" label="Stroke (for air use)" value="100" placeholder="Stroke (for air use)">
            <label for="calc-stroke-unit" class="sr-only">Stroke (for air use) unit</label>
            <select id="calc-stroke-unit" name="stroke-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eff" label="Efficiency (friction) %" value="90" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Extend (push) force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'P' => 6, 'P-unit' => 'bar', 'bore' => 50, 'bore-unit' => 'mm', 'rod' => 20, 'rod-unit' => 'mm', 'action' => 'double', 'spring' => 80, 'spring-unit' => 'n', 'stroke' => 100, 'stroke-unit' => 'mm', 'eff' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pull' => ['label' => 'Retract (pull) force'],
            'air' => ['label' => 'Free air used per cycle'],
            'kg' => ['label' => 'Push as a mass'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
