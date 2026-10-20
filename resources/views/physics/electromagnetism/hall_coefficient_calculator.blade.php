<x-calc.page
    title="Hall Coefficient Calculator - SolveKit"
    description="Free Hall coefficient calculator: R_H from Hall voltage, current, field and thickness, with carrier density."
    lede="Solve R_H = V_H t ÷ IB."
    about="Current in a magnetic field pushes carriers sideways, building a Hall voltage. Its sign shows whether carriers are electrons or holes; its size gives their density."
    :calc="['engine' => 'ph-em', 'tool' => 'hall', 'fields' => ['solve', 'RH', 'VH', 't', 'I', 'B', 'out_VH', 'out_t', 'out_I', 'out_B'], 'unitFields' => ['VH' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is R_H for the example copper strip?', 'answer' => '−7.37 × 10⁻¹¹ m³/C.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['RH' => 'Hall coefficient (m³/C)', 'VH' => 'Hall voltage', 't' => 'Sample thickness (along B)', 'I' => 'Current', 'B' => 'Magnetic field']" selected="RH" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:VH,t,I,B" hidden>
            <x-calc.field name="RH" label="Hall coefficient (m³/C)" value="-7.37e-11" step="any" />
        </div>
        <div data-show-when="solve:RH,t,I,B">
            <x-calc.field name="VH" label="Hall voltage" value="-0.737" placeholder="Hall voltage">
                <label for="calc-VH-unit" class="sr-only">Hall voltage unit</label>
                <select id="calc-VH-unit" name="VH-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uv')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:RH,VH,I,B">
            <x-calc.field name="t" label="Sample thickness (along B)" value="1" placeholder="Sample thickness (along B)">
                <label for="calc-t-unit" class="sr-only">Sample thickness (along B) unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:RH,VH,t,B">
            <x-calc.field name="I" label="Current" value="10" placeholder="Current">
                <label for="calc-I-unit" class="sr-only">Current unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:RH,VH,t,I">
            <x-calc.field name="B" label="Magnetic field" value="1" placeholder="Magnetic field">
                <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
                <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:VH" hidden>
            <x-calc.select name="out_VH" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="uv" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['a' => 'A', 'ma' => 'mA', 'ua' => 'µA', 'na' => 'nA', 'ka' => 'kA']" selected="a" />
        </div>
        <div data-show-when="solve:B" hidden>
            <x-calc.select name="out_B" label="Show the result in" :options="['t' => 'T', 'mt' => 'mT', 'ut' => 'µT', 'nt' => 'nT', 'gauss' => 'G', 'mgauss' => 'mG']" selected="t" />
        </div>
    </div>

    <x-calc.result label="Hall coefficient (m³/C)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'RH', 'RH' => -7.37e-11, 'VH' => -0.737, 'VH-unit' => 'uv', 'out_VH' => 'uv', 't' => 1, 't-unit' => 'mm', 'out_t' => 'mm', 'I' => 10, 'I-unit' => 'a', 'out_I' => 'a', 'B' => 1, 'B-unit' => 't', 'out_B' => 't'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'n' => ['label' => 'Carrier density 1 ÷ |R_H| e'],
            'type' => ['label' => 'Majority carriers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>R_H = V_H t ÷ (I B)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
