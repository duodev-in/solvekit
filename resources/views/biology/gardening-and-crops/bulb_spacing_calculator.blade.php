<x-calc.page
    title="Bulb Spacing Calculator - SolveKit"
    description="Free bulb spacing calculator: how many tulip, daffodil, crocus and other bulbs fill a bed, with planting depth."
    lede="Work out how many bulbs fill a bed and how deep to plant them."
    about="Bulbs are planted on a square grid at the typical spacing for their type. Depth is about two to three times the bulb's height. Figures are typical; follow the packet for specific varieties."
    :calc="['engine' => 'garden', 'tool' => 'bulb_spacing', 'fields' => ['area', 'bulb'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => config('biology_data.bulbs')]"
    :how-to="[
        ['name' => 'Enter the bed area', 'text' => 'The area to fill with bulbs.'],
        ['name' => 'Pick the bulb', 'text' => 'Spacing and depth fill in for that type.'],
    ]"
    :faqs="[
        ['question' => 'How far apart should tulips be planted?', 'answer' => 'About 4 to 6 inches apart and 6 to 8 inches deep.'],
        ['question' => 'Can bulbs be planted closer?', 'answer' => 'For a dense display, yes, especially in pots; they will need dividing sooner.'],
        ['question' => 'When should spring bulbs go in?', 'answer' => 'In autumn, a few weeks before the ground freezes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Bed area" value="20" min="0" placeholder="Bed area">
            <label for="calc-area-unit" class="sr-only">Bed area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="bulb" label="Bulb" :options="collect(config('biology_data.bulbs'))->map(fn ($item) => $item['name'])->all()" selected="tulip" />
    </div>

    <x-calc.result label="Bulbs needed" />

    <x-calc.options :examples="[
        'Tulip bed 20 ft²' => ['area' => 20, 'area-unit' => 'ft2', 'bulb' => 'tulip'],
        'Crocus lawn patch 10 ft²' => ['area' => 10, 'area-unit' => 'ft2', 'bulb' => 'crocus'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'spacing' => ['label' => 'Spacing'],
            'depth' => ['label' => 'Planting depth'],
            'per_ft2' => ['label' => 'Bulbs per ft²'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bulbs = area ÷ spacing²</li>
            <li>depth ≈ 2 to 3 × bulb height</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
