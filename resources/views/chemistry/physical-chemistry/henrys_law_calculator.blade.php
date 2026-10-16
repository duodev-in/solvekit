<x-calc.page
    title="Henry's Law Calculator - SolveKit"
    description="Free Henry's law calculator: dissolved gas concentration in water from partial pressure and temperature, for O₂, N₂, CO₂ and other gases."
    lede="Work out how much gas dissolves in water."
    about="Henry's law c = H p links dissolved concentration to the gas's partial pressure. Constants at 25 °C and their temperature dependence are from Sander's (2015) compilation, with H(T) = H° exp(C (1/T − 1/298.15)); gases dissolve less in warmer water."
    :calc="['engine' => 'chem-physical', 'tool' => 'henry', 'fields' => ['gas', 'temperature', 'direction', 'pressure', 'concentration'], 'unitFields' => ['pressure' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all()], 'data' => ['henry' => config('chemistry_data.henry'), 'elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the gas', 'text' => 'And the water temperature.'],
        ['name' => 'Enter the partial pressure', 'text' => 'Or the dissolved concentration.'],
    ]"
    :faqs="[
        ['question' => 'How much oxygen dissolves in water?', 'answer' => 'About 8.8 mg/L from air at 25 °C.'],
        ['question' => 'Why do fish struggle in warm water?', 'answer' => 'Oxygen solubility falls as water warms.'],
        ['question' => 'Why does soda fizz when opened?', 'answer' => 'The CO₂ partial pressure drops, so less stays dissolved.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="collect(config('chemistry_data.henry'))->map(fn ($g) => $g['name'])->all()" selected="o2" />
        <x-calc.field name="temperature" label="Water temperature" value="25" suffix="°C" />
    </div>

    <x-calc.segmented name="direction" legend="Find" :options="['concentration' => 'Dissolved concentration', 'pressure' => 'Partial pressure']" selected="concentration" />

    <div data-show-when="direction:concentration">
        <x-calc.field name="pressure" label="Partial pressure" value="21.22" min="0" placeholder="Partial pressure">
            <label for="calc-pressure-unit" class="sr-only">Partial pressure unit</label>
            <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="direction:pressure" hidden>
        <x-calc.field name="concentration" label="Dissolved concentration" value="0.00026" min="0" suffix="mol/L" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Oxygen from air, 25 °C' => ['gas' => 'o2', 'temperature' => 25, 'direction' => 'concentration', 'pressure' => 21.22, 'pressure-unit' => 'kpa'],
        'Oxygen from air, 5 °C' => ['gas' => 'o2', 'temperature' => 5, 'direction' => 'concentration', 'pressure' => 21.22, 'pressure-unit' => 'kpa'],
        'CO₂ in soda (2.5 atm)' => ['gas' => 'co2', 'temperature' => 5, 'direction' => 'concentration', 'pressure' => 2.5, 'pressure-unit' => 'atm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mg' => ['label' => 'In mg/L'],
            'constant' => ['label' => 'Henry constant'],
            'pressure' => ['label' => 'Partial pressure'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>c = H × p</li>
            <li>H(T) = H° exp(C (1/T − 1/298.15))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
