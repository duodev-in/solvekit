<x-calc.page
    title="Vegetable Yield Calculator - SolveKit"
    description="Free vegetable yield calculator: expected harvest for your rows, with a comparison across common crops."
    lede="Estimate how much a row of vegetables will produce."
    about="Yield uses typical home-garden figures in pounds per 10 feet of row from extension-service guides. Real harvests vary a lot with variety, weather, soil and care, so treat the result as a rough guide."
    :calc="['engine' => 'garden', 'tool' => 'vegetable_yield', 'fields' => ['crop', 'length'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => config('biology_data.vegetables')]"
    :how-to="[
        ['name' => 'Pick the crop', 'text' => 'Typical yield fills in.'],
        ['name' => 'Enter the row length', 'text' => 'Add all rows of that crop together.'],
    ]"
    :faqs="[
        ['question' => 'How much does a tomato plant produce?', 'answer' => 'Often 10 to 15 lb per plant in a good season.'],
        ['question' => 'Why is my yield lower?', 'answer' => 'Shade, poor soil, pests and short seasons all reduce yields.'],
        ['question' => 'How can I increase yield?', 'answer' => 'Full sun, compost-rich soil, regular watering and timely harvesting help most crops.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="crop" label="Crop" :options="collect(config('biology_data.vegetables'))->map(fn ($item) => $item['name'])->all()" selected="tomato" />
        <x-calc.field name="length" label="Total row length" value="30" min="0" placeholder="Total row length">
            <label for="calc-length-unit" class="sr-only">Total row length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Expected harvest" />

    <x-calc.options :examples="[
        'Tomatoes 30 ft' => ['crop' => 'tomato', 'length' => 30],
        'Potatoes 50 ft' => ['crop' => 'potato', 'length' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same harvest in" :rows="[
            'kg' => ['label' => 'Kilograms', 'unit' => 'kg'],
        ]" />
        <x-calc.quick-ref heading="Other crops in the same row length" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>harvest = row length ÷ 10 ft × yield per 10 ft</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
