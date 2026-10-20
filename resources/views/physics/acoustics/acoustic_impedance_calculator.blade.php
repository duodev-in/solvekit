<x-calc.page
    title="Acoustic Impedance Calculator - SolveKit"
    description="Free acoustic impedance calculator: Z = ρc from density and speed of sound, with reflection at an air boundary."
    lede="Solve Z = ρc."
    about="Acoustic impedance is density times sound speed. When sound meets a boundary, the bigger the impedance mismatch the more is reflected, which is why ultrasound needs gel."
    :calc="['engine' => 'ph-wave', 'tool' => 'acoustic_impedance', 'fields' => ['solve', 'Z', 'rho', 'c', 'out_rho', 'out_c'], 'unitFields' => ['rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'c' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['Z', 'density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the impedance of water?', 'answer' => '1,479,040 rayl.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Z' => 'Acoustic impedance (Pa·s/m, rayl)', 'rho' => 'Density', 'c' => 'Speed of sound']" selected="Z" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:rho,c" hidden>
            <x-calc.field name="Z" label="Acoustic impedance (Pa·s/m, rayl)" value="1479036" step="any" />
        </div>
        <div data-show-when="solve:Z,c">
            <x-calc.field name="rho" label="Density" value="998" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Z,rho">
            <x-calc.field name="c" label="Speed of sound" value="1482" placeholder="Speed of sound">
                <label for="calc-c-unit" class="sr-only">Speed of sound unit</label>
                <select id="calc-c-unit" name="c-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:rho" hidden>
            <x-calc.select name="out_rho" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
        </div>
        <div data-show-when="solve:c" hidden>
            <x-calc.select name="out_c" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
    </div>

    <x-calc.result label="Acoustic impedance (Pa·s/m, rayl)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Z', 'Z' => 1479036, 'rho' => 998, 'rho-unit' => 'kgm3', 'out_rho' => 'kgm3', 'c' => 1482, 'c-unit' => 'ms', 'out_c' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'mrayl' => ['label' => 'In MRayl'],
            'air' => ['label' => 'Sound reflected at a boundary with air (413 rayl)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Z = ρ c</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
