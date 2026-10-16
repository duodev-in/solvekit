<x-calc.page
    title="Potting Soil Calculator - SolveKit"
    description="Free potting soil calculator: how much potting mix you need for your pots, in liters, quarts and bags."
    lede="Work out how much potting mix fills your pots."
    about="Each pot is treated as a cylinder of its rim diameter and depth, then reduced to 85% because most pots taper towards the base."
    :calc="['engine' => 'garden', 'tool' => 'potting_soil', 'fields' => ['pots', 'diameter', 'depth'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Count the pots', 'text' => 'Use pots of the same size, or run the calculator once per size.'],
        ['name' => 'Measure a pot', 'text' => 'The inside diameter at the rim and the depth.'],
    ]"
    :faqs="[
        ['question' => 'How much soil does a 12-inch pot need?', 'answer' => 'About 13 to 15 liters for a typical 12 × 10 in pot.'],
        ['question' => 'Why is the result less than a full cylinder?', 'answer' => 'Most pots taper, so they hold about 85% of a straight cylinder.'],
        ['question' => 'Can I reuse potting soil?', 'answer' => 'Yes, refreshed with about a third new compost, unless plants in it were diseased.'],
    ]"
>
    <x-calc.field name="pots" label="Number of pots" value="6" min="1" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diameter" label="Rim diameter" value="12" min="0" placeholder="Rim diameter">
            <label for="calc-diameter-unit" class="sr-only">Rim diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Depth" value="10" min="0" placeholder="Depth">
            <label for="calc-depth-unit" class="sr-only">Depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Potting mix needed" />

    <x-calc.options :examples="[
        '6 pots 12 in' => ['pots' => 6, 'diameter' => 12, 'depth' => 10],
        '20 seed pots 4 in' => ['pots' => 20, 'diameter' => 4, 'depth' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same amount in" :grow="true" :rows="[
            'quarts' => ['label' => 'US quarts', 'unit' => 'qt'],
            'ft3' => ['label' => 'Cubic feet', 'unit' => 'ft³'],
            'bags8' => ['label' => '8-quart bags'],
            'bags1' => ['label' => '1 ft³ bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = pots × π × (d ÷ 2)² × depth × 0.85</li>
            <li>1 US qt = 0.946 L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
