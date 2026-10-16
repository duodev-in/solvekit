<x-calc.page
    title="Ideal Gas Law Calculator - SolveKit"
    description="Free ideal gas law calculator: solve PV = nRT for pressure, volume, moles or temperature in any units."
    lede="Solve PV = nRT for any one variable."
    about="The ideal gas law PV = nRT links pressure, volume, amount and absolute temperature, with R = 8.314 462 618 J/(mol·K). Real gases follow it closely at low pressure and high temperature; use the Van der Waals calculator when they do not."
    :calc="['engine' => 'chem-physical', 'tool' => 'ideal_gas', 'fields' => ['solve', 'pressure', 'volume', 'moles', 'temperature'], 'unitFields' => ['pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'volume' => collect(config('units.volume'))->only(['ml', 'l'])->all(), 'temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'P, V, n or T.'],
        ['name' => 'Enter the other three', 'text' => 'In any units.'],
    ]"
    :faqs="[
        ['question' => 'What is R?', 'answer' => '8.314 462 618 J/(mol·K), or 0.082 057 L·atm/(mol·K).'],
        ['question' => 'Why must temperature be absolute?', 'answer' => 'Gas volume is proportional to kelvin, not Celsius.'],
        ['question' => 'When does the ideal gas law fail?', 'answer' => 'At high pressure or low temperature, where molecules attract and take up space.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['p' => 'Pressure P', 'v' => 'Volume V', 'n' => 'Moles n', 't' => 'Temperature T']" selected="v" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v,n,t">
            <x-calc.field name="pressure" label="Pressure" value="100" min="0" placeholder="Pressure">
                <label for="calc-pressure-unit" class="sr-only">Pressure unit</label>
                <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:p,n,t" hidden>
            <x-calc.field name="volume" label="Volume" value="22.711" min="0" placeholder="Volume">
                <label for="calc-volume-unit" class="sr-only">Volume unit</label>
                <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:p,v,t">
            <x-calc.field name="moles" label="Moles" value="1" min="0" suffix="mol" />
        </div>
        <div data-show-when="solve:p,v,n">
            <x-calc.field name="temperature" label="Temperature" value="0" placeholder="Temperature">
                <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
                <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '1 mol at IUPAC STP' => ['solve' => 'v', 'pressure' => 100, 'pressure-unit' => 'kpa', 'moles' => 1, 'temperature' => 0, 'temperature-unit' => 'c'],
        'Pressure in a 10 L tank' => ['solve' => 'p', 'volume' => 10, 'volume-unit' => 'l', 'moles' => 2, 'temperature' => 25, 'temperature-unit' => 'c'],
        'Moles in a balloon' => ['solve' => 'n', 'pressure' => 1, 'pressure-unit' => 'atm', 'volume' => 15, 'volume-unit' => 'l', 'temperature' => 20, 'temperature-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'atm' => ['label' => 'Pressure in atm'],
            'molar' => ['label' => 'Molar volume'],
            'kelvin' => ['label' => 'Temperature'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PV = nRT</li>
            <li>R = 8.314 462 618 J/(mol·K)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
