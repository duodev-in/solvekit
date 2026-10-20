<x-calc.page
    title="Friction Calculator - SolveKit"
    description="Free friction calculator: friction force from the coefficient of friction and normal force, or solve for either."
    lede="Solve F = μN."
    about="Friction resists sliding with a force proportional to how hard the surfaces press together: F = μN. Static friction μ_s is the limit before something starts to slide; kinetic friction μ_k (usually smaller) acts while it slides. Rubber on dry asphalt is about 0.7, steel on steel about 0.6 (dry) and ice about 0.05–0.1."
    :calc="['engine' => 'ph-mech', 'tool' => 'friction', 'fields' => ['solve', 'F', 'mu', 'N', 'out_F', 'out_N'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'N' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all()], 'data' => ['units' => collect(config('units'))->only(['F', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the friction on a 10 kg box (N = 98.07 N) with μ = 0.4?', 'answer' => '39.2266 N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['F' => 'Friction force', 'mu' => 'Coefficient of friction μ', 'N' => 'Normal force']" selected="F" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:mu,N" hidden>
            <x-calc.field name="F" label="Friction force" value="39.2" placeholder="Friction force">
                <label for="calc-F-unit" class="sr-only">Friction force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,N">
            <x-calc.field name="mu" label="Coefficient of friction μ" value="0.4" step="any" />
        </div>
        <div data-show-when="solve:F,mu">
            <x-calc.field name="N" label="Normal force" value="98.0665" placeholder="Normal force">
                <label for="calc-N-unit" class="sr-only">Normal force unit</label>
                <select id="calc-N-unit" name="N-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F">
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:N" hidden>
            <x-calc.select name="out_N" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
    </div>

    <x-calc.result label="Friction force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'F', 'F' => 39.2, 'F-unit' => 'n', 'out_F' => 'n', 'mu' => 0.4, 'N' => 98.0665, 'N-unit' => 'n', 'out_N' => 'n'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'mass' => ['label' => 'Mass resting on a level surface'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = μ N</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
