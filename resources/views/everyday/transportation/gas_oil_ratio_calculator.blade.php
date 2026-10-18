<x-calc.page
    title="Gas Oil Ratio Calculator - SolveKit"
    description="Free gas oil ratio calculator: how much two-stroke oil to mix with gas for 50:1, 40:1, 32:1 and other ratios, in mL and fl oz."
    lede="Work out how much 2-stroke oil to add to your gas."
    about="Oil = gas ÷ ratio: for 50:1, each liter of gas takes 20 mL of oil, and each US gallon 2.56 fl oz. Use the ratio in your engine's manual; too little oil can seize the engine, too much makes smoke and fouls the plug."
    :calc="['engine' => 'ev-transport', 'tool' => 'gas_oil', 'fields' => ['ratio', 'fuel'], 'unitFields' => ['fuel' => collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk'])->all()]]"
    :how-to="[
        ['name' => 'Enter the ratio', 'text' => 'From the engine manual.'],
        ['name' => 'Enter the gas', 'text' => 'In gallons or liters.'],
    ]"
    :faqs="[
        ['question' => 'How much oil for 1 gallon at 50:1?', 'answer' => '2.56 US fl oz (76 mL).'],
        ['question' => 'How much oil for 5 liters at 40:1?', 'answer' => '125 mL.'],
        ['question' => 'Is 50:1 the same as 2%?', 'answer' => 'Yes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ratio" label="Ratio (gas : 1 oil)" value="50" min="1" step="1" suffix=":1" />
        <x-calc.field name="fuel" label="Amount of gas" value="1" min="0" placeholder="Amount of gas">
            <label for="calc-fuel-unit" class="sr-only">Amount of gas unit</label>
            <select id="calc-fuel-unit" name="fuel-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Oil to add" />

    <x-calc.options :examples="[
        '1 gal at 50:1' => ['ratio' => 50, 'fuel' => 1, 'fuel-unit' => 'gal_us'],
        '5 L at 40:1' => ['ratio' => 40, 'fuel' => 5, 'fuel-unit' => 'l'],
        '2.5 gal at 32:1' => ['ratio' => 32, 'fuel' => 2.5, 'fuel-unit' => 'gal_us'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'floz' => ['label' => 'In fl oz'],
            'mix' => ['label' => 'Total mix'],
            'percent' => ['label' => 'Oil share'],
        ]" />
        <x-calc.quick-ref heading="Common ratios" name="ratios" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>oil = gas ÷ ratio</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
