<x-calc.page
    title="Pine Straw Calculator - SolveKit"
    description="Free pine straw calculator: bales of pine straw needed for an area and depth."
    lede="Work out how many bales of pine straw cover your beds."
    about="A standard bale of pine straw covers about 50 ft² at 3 inches deep. Coverage scales with depth, so a thinner layer covers more per bale. Bale sizes vary by supplier."
    :calc="['engine' => 'garden', 'tool' => 'pine_straw', 'fields' => ['area', 'depth', 'price'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the area', 'text' => 'Add up all beds to be covered.'],
        ['name' => 'Choose the depth', 'text' => '2 to 3 inches is typical; it settles over time.'],
    ]"
    :faqs="[
        ['question' => 'How much does a bale of pine straw cover?', 'answer' => 'About 50 ft² at 3 inches, or about 75 ft² at 2 inches.'],
        ['question' => 'How long does pine straw last?', 'answer' => 'Usually 6 to 12 months before it needs topping up.'],
        ['question' => 'Does pine straw make soil acidic?', 'answer' => 'Only very slightly; the effect on soil pH is small.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Area" value="500" min="0" placeholder="Area">
            <label for="calc-area-unit" class="sr-only">Area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Depth" value="3" min="0" placeholder="Depth">
            <label for="calc-depth-unit" class="sr-only">Depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="price" label="Price per bale (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Pine straw needed" />

    <x-calc.options :examples="[
        'Bed 200 ft²' => ['area' => 200, 'area-unit' => 'ft2', 'depth' => 3],
        'Yard 1,500 ft²' => ['area' => 1500, 'area-unit' => 'ft2', 'depth' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'coverage' => ['label' => 'Coverage per bale'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coverage per bale = 50 ft² × 3 in ÷ depth</li>
            <li>bales = area ÷ coverage, rounded up</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
