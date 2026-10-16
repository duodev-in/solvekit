<x-calc.page
    title="Vegetable Seed Calculator - SolveKit"
    description="Free vegetable seed calculator: seeds to sow for your rows, with spacing and germination rate."
    lede="Work out how many vegetable seeds to sow for your rows."
    about="Plants per row are the row length divided by the in-row spacing. Several seeds are sown per spot for small or slow seeds, then thinned to one, and the total is divided by the germination rate so enough come up."
    :calc="['engine' => 'garden', 'tool' => 'vegetable_seed', 'fields' => ['crop', 'length', 'rows', 'germination'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => config('biology_data.vegetables')]"
    :how-to="[
        ['name' => 'Pick the crop', 'text' => 'Spacing fills in for that crop.'],
        ['name' => 'Enter your rows', 'text' => 'Length and number of rows.'],
        ['name' => 'Enter germination', 'text' => 'From the seed packet, or use 80%.'],
    ]"
    :faqs="[
        ['question' => 'How many carrot seeds per foot?', 'answer' => 'About 15 to 20 sown, thinned to about 6 plants.'],
        ['question' => 'Why divide by germination rate?', 'answer' => 'Not every seed sprouts; at 80% you sow 25% more seed.'],
        ['question' => 'Do old seeds still grow?', 'answer' => 'Many do, at a lower rate. Test a few on a damp paper towel first.'],
    ]"
>
    <x-calc.select name="crop" label="Crop" :options="collect(config('biology_data.vegetables'))->map(fn ($item) => $item['name'])->all()" selected="carrot" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Row length" value="10" min="0" placeholder="Row length">
            <label for="calc-length-unit" class="sr-only">Row length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rows" label="Rows" value="2" min="1" step="1" />
        <x-calc.field name="germination" label="Germination" value="80" min="1" max="100" suffix="%" />
    </div>

    <x-calc.result label="Seeds to sow" />

    <x-calc.options :examples="[
        'Carrots 2 × 10 ft' => ['crop' => 'carrot', 'length' => 10, 'rows' => 2, 'germination' => 80],
        'Beans 3 × 15 ft' => ['crop' => 'bean_bush', 'length' => 15, 'rows' => 3, 'germination' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'plants' => ['label' => 'Plants after thinning'],
            'spacing' => ['label' => 'Spacing'],
            'per_spot' => ['label' => 'Seeds per spot'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>plants = row length ÷ spacing × rows</li>
            <li>seeds = plants × seeds per spot ÷ germination</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
