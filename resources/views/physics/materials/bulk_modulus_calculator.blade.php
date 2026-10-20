<x-calc.page
    title="Bulk Modulus Calculator - SolveKit"
    description="Free bulk modulus calculator: K = −VΔP/ΔV from a pressure change and volume change, solved for any value."
    lede="Solve K = −VΔP ÷ ΔV."
    about="The bulk modulus measures resistance to uniform compression: the pressure needed for a given fractional loss of volume. Water is about 2.2 GPa, steel about 160 GPa."
    :calc="['engine' => 'ph-mat', 'tool' => 'bulk_modulus', 'fields' => ['solve', 'K', 'dP', 'V', 'dV', 'out_K', 'out_dP', 'out_V', 'out_dV'], 'unitFields' => ['K' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'dV' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['K', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What K gives a 4.5 ml loss from 1 L under 10 MPa?', 'answer' => '2.19998 GPa.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['K' => 'Bulk modulus', 'dP' => 'Pressure increase', 'V' => 'Original volume', 'dV' => 'Volume decrease']" selected="K" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:dP,V,dV" hidden>
            <x-calc.field name="K" label="Bulk modulus" value="2.2" min="0" placeholder="Bulk modulus">
                <label for="calc-K-unit" class="sr-only">Bulk modulus unit</label>
                <select id="calc-K-unit" name="K-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:K,V,dV">
            <x-calc.field name="dP" label="Pressure increase" value="10" min="0" placeholder="Pressure increase">
                <label for="calc-dP-unit" class="sr-only">Pressure increase unit</label>
                <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:K,dP,dV">
            <x-calc.field name="V" label="Original volume" value="1" min="0" placeholder="Original volume">
                <label for="calc-V-unit" class="sr-only">Original volume unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:K,dP,V">
            <x-calc.field name="dV" label="Volume decrease" value="4.5455" min="0" placeholder="Volume decrease">
                <label for="calc-dV-unit" class="sr-only">Volume decrease unit</label>
                <select id="calc-dV-unit" name="dV-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:K">
            <x-calc.select name="out_K" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="gpa" />
        </div>
        <div data-show-when="solve:dP" hidden>
            <x-calc.select name="out_dP" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="mpa" />
        </div>
        <div data-show-when="solve:V" hidden>
            <x-calc.select name="out_V" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
        <div data-show-when="solve:dV" hidden>
            <x-calc.select name="out_dV" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="ml" />
        </div>
    </div>

    <x-calc.result label="Bulk modulus" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'K', 'K' => 2.2, 'K-unit' => 'gpa', 'out_K' => 'gpa', 'dP' => 10, 'dP-unit' => 'mpa', 'out_dP' => 'mpa', 'V' => 1, 'V-unit' => 'l', 'out_V' => 'l', 'dV' => 4.5455, 'dV-unit' => 'ml', 'out_dV' => 'ml'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'comp' => ['label' => 'Compressibility 1/K'],
            'strain' => ['label' => 'Volumetric strain'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>K = −V ΔP ÷ ΔV</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
