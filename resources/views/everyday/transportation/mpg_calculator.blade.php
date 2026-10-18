<x-calc.page
    title="MPG Calculator - SolveKit"
    description="Free MPG calculator: fuel economy in miles per gallon from distance and fuel used, with L/100 km, km/L, UK mpg and cost per mile."
    lede="Work out your car's real fuel economy."
    about="Fill the tank, reset the trip meter, drive, then fill up again: mpg = miles driven ÷ gallons to refill. L/100 km = 235.21 ÷ mpg (US); UK gallons are 20% larger, so UK mpg = US mpg × 1.201."
    :calc="['engine' => 'ev-transport', 'tool' => 'mpg', 'fields' => ['distance', 'fuel', 'price', 'price_unit'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all(), 'fuel' => collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk'])->all()]]"
    :how-to="[
        ['name' => 'Fill up and reset', 'text' => 'Then drive normally.'],
        ['name' => 'Enter miles and fuel', 'text' => 'From the trip meter and the pump.'],
    ]"
    :faqs="[
        ['question' => 'What is 312 miles on 11.2 gallons?', 'answer' => '27.9 mpg.'],
        ['question' => 'How do I convert mpg to L/100 km?', 'answer' => '235.21 ÷ mpg (US).'],
        ['question' => 'Why does my dashboard show more?', 'answer' => 'Trip computers often read a few percent high.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="distance" label="Distance driven" value="312" min="0" placeholder="Distance driven">
            <label for="calc-distance-unit" class="sr-only">Distance driven unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fuel" label="Fuel used" value="11.2" min="0" placeholder="Fuel used">
            <label for="calc-fuel-unit" class="sr-only">Fuel used unit</label>
            <select id="calc-fuel-unit" name="fuel-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Fuel price (optional)" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['gal' => 'per US gallon', 'l' => 'per liter', 'gal_uk' => 'per UK gallon']" selected="gal" />
    </div>

    <x-calc.result label="Fuel economy" />

    <x-calc.options :examples="[
        '312 mi on 11.2 gal' => ['distance' => 312, 'distance-unit' => 'mi', 'fuel' => 11.2, 'fuel-unit' => 'gal_us', 'price' => 3.5, 'price_unit' => 'gal'],
        '540 km on 38 L' => ['distance' => 540, 'distance-unit' => 'km', 'fuel' => 38, 'fuel-unit' => 'l', 'price' => 1.6, 'price_unit' => 'l'],
        'UK gallons' => ['distance' => 400, 'distance-unit' => 'mi', 'fuel' => 9.5, 'fuel-unit' => 'gal_uk', 'price' => '', 'price_unit' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'l100' => ['label' => 'L/100 km'],
            'kml' => ['label' => 'km/L'],
            'uk' => ['label' => 'UK mpg'],
            'cost' => ['label' => 'Cost per mile'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mpg = miles ÷ gallons</li>
            <li>L/100 km = 235.21 ÷ mpg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
