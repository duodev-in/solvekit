<x-calc.page
    title="Solar Panel Wattage Calculator - SolveKit"
    description="Free solar panel wattage calculator: panel watts from its area and efficiency at standard test conditions, with daily and yearly energy from sun hours."
    lede="Work out a solar panel's wattage from its size and efficiency."
    about="A panel's rating is measured at standard test conditions: 1,000 W/m² of sunlight at 25 °C. Watts = area × 1,000 W/m² × efficiency. Daily energy = watts × peak sun hours, before inverter, wiring and temperature losses (often 10–20%)."
    :calc="['engine' => 'eco-energy', 'tool' => 'solar_wattage', 'fields' => ['input', 'length', 'width', 'area', 'efficiency', 'sun_hours'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the panel size', 'text' => 'From the datasheet.'],
        ['name' => 'Enter the efficiency', 'text' => 'From the datasheet.'],
    ]"
    :faqs="[
        ['question' => 'How many watts is a 1.7 × 1.1 m panel?', 'answer' => 'About 400 W at 21% efficiency.'],
        ['question' => 'What are standard test conditions?', 'answer' => '1,000 W/m² of light, 25 °C cell temperature, air mass 1.5.'],
        ['question' => 'Why is real output lower?', 'answer' => 'Heat, dirt, shading and inverter losses.'],
    ]"
>
    <x-calc.segmented name="input" legend="Panel" :options="['size' => 'Length × width', 'area' => 'Area']" selected="size" />

    <div data-show-when="input:size">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Length" value="1.72" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="1.13" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="input:area" hidden>
        <x-calc.field name="area" label="Area" value="1.94" min="0" placeholder="Area">
            <label for="calc-area-unit" class="sr-only">Area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="efficiency" label="Efficiency" value="21" min="1" max="50" step="0.1" suffix="%" />
        <x-calc.field name="sun_hours" label="Peak sun hours (optional)" value="4.5" min="0" step="0.1" />
    </div>

    <x-calc.result label="Panel rating (standard test conditions)" />

    <x-calc.options :examples="[
        'Residential 1.72 × 1.13 m, 21%' => ['input' => 'size', 'length' => 1.72, 'length-unit' => 'm', 'width' => 1.13, 'width-unit' => 'm', 'efficiency' => 21, 'sun_hours' => 4.5],
        'Large 2.28 × 1.13 m, 22.5%' => ['input' => 'size', 'length' => 2.28, 'length-unit' => 'm', 'width' => 1.13, 'width-unit' => 'm', 'efficiency' => 22.5, 'sun_hours' => 5.5],
        'Small 100 cm × 50 cm, 18%' => ['input' => 'size', 'length' => 100, 'length-unit' => 'cm', 'width' => 50, 'width-unit' => 'cm', 'efficiency' => 18, 'sun_hours' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'daily' => ['label' => 'Per day'],
            'year' => ['label' => 'Per year'],
            'per_area' => ['label' => 'Per area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>W = area × 1000 × efficiency</li>
            <li>kWh a day = W × sun hours ÷ 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
