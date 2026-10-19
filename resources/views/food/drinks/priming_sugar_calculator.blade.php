<x-calc.page
    title="Priming Sugar Calculator - SolveKit"
    description="Free priming sugar calculator: corn sugar or table sugar to bottle-condition beer to a target carbonation, allowing for the CO₂ already dissolved at its fermentation temperature."
    lede="Find the priming sugar for bottling beer."
    about="Beer already holds some CO₂ after fermentation, more when it was cool: residual volumes = 3.0378 − 0.050062 T + 0.00026555 T² (T is the highest temperature in °F after fermentation). Priming sugar makes up the rest: 15.2 g of corn sugar per US gallon per volume (Tinseth); table sugar is about 9% stronger. Typical targets: British ales 1.5–2.0 volumes, American ales 2.2–2.7, lagers 2.4–2.8, wheat beers 3–4."
    :calc="['engine' => 'fd-drinks', 'tool' => 'priming', 'fields' => ['volume', 'co2', 'temp', 'sugar'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all(), 'temp' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Enter the beer volume and target carbonation', 'text' => ''],
        ['name' => 'Enter the temperature and sugar', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much corn sugar for 5 gallons at 2.4 volumes?', 'answer' => '117 g (4.12 oz).'],
        ['question' => 'And with table sugar?', 'answer' => '106 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="volume" label="Beer volume" value="5" min="0" placeholder="Beer volume">
            <label for="calc-volume-unit" class="sr-only">Beer volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="co2" label="Target CO₂" value="2.4" min="0.5" max="5" step="0.1" suffix="volumes" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temp" label="Highest temperature after fermentation" value="68" placeholder="Highest temperature after fermentation">
            <label for="calc-temp-unit" class="sr-only">Highest temperature after fermentation unit</label>
            <select id="calc-temp-unit" name="temp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="sugar" label="Sugar" :options="['corn' => 'Corn sugar (dextrose)', 'table' => 'Table sugar (sucrose)']" selected="corn" />
    </div>

    <x-calc.result label="Corn sugar (dextrose)" />

    <x-calc.options :decimals="false" :examples="[
        'Ale 5 gal' => ['volume' => 5, 'volume-unit' => 'gal_us', 'co2' => 2.4, 'temp' => 68, 'temp-unit' => 'f', 'sugar' => 'corn'],
        'Table sugar' => ['volume' => 5, 'volume-unit' => 'gal_us', 'co2' => 2.4, 'temp' => 68, 'temp-unit' => 'f', 'sugar' => 'table'],
        'Wheat beer 20 L' => ['volume' => 20, 'volume-unit' => 'l', 'co2' => 3.3, 'temp' => 20, 'temp-unit' => 'c', 'sugar' => 'corn'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ounces' => ['label' => 'Ounces'],
            'cups' => ['label' => 'Volume'],
            'residual' => ['label' => 'CO₂ already in the beer'],
            'perBottle' => ['label' => 'Per bottle'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>residual = 3.0378 − 0.050062 T + 0.00026555 T²</li>
            <li>corn sugar g = 15.195 × gal × (target − residual)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
