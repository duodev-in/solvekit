<x-calc.page
    title="Tension Calculator - SolveKit"
    description="Free tension calculator: rope tension for a hanging or accelerating mass, or a mass held by two angled ropes."
    lede="Find the tension in ropes."
    about="For a mass on two ropes, the horizontal parts of the tensions cancel and the vertical parts hold the weight. Shallow ropes need much larger tensions. A single rope lifting a mass with acceleration a carries m(g + a)."
    :calc="['engine' => 'ph-mech', 'tool' => 'tension', 'fields' => ['setup', 'm', 'a', 't1', 't2', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'a' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 't1' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 't2' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What are the tensions holding 10 kg on ropes at 30° and 45°?', 'answer' => 'T₁ = 71.7897 N, T₂ = 87.924 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="setup" label="Set-up" :options="['hang' => 'Mass on one vertical rope (with acceleration)', 'two' => 'Mass held by two angled ropes']" selected="two" />
        <x-calc.field name="m" label="Mass" value="10" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="setup:hang">
            <x-calc.field name="a" label="Upward acceleration" value="0" placeholder="Upward acceleration">
                <label for="calc-a-unit" class="sr-only">Upward acceleration unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="setup:two">
            <x-calc.field name="t1" label="Rope 1 angle above horizontal" value="30" placeholder="Rope 1 angle above horizontal">
                <label for="calc-t1-unit" class="sr-only">Rope 1 angle above horizontal unit</label>
                <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="setup:two">
            <x-calc.field name="t2" label="Rope 2 angle above horizontal" value="45" placeholder="Rope 2 angle above horizontal">
                <label for="calc-t2-unit" class="sr-only">Rope 2 angle above horizontal unit</label>
                <select id="calc-t2-unit" name="t2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Tension" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'setup' => 'two', 'm' => 10, 'm-unit' => 'kg', 'a' => 0, 'a-unit' => 'ms2', 't1' => 30, 't1-unit' => 'deg', 't2' => 45, 't2-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T1' => ['label' => 'Tension in rope 1'],
            'T2' => ['label' => 'Tension in rope 2'],
            'W' => ['label' => 'Weight'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
