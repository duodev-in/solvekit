<x-calc.page
    title="Factor of Safety Calculator - SolveKit"
    description="Free factor of safety calculator: FoS and margin of safety from failure and working stress or load."
    lede="Find the factor of safety."
    about="The factor of safety is how many times stronger a part is than it needs to be: capacity divided by demand. The margin of safety is FoS − 1."
    :calc="['engine' => 'ph-mat', 'tool' => 'factor_safety', 'fields' => ['kind', 'fail', 'actual', 'failL', 'actualL'], 'unitFields' => ['fail' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'actual' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'failL' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'actualL' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the FoS for 250 MPa yield and 100 MPa working stress?', 'answer' => '2.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Compare" :options="['stress' => 'Stresses', 'load' => 'Loads']" selected="stress" />
        <div data-show-when="kind:stress">
            <x-calc.field name="fail" label="Failure stress (yield or ultimate)" value="250" min="0" placeholder="Failure stress (yield or ultimate)">
                <label for="calc-fail-unit" class="sr-only">Failure stress (yield or ultimate) unit</label>
                <select id="calc-fail-unit" name="fail-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:stress">
            <x-calc.field name="actual" label="Working stress" value="100" min="0" placeholder="Working stress">
                <label for="calc-actual-unit" class="sr-only">Working stress unit</label>
                <select id="calc-actual-unit" name="actual-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:load">
            <x-calc.field name="failL" label="Failure load" value="50" placeholder="Failure load">
                <label for="calc-failL-unit" class="sr-only">Failure load unit</label>
                <select id="calc-failL-unit" name="failL-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:load">
            <x-calc.field name="actualL" label="Working load" value="20" placeholder="Working load">
                <label for="calc-actualL-unit" class="sr-only">Working load unit</label>
                <select id="calc-actualL-unit" name="actualL-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Factor of safety" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'stress', 'fail' => 250, 'fail-unit' => 'mpa', 'actual' => 100, 'actual-unit' => 'mpa', 'failL' => 50, 'failL-unit' => 'kn', 'actualL' => 20, 'actualL-unit' => 'kn'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ms' => ['label' => 'Margin of safety (FoS − 1)'],
            'used' => ['label' => 'Share of capacity used'],
            'verdict' => ['label' => 'Assessment'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
