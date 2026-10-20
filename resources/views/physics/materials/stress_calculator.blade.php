<x-calc.page
    title="Stress Calculator - SolveKit"
    description="Free stress calculator: normal stress σ = F/A, solved for stress, force or area."
    lede="Solve σ = F ÷ A."
    about="Normal stress is force per unit area perpendicular to a cut. One megapascal is one newton per square millimetre."
    :calc="['engine' => 'ph-mat', 'tool' => 'stress', 'fields' => ['solve', 's', 'F', 'A', 'out_s', 'out_F', 'out_A'], 'unitFields' => ['s' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'pressure', 's', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the stress of 50 kN on 500 mm²?', 'answer' => '100 MPa.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['s' => 'Normal stress', 'F' => 'Force', 'A' => 'Cross-section area']" selected="s" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:F,A" hidden>
            <x-calc.field name="s" label="Normal stress" value="100" min="0" placeholder="Normal stress">
                <label for="calc-s-unit" class="sr-only">Normal stress unit</label>
                <select id="calc-s-unit" name="s-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:s,A">
            <x-calc.field name="F" label="Force" value="50" placeholder="Force">
                <label for="calc-F-unit" class="sr-only">Force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kn')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:s,F">
            <x-calc.field name="A" label="Cross-section area" value="500" min="0" placeholder="Cross-section area">
                <label for="calc-A-unit" class="sr-only">Cross-section area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:s">
            <x-calc.select name="out_s" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
        </div>
        <div data-show-when="solve:F" hidden>
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="kn" />
        </div>
        <div data-show-when="solve:A" hidden>
            <x-calc.select name="out_A" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="mm2" />
        </div>
    </div>

    <x-calc.result label="Normal stress" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 's', 's' => 100, 's-unit' => 'mpa', 'out_s' => 'mpa', 'F' => 50, 'F-unit' => 'kn', 'out_F' => 'kn', 'A' => 500, 'A-unit' => 'mm2', 'out_A' => 'mm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>σ = F ÷ A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
