<x-calc.page
    title="Boyle's Law Calculator - SolveKit"
    description="Free Boyle's law calculator: P₁V₁ = P₂V₂ at constant temperature, solved for any value."
    lede="Solve P₁V₁ = P₂V₂."
    about="At constant temperature a gas’s pressure and volume are inversely proportional."
    :calc="['engine' => 'ph-thermo', 'tool' => 'boyle', 'fields' => ['solve', 'P1', 'V1', 'P2', 'V2', 'out_P1', 'out_V1', 'out_P2', 'out_V2'], 'unitFields' => ['P1' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'V1' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'P2' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'V2' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What volume does 10 L at 100 kPa take at 200 kPa?', 'answer' => '5 L.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['P1' => 'Pressure 1', 'V1' => 'Volume 1', 'P2' => 'Pressure 2', 'V2' => 'Volume 2']" selected="V2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:V1,P2,V2">
            <x-calc.field name="P1" label="Pressure 1" value="100" min="0" placeholder="Pressure 1">
                <label for="calc-P1-unit" class="sr-only">Pressure 1 unit</label>
                <select id="calc-P1-unit" name="P1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,P2,V2">
            <x-calc.field name="V1" label="Volume 1" value="10" min="0" placeholder="Volume 1">
                <label for="calc-V1-unit" class="sr-only">Volume 1 unit</label>
                <select id="calc-V1-unit" name="V1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,V1,V2">
            <x-calc.field name="P2" label="Pressure 2" value="200" min="0" placeholder="Pressure 2">
                <label for="calc-P2-unit" class="sr-only">Pressure 2 unit</label>
                <select id="calc-P2-unit" name="P2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,V1,P2" hidden>
            <x-calc.field name="V2" label="Volume 2" value="5" min="0" placeholder="Volume 2">
                <label for="calc-V2-unit" class="sr-only">Volume 2 unit</label>
                <select id="calc-V2-unit" name="V2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1" hidden>
            <x-calc.select name="out_P1" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:V1" hidden>
            <x-calc.select name="out_V1" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
        <div data-show-when="solve:P2" hidden>
            <x-calc.select name="out_P2" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:V2">
            <x-calc.select name="out_V2" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
    </div>

    <x-calc.result label="Volume 2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'V2', 'P1' => 100, 'P1-unit' => 'kpa', 'out_P1' => 'kpa', 'V1' => 10, 'V1-unit' => 'l', 'out_V1' => 'l', 'P2' => 200, 'P2-unit' => 'kpa', 'out_P2' => 'kpa', 'V2' => 5, 'V2-unit' => 'l', 'out_V2' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ratio' => ['label' => 'Compression ratio V₁/V₂'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P₁V₁ = P₂V₂ (constant T and n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
