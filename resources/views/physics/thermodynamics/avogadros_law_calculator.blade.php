<x-calc.page
    title="Avogadro’s Law Calculator - SolveKit"
    description="Free Avogadro's law calculator: V₁/n₁ = V₂/n₂, solved for any value."
    lede="Solve V₁/n₁ = V₂/n₂."
    about="At the same temperature and pressure, equal volumes of gas hold equal numbers of molecules."
    :calc="['engine' => 'ph-thermo', 'tool' => 'avogadro', 'fields' => ['solve', 'V1', 'n1', 'V2', 'n2', 'out_V1', 'out_V2'], 'unitFields' => ['V1' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'V2' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What volume do 2 mol take if 1 mol takes 22.4 L?', 'answer' => '44.8 L.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['V1' => 'Volume 1', 'n1' => 'Amount 1 (mol)', 'V2' => 'Volume 2', 'n2' => 'Amount 2 (mol)']" selected="V2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:n1,V2,n2">
            <x-calc.field name="V1" label="Volume 1" value="22.4" min="0" placeholder="Volume 1">
                <label for="calc-V1-unit" class="sr-only">Volume 1 unit</label>
                <select id="calc-V1-unit" name="V1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:V1,V2,n2">
            <x-calc.field name="n1" label="Amount 1 (mol)" value="1" step="any" />
        </div>
        <div data-show-when="solve:V1,n1,n2" hidden>
            <x-calc.field name="V2" label="Volume 2" value="44.8" min="0" placeholder="Volume 2">
                <label for="calc-V2-unit" class="sr-only">Volume 2 unit</label>
                <select id="calc-V2-unit" name="V2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:V1,n1,V2">
            <x-calc.field name="n2" label="Amount 2 (mol)" value="2" step="any" />
        </div>
        <div data-show-when="solve:V1" hidden>
            <x-calc.select name="out_V1" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
        <div data-show-when="solve:V2">
            <x-calc.select name="out_V2" label="Show the result in" :options="['m3' => 'm³', 'l' => 'L', 'ml' => 'mL', 'ft3' => 'ft³', 'in3' => 'in³', 'gal_us' => 'gal', 'gal_uk' => 'imp gal']" selected="l" />
        </div>
    </div>

    <x-calc.result label="Volume 2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'V2', 'V1' => 22.4, 'V1-unit' => 'l', 'out_V1' => 'l', 'n1' => 1, 'V2' => 44.8, 'V2-unit' => 'l', 'out_V2' => 'l', 'n2' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'molar' => ['label' => 'Molar volume'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V₁ ÷ n₁ = V₂ ÷ n₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
