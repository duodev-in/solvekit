<x-calc.page
    title="Density Calculator - SolveKit"
    description="Free density calculator: ρ = m/V for density, mass or volume in any units."
    lede="Solve ρ = m ÷ V."
    about="Density is mass per unit volume. Water is 1,000 kg/m³ (1 g/cm³); steel is about 7,850 kg/m³."
    :calc="['engine' => 'ph-mat', 'tool' => 'density', 'fields' => ['solve', 'rho', 'm', 'V', 'out_rho', 'out_m', 'out_V'], 'unitFields' => ['rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'rho', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the density of 7.85 kg in 1 L?', 'answer' => '7,850 kg/m³.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['rho' => 'Density', 'm' => 'Mass', 'V' => 'Volume']" selected="rho" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,V" hidden>
            <x-calc.field name="rho" label="Density" value="7850" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:rho,V">
            <x-calc.field name="m" label="Mass" value="7.85" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:rho,m">
            <x-calc.field name="V" label="Volume" value="1" min="0" placeholder="Volume">
                <label for="calc-V-unit" class="sr-only">Volume unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:rho">
            <x-calc.select name="out_rho" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:V" hidden>
            <x-calc.select name="out_V" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
    </div>

    <x-calc.result label="Density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'rho', 'rho' => 7850, 'rho-unit' => 'kgm3', 'out_rho' => 'kgm3', 'm' => 7.85, 'm-unit' => 'kg', 'out_m' => 'kg', 'V' => 1, 'V-unit' => 'l', 'out_V' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'sg' => ['label' => 'Specific gravity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ρ = m ÷ V</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
