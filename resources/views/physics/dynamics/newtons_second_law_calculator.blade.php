<x-calc.page
    title="Newton's Second Law Calculator - SolveKit"
    description="Free Newton's second law calculator: solve F = ma for force, mass or acceleration in any units."
    lede="Solve F = ma."
    about="Newton's second law says the net force on a body equals its mass times its acceleration, F = ma. Pushing a 2 kg trolley with 10 N accelerates it at 5 m/s². Choose the unknown and enter the other two in any units."
    :calc="['engine' => 'ph-mech', 'tool' => 'newton2', 'fields' => ['solve', 'F', 'm', 'a', 'out_F', 'out_m', 'out_a'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'a' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['F', 'acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What force accelerates 2 kg at 5 m/s²?', 'answer' => '10 N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['F' => 'Force', 'm' => 'Mass', 'a' => 'Acceleration']" selected="F" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,a" hidden>
            <x-calc.field name="F" label="Force" value="10" placeholder="Force">
                <label for="calc-F-unit" class="sr-only">Force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,a">
            <x-calc.field name="m" label="Mass" value="2" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,m">
            <x-calc.field name="a" label="Acceleration" value="5" placeholder="Acceleration">
                <label for="calc-a-unit" class="sr-only">Acceleration unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F">
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:a" hidden>
            <x-calc.select name="out_a" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
        </div>
    </div>

    <x-calc.result label="Force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'F', 'F' => 10, 'F-unit' => 'n', 'out_F' => 'n', 'm' => 2, 'm-unit' => 'kg', 'out_m' => 'kg', 'a' => 5, 'a-unit' => 'ms2', 'out_a' => 'ms2'],
        'Mass' => ['solve' => 'm', 'F' => 10, 'F-unit' => 'n', 'out_F' => 'n', 'm' => 2, 'm-unit' => 'kg', 'out_m' => 'kg', 'a' => 5, 'a-unit' => 'ms2', 'out_a' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'weight' => ['label' => 'Weight of the mass on Earth'],
            'g' => ['label' => 'Acceleration in g'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = m × a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
