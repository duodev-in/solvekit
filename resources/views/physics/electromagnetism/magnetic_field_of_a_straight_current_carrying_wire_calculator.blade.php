<x-calc.page
    title="Magnetic Field of a Straight Current-Carrying Wire Calculator - SolveKit"
    description="Free magnetic field of a wire calculator: B = μ₀I/2πr around a long straight conductor."
    lede="Solve B = μ₀I ÷ 2πr."
    about="The field around a long straight wire circles it and falls off as 1/r. 10 A gives 20 µT at 10 cm, about half Earth’s field."
    :calc="['engine' => 'ph-em', 'tool' => 'wire_field', 'fields' => ['solve', 'B', 'I', 'r', 'out_B', 'out_I', 'out_r'], 'unitFields' => ['B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['B', 'current', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What field does 10 A make 10 cm away?', 'answer' => '20 µT.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['B' => 'Magnetic field', 'I' => 'Current', 'r' => 'Distance from the wire']" selected="B" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:I,r" hidden>
            <x-calc.field name="B" label="Magnetic field" value="20" placeholder="Magnetic field">
                <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
                <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ut')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:B,r">
            <x-calc.field name="I" label="Current" value="10" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:B,I">
            <x-calc.field name="r" label="Distance from the wire" value="10" placeholder="Distance from the wire">
                <label for="calc-r-unit" class="sr-only">Distance from the wire unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:B">
            <x-calc.select name="out_B" label="Show the result in" :options="['t' => 'T', 'mt' => 'mT', 'ut' => 'µT', 'nt' => 'nT', 'gauss' => 'G', 'mgauss' => 'mG']" selected="ut" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <x-calc.result label="Magnetic field" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'B', 'B' => 20, 'B-unit' => 'ut', 'out_B' => 'ut', 'I' => 10, 'I-unit' => 'a', 'out_I' => 'a', 'r' => 10, 'r-unit' => 'cm', 'out_r' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'earth' => ['label' => 'Compared with Earth’s field (≈ 50 µT)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B = μ₀ I ÷ (2π r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
