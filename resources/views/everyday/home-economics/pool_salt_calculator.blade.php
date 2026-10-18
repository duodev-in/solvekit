<x-calc.page
    title="Pool Salt Calculator - SolveKit"
    description="Free pool salt calculator: pounds or kilograms of salt to raise a saltwater pool to its target ppm, and bags to buy."
    lede="Work out how much salt to add to a saltwater pool."
    about="Salt to add = water volume × (target − current) ppm, since 1 ppm is 1 mg per liter (about 8.34 lb per million US gallons). Most salt chlorinators need about 3,000–3,500 ppm; check yours. Use the Pool Calculator in the Construction section to find your pool's volume."
    :calc="['engine' => 'ev-home', 'tool' => 'pool_salt', 'fields' => ['volume', 'current', 'target', 'bag'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all(), 'bag' => collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the pool volume', 'text' => 'In gallons or liters.'],
        ['name' => 'Enter current and target salt', 'text' => 'From a test and your chlorinator manual.'],
    ]"
    :faqs="[
        ['question' => 'How much salt for a 15,000-gallon pool from 0?', 'answer' => 'About 400 lb for 3,200 ppm.'],
        ['question' => 'How much salt raises 10,000 gallons by 1,000 ppm?', 'answer' => 'About 83 lb.'],
        ['question' => 'Can I lower salt?', 'answer' => 'Only by draining and adding fresh water.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="volume" label="Pool volume" value="15000" min="0" placeholder="Pool volume">
            <label for="calc-volume-unit" class="sr-only">Pool volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="current" label="Current salt" value="1500" min="0" step="50" suffix="ppm" />
        <x-calc.field name="target" label="Target salt" value="3200" min="0" step="50" suffix="ppm" />
    </div>

    <x-calc.field name="bag" label="Bag size" value="40" min="0" placeholder="Bag size">
        <label for="calc-bag-unit" class="sr-only">Bag size unit</label>
        <select id="calc-bag-unit" name="bag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Salt to add" />

    <x-calc.options :examples="[
        '15,000 gal, 1,500 → 3,200' => ['volume' => 15000, 'volume-unit' => 'gal_us', 'current' => 1500, 'target' => 3200, 'bag' => 40, 'bag-unit' => 'lb'],
        'New pool from zero' => ['volume' => 15000, 'volume-unit' => 'gal_us', 'current' => 0, 'target' => 3200, 'bag' => 40, 'bag-unit' => 'lb'],
        '50 m³, metric' => ['volume' => 50, 'volume-unit' => 'm3', 'current' => 2000, 'target' => 3500, 'bag' => 25, 'bag-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'In kg'],
            'bags' => ['label' => 'Bags'],
            'note' => ['label' => 'How to add'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kg = liters × Δppm ÷ 1,000,000</li>
            <li>lb ≈ US gal × Δppm × 8.34 ÷ 1,000,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
