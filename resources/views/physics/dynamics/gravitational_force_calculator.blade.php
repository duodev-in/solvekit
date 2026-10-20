<x-calc.page
    title="Gravitational Force Calculator - SolveKit"
    description="Free gravitational force calculator: Newton’s law of gravitation F = Gm₁m₂/r², solved for any value."
    lede="Solve F = Gm₁m₂ ÷ r²."
    about="Every two masses attract with a force proportional to both masses and inversely to the square of the distance between their centres. G = 6.674 × 10⁻¹¹ N·m²/kg² (CODATA 2018)."
    :calc="['engine' => 'ph-mech', 'tool' => 'gravitational_force', 'fields' => ['solve', 'F', 'm1', 'm2', 'r', 'out_F', 'out_m1', 'out_m2', 'out_r'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'm1' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'm2' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['F', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the Earth–Moon gravitational force?', 'answer' => '1.98056 × 10²⁰ N.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['F' => 'Gravitational force', 'm1' => 'Mass 1', 'm2' => 'Mass 2', 'r' => 'Distance between centres']" selected="F" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m1,m2,r" hidden>
            <x-calc.field name="F" label="Gravitational force" value="198000000000000000000" placeholder="Gravitational force">
                <label for="calc-F-unit" class="sr-only">Gravitational force unit</label>
                <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,m2,r">
            <x-calc.field name="m1" label="Mass 1" value="5.9722e+24" min="0" placeholder="Mass 1">
                <label for="calc-m1-unit" class="sr-only">Mass 1 unit</label>
                <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,m1,r">
            <x-calc.field name="m2" label="Mass 2" value="7.342e+22" min="0" placeholder="Mass 2">
                <label for="calc-m2-unit" class="sr-only">Mass 2 unit</label>
                <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F,m1,m2">
            <x-calc.field name="r" label="Distance between centres" value="384400" placeholder="Distance between centres">
                <label for="calc-r-unit" class="sr-only">Distance between centres unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:F">
            <x-calc.select name="out_F" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:m1" hidden>
            <x-calc.select name="out_m1" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:m2" hidden>
            <x-calc.select name="out_m2" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="km" />
        </div>
    </div>

    <x-calc.result label="Gravitational force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'F', 'F' => 198000000000000000000, 'F-unit' => 'n', 'out_F' => 'n', 'm1' => 5.9722e+24, 'm1-unit' => 'kg', 'out_m1' => 'kg', 'm2' => 7.342e+22, 'm2-unit' => 'kg', 'out_m2' => 'kg', 'r' => 384400, 'r-unit' => 'km', 'out_r' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'field' => ['label' => 'Field of mass 1 at that distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = G m₁ m₂ ÷ r²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
