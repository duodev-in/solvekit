<x-calc.page
    title="Vapor Pressure of Water Calculator - SolveKit"
    description="Free vapor pressure of water calculator: saturation vapor pressure over liquid water and ice from −100 to 374 °C with the IAPWS equations."
    lede="Find the saturation vapor pressure of water at any temperature."
    about="Above 0.01 °C this uses the IAPWS saturation equation (Wagner and Pruss), the international standard. Below it, the vapor pressure over ice uses the IAPWS 2011 sublimation equation, with the value over supercooled water shown for comparison."
    :calc="['engine' => 'chem-thermo', 'tool' => 'water_vapor', 'fields' => ['temperature'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter the temperature', 'text' => 'Any unit; below 0 °C gives the value over ice.'],
    ]"
    :faqs="[
        ['question' => 'What is the vapor pressure of water at 100 °C?', 'answer' => '101.42 kPa, just above 1 atm.'],
        ['question' => 'Why is it lower over ice?', 'answer' => 'Ice holds its molecules more tightly than supercooled water at the same temperature.'],
        ['question' => 'Where is this used?', 'answer' => 'Humidity, dew point, drying and gas collection over water.'],
    ]"
>
    <x-calc.field name="temperature" label="Temperature" value="25" placeholder="Temperature">
        <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
        <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Saturation vapor pressure" />

    <x-calc.options :examples="[
        '25 °C' => ['temperature' => 25, 'temperature-unit' => 'c'],
        'Body temperature' => ['temperature' => 37, 'temperature-unit' => 'c'],
        '−10 °C over ice' => ['temperature' => -10, 'temperature-unit' => 'c'],
        '212 °F' => ['temperature' => 212, 'temperature-unit' => 'f'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kpa' => ['label' => 'In kPa'],
            'mmhg' => ['label' => 'In mmHg'],
            'atm' => ['label' => 'In atm'],
            'psi' => ['label' => 'In psi'],
            'hpa' => ['label' => 'In hPa'],
            'supercooled' => ['label' => 'Over supercooled water'],
        ]" />
        <x-calc.quick-ref heading="Over liquid water, 0 to 100 °C" name="table" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>IAPWS SR1-86: ln(p/pc) = (Tc/T)(a₁τ + a₂τ^1.5 + … + a₆τ^7.5)</li>
            <li>ice: IAPWS 2011 sublimation equation</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
