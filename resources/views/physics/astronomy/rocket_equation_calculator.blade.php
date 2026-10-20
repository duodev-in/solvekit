<x-calc.page
    title="Rocket Equation Calculator - SolveKit"
    description="Free Tsiolkovsky rocket equation calculator: solve Δv = v_e ln(m₀/m_f) for delta-v, exhaust velocity or either mass."
    lede="Solve the rocket equation."
    about="The rocket equation shows why rockets are mostly fuel: each extra km/s of delta-v multiplies the mass ratio by the same factor."
    :calc="['engine' => 'ph-astro', 'tool' => 'rocket_equation', 'fields' => ['solve', 'dv', 've', 'm0', 'mf', 'out_dv', 'out_ve', 'out_m0', 'out_mf'], 'unitFields' => ['dv' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 've' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'm0' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'mf' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How much of a 100 t rocket is left after 9.4 km/s at 3.4 km/s exhaust?', 'answer' => '6.29946 t.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['dv' => 'Delta-v', 've' => 'Exhaust velocity', 'm0' => 'Initial (wet) mass', 'mf' => 'Final (dry) mass']" selected="mf" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:ve,m0,mf">
            <x-calc.field name="dv" label="Delta-v" value="9.4" placeholder="Delta-v">
                <label for="calc-dv-unit" class="sr-only">Delta-v unit</label>
                <select id="calc-dv-unit" name="dv-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:dv,m0,mf">
            <x-calc.field name="ve" label="Exhaust velocity" value="3.4" placeholder="Exhaust velocity">
                <label for="calc-ve-unit" class="sr-only">Exhaust velocity unit</label>
                <select id="calc-ve-unit" name="ve-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:dv,ve,mf">
            <x-calc.field name="m0" label="Initial (wet) mass" value="100" min="0" placeholder="Initial (wet) mass">
                <label for="calc-m0-unit" class="sr-only">Initial (wet) mass unit</label>
                <select id="calc-m0-unit" name="m0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:dv,ve,m0" hidden>
            <x-calc.field name="mf" label="Final (dry) mass" value="6.326" min="0" placeholder="Final (dry) mass">
                <label for="calc-mf-unit" class="sr-only">Final (dry) mass unit</label>
                <select id="calc-mf-unit" name="mf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:dv" hidden>
            <x-calc.select name="out_dv" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
        </div>
        <div data-show-when="solve:ve" hidden>
            <x-calc.select name="out_ve" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
        </div>
        <div data-show-when="solve:m0" hidden>
            <x-calc.select name="out_m0" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="t" />
        </div>
        <div data-show-when="solve:mf">
            <x-calc.select name="out_mf" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="t" />
        </div>
    </div>

    <x-calc.result label="Final (dry) mass" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'mf', 'dv' => 9.4, 'dv-unit' => 'kms', 'out_dv' => 'kms', 've' => 3.4, 've-unit' => 'kms', 'out_ve' => 'kms', 'm0' => 100, 'm0-unit' => 't', 'out_m0' => 't', 'mf' => 6.326, 'mf-unit' => 't', 'out_mf' => 't'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ratio' => ['label' => 'Mass ratio'],
            'prop' => ['label' => 'Propellant share of the starting mass'],
            'isp' => ['label' => 'Specific impulse'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Δv = v_e ln(m₀ ÷ m_f)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
