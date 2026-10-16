<x-calc.page
    title="Lawn Mowing Cost Calculator - SolveKit"
    description="Free lawn mowing cost calculator: season, month and per-mow cost of lawn mowing."
    lede="Work out what lawn mowing costs per season."
    about="Season cost is the price per mow times mows per month times months in the mowing season. Prices vary widely by region and lawn size; enter the quote you have."
    :calc="['engine' => 'garden', 'tool' => 'mowing_cost', 'fields' => ['price', 'per_month', 'months', 'area'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the price per mow', 'text' => 'From a quote or what you pay now.'],
        ['name' => 'Enter how often', 'text' => 'Weekly mowing is about 4 per month in peak season.'],
    ]"
    :faqs="[
        ['question' => 'How often should a lawn be mowed?', 'answer' => 'Weekly in the growing season, removing no more than a third of the blade height.'],
        ['question' => 'Is weekly or biweekly cheaper?', 'answer' => 'Biweekly has fewer visits but each can cost more if the grass is long.'],
        ['question' => 'What affects mowing prices?', 'answer' => 'Lawn size, slope, obstacles, edging and how far the crew travels.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Price per mow" value="45" min="0" step="0.01" suffix="$" />
        <x-calc.field name="per_month" label="Mows per month" value="4" min="0" />
        <x-calc.field name="months" label="Months in season" value="7" min="0" />
    </div>

    <x-calc.field name="area" label="Lawn area (optional)" value="5000" min="0" placeholder="Lawn area (optional)">
        <label for="calc-area-unit" class="sr-only">Lawn area (optional) unit</label>
        <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Cost per season" />

    <x-calc.options :examples="[
        'Weekly $40' => ['price' => 40, 'per_month' => 4, 'months' => 7],
        'Biweekly $55' => ['price' => 55, 'per_month' => 2, 'months' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_month' => ['label' => 'Per month'],
            'mows' => ['label' => 'Mows per season'],
            'per_1000' => ['label' => 'Per 1,000 ft²'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>season = price × mows per month × months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
