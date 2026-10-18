<x-calc.page
    title="Fence Stain Calculator - SolveKit"
    description="Free fence stain calculator: gallons of fence stain for one or both sides, by coats and label coverage."
    lede="Work out how much stain a fence needs."
    about="Stain = length × height × sides × coats ÷ coverage. Rough-sawn fence boards soak up more than smooth wood; most labels give 150–300 ft² per gallon on rough wood. Sprayers use more than brushes."
    :calc="['engine' => 'con-finish', 'tool' => 'stain', 'fields' => ['fence_length', 'fence_height', 'sides', 'coverage', 'coats', 'price'], 'unitFields' => ['fence_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'fence_height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the fence size', 'text' => 'And one or both sides.'],
        ['name' => 'Enter the coverage', 'text' => 'From the label, for rough wood if yours is rough-sawn.'],
    ]"
    :faqs="[
        ['question' => 'How much stain for 150 ft of 6 ft fence?', 'answer' => '9 gal for both sides, one coat at 200 ft²/gal.'],
        ['question' => 'Do I count the posts and rails?', 'answer' => 'Their extra area is small; a few percent more covers it.'],
        ['question' => 'Brush or spray?', 'answer' => 'Spraying is faster but uses more stain; back-brush for even coverage.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fence_length" label="Fence length" value="150" min="0" placeholder="Fence length">
            <label for="calc-fence_length-unit" class="sr-only">Fence length unit</label>
            <select id="calc-fence_length-unit" name="fence_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fence_height" label="Fence height" value="6" min="0" placeholder="Fence height">
            <label for="calc-fence_height-unit" class="sr-only">Fence height unit</label>
            <select id="calc-fence_height-unit" name="fence_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="sides" label="Sides" :options="['1' => 'One side', '2' => 'Both sides']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coverage" label="Coverage from the label" value="200" min="1" suffix="ft²/gal" />
        <x-calc.field name="coats" label="Coats" value="1" min="1" step="1" />
        <x-calc.field name="price" label="Price per gallon (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Stain needed" />

    <x-calc.options :examples="[
        '150 ft × 6 ft, both sides' => ['fence_length' => 150, 'fence_length-unit' => 'ft', 'fence_height' => 6, 'fence_height-unit' => 'ft', 'sides' => '2', 'coverage' => 200, 'coats' => 1],
        '30 m × 1.8 m, one side' => ['fence_length' => 30, 'fence_length-unit' => 'm', 'fence_height' => 1.8, 'fence_height-unit' => 'm', 'sides' => '1', 'coverage' => 250, 'coats' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters'],
            'buy' => ['label' => 'To buy'],
            'area' => ['label' => 'Surfaces'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gallons = length × height × sides × coats ÷ coverage</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
