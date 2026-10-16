<x-calc.page
    title="Boiling Point at Altitude Calculator - SolveKit"
    description="Free boiling point at altitude calculator: the temperature water boils at for any elevation or air pressure."
    lede="Find the temperature water boils at for your altitude."
    about="Air pressure falls with altitude, so water boils cooler. Pressure comes from the ICAO standard atmosphere and the boiling point from the IAPWS saturation equation. Weather changes the actual pressure, so the real boiling point can differ by about ±0.5 °C; enter a barometer reading for an exact value."
    :calc="['engine' => 'chem-thermo', 'tool' => 'boiling_altitude', 'fields' => ['mode', 'altitude', 'pressure'], 'unitFields' => ['altitude' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all()]]"
    :how-to="[
        ['name' => 'Enter the altitude', 'text' => 'Or a barometer reading.'],
    ]"
    :faqs="[
        ['question' => 'At what temperature does water boil at 1,500 m?', 'answer' => 'About 95 °C.'],
        ['question' => 'Why do recipes change at altitude?', 'answer' => 'Water boils cooler, so foods cook more slowly.'],
        ['question' => 'Does weather matter?', 'answer' => 'Yes: low pressure systems lower the boiling point slightly.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['altitude' => 'Altitude', 'pressure' => 'Air pressure']" selected="altitude" />

    <div data-show-when="mode:altitude">
        <x-calc.field name="altitude" label="Altitude" value="1500" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:pressure" hidden>
        <x-calc.field name="pressure" label="Air pressure" value="84.5" min="0" placeholder="Air pressure">
            <label for="calc-pressure-unit" class="sr-only">Air pressure unit</label>
            <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Boiling point of water" />

    <x-calc.options :examples="[
        'Denver (1,609 m)' => ['mode' => 'altitude', 'altitude' => 1609, 'altitude-unit' => 'm'],
        'La Paz (3,640 m)' => ['mode' => 'altitude', 'altitude' => 3640, 'altitude-unit' => 'm'],
        'Everest base camp (17,600 ft)' => ['mode' => 'altitude', 'altitude' => 17600, 'altitude-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fahrenheit' => ['label' => 'In Fahrenheit'],
            'pressure' => ['label' => 'Air pressure'],
            'drop' => ['label' => 'Compared with sea level'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = 101,325 × (1 − 2.25577 × 10⁻⁵ h)^5.25588</li>
            <li>boiling point: IAPWS saturation equation</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
