<x-calc.page
    title="Pool Shock Calculator - SolveKit"
    description="Free pool shock calculator: how much cal-hypo, dichlor, trichlor, lithium hypochlorite or liquid chlorine raises a pool's chlorine by a target ppm."
    lede="Work out how much shock to add to raise chlorine."
    about="Chlorine needed = water volume × ppm rise (1 ppm = 1 mg per liter). Product = chlorine ÷ its available chlorine: calcium hypochlorite 65% or 73%, sodium dichlor 56%, trichlor 90%, lithium hypochlorite 35%. Liquid chlorine is sold by trade percent (12.5% = 125 g of chlorine per liter). A typical shock raises free chlorine by about 10 ppm; follow the product label."
    :calc="['engine' => 'ev-home', 'tool' => 'pool_shock', 'fields' => ['volume', 'rise', 'product', 'liquid'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all()]]"
    :how-to="[
        ['name' => 'Enter the volume and rise', 'text' => 'From your test results.'],
        ['name' => 'Choose the product', 'text' => 'And its strength for liquid.'],
    ]"
    :faqs="[
        ['question' => 'How much shock for 15,000 gallons?', 'answer' => 'About 1.9 lb of 65% cal-hypo to raise chlorine 10 ppm.'],
        ['question' => 'How much liquid chlorine?', 'answer' => 'About 1.2 gallons of 12.5% for 10 ppm in 15,000 gallons.'],
        ['question' => 'When can I swim?', 'answer' => 'When free chlorine is back below about 5 ppm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="volume" label="Pool volume" value="15000" min="0" placeholder="Pool volume">
            <label for="calc-volume-unit" class="sr-only">Pool volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rise" label="Raise chlorine by" value="10" min="0.5" step="0.5" suffix="ppm" />
    </div>

    <x-calc.select name="product" label="Product" :options="['cal_hypo_65' => 'Calcium hypochlorite 65%', 'cal_hypo_73' => 'Calcium hypochlorite 73%', 'dichlor' => 'Sodium dichlor 56%', 'trichlor' => 'Trichlor 90%', 'lithium' => 'Lithium hypochlorite 35%', 'liquid' => 'Liquid chlorine (sodium hypochlorite)']" selected="cal_hypo_65" />

    <div data-show-when="product:liquid" hidden>
        <x-calc.field name="liquid" label="Strength" value="12.5" min="1" max="15" step="0.5" suffix="% trade" />
    </div>

    <x-calc.result label="Shock to add" />

    <x-calc.options :examples="[
        '15,000 gal, cal-hypo' => ['volume' => 15000, 'volume-unit' => 'gal_us', 'rise' => 10, 'product' => 'cal_hypo_65', 'liquid' => ''],
        'Liquid 12.5%' => ['volume' => 15000, 'volume-unit' => 'gal_us', 'rise' => 10, 'product' => 'liquid', 'liquid' => 12.5],
        '40 m³, dichlor' => ['volume' => 40, 'volume-unit' => 'm3', 'rise' => 5, 'product' => 'dichlor', 'liquid' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'metric' => ['label' => 'Metric'],
            'floz' => ['label' => 'Other units'],
            'note' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>chlorine g = liters × ppm ÷ 1,000</li>
            <li>product = chlorine ÷ available %</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
