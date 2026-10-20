<x-calc.page
    title="Specific Impulse Calculator - SolveKit"
    description="Free specific impulse calculator: Isp in seconds from thrust and mass flow, or from exhaust velocity."
    lede="Find specific impulse."
    about="Specific impulse measures engine efficiency: thrust per unit weight-flow of propellant, in seconds. It equals the exhaust velocity divided by g₀."
    :calc="['engine' => 'ph-astro', 'tool' => 'specific_impulse', 'fields' => ['mode', 'F', 'mdot', 've'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'mdot' => collect(config('units.mass_flow'))->only(['kgs', 'gs', 'kgmin', 'kgh', 'lbs', 'lbmin', 'lbh'])->all(), 've' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'mass_flow', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What Isp does 845 kN from 277 kg/s give?', 'answer' => '311.07 s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['thrust' => 'Thrust and mass flow', 've' => 'Effective exhaust velocity']" selected="thrust" />
        <div data-show-when="mode:thrust">
            <x-calc.field name="F" label="Thrust" value="845" placeholder="Thrust">
                <label for="calc-F-unit" class="sr-only">Thrust unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:thrust">
            <x-calc.field name="mdot" label="Mass flow rate" value="277" min="0" placeholder="Mass flow rate">
                <label for="calc-mdot-unit" class="sr-only">Mass flow rate unit</label>
                <select id="calc-mdot-unit" name="mdot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass_flow'))->only(['kgs', 'gs', 'kgmin', 'kgh', 'lbs', 'lbmin', 'lbh']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgs')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:ve">
            <x-calc.field name="ve" label="Exhaust velocity" value="2990" placeholder="Exhaust velocity">
                <label for="calc-ve-unit" class="sr-only">Exhaust velocity unit</label>
                <select id="calc-ve-unit" name="ve-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Specific impulse" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'thrust', 'F' => 845, 'F-unit' => 'kn', 'mdot' => 277, 'mdot-unit' => 'kgs', 've' => 2990, 've-unit' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            've' => ['label' => 'Effective exhaust velocity'],
            'typical' => ['label' => 'Typical values'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
