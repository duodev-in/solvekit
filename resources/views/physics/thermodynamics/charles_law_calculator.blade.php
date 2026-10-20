<x-calc.page
    title="Charles' Law Calculator - SolveKit"
    description="Free Charles' law calculator: V₁/T₁ = V₂/T₂ at constant pressure, solved for any value."
    lede="Solve V₁/T₁ = V₂/T₂."
    about="At constant pressure a gas’s volume is proportional to its absolute temperature."
    :calc="['engine' => 'ph-thermo', 'tool' => 'charles', 'fields' => ['solve', 'V1', 'T1', 'V2', 'T2', 'out_V1', 'out_T1', 'out_V2', 'out_T2'], 'unitFields' => ['V1' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'V2' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'T2' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What volume does 10 L at 20 °C take at 50 °C?', 'answer' => '11.0234 L.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['V1' => 'Volume 1', 'T1' => 'Temperature 1', 'V2' => 'Volume 2', 'T2' => 'Temperature 2']" selected="V2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:T1,V2,T2">
            <x-calc.field name="V1" label="Volume 1" value="10" min="0" placeholder="Volume 1">
                <label for="calc-V1-unit" class="sr-only">Volume 1 unit</label>
                <select id="calc-V1-unit" name="V1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:V1,V2,T2">
            <x-calc.field name="T1" label="Temperature 1" value="20" placeholder="Temperature 1">
                <label for="calc-T1-unit" class="sr-only">Temperature 1 unit</label>
                <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:V1,T1,T2" hidden>
            <x-calc.field name="V2" label="Volume 2" value="11.023" min="0" placeholder="Volume 2">
                <label for="calc-V2-unit" class="sr-only">Volume 2 unit</label>
                <select id="calc-V2-unit" name="V2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:V1,T1,V2">
            <x-calc.field name="T2" label="Temperature 2" value="50" placeholder="Temperature 2">
                <label for="calc-T2-unit" class="sr-only">Temperature 2 unit</label>
                <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:V1" hidden>
            <x-calc.select name="out_V1" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
        <div data-show-when="solve:T1" hidden>
            <x-calc.select name="out_T1" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
        </div>
        <div data-show-when="solve:V2">
            <x-calc.select name="out_V2" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
        <div data-show-when="solve:T2" hidden>
            <x-calc.select name="out_T2" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
        </div>
    </div>

    <x-calc.result label="Volume 2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'V2', 'V1' => 10, 'V1-unit' => 'l', 'out_V1' => 'l', 'T1' => 20, 'T1-unit' => 'c', 'out_T1' => 'c', 'V2' => 11.023, 'V2-unit' => 'l', 'out_V2' => 'l', 'T2' => 50, 'T2-unit' => 'c', 'out_T2' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'change' => ['label' => 'Volume change'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V₁ ÷ T₁ = V₂ ÷ T₂ (constant P, kelvin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
