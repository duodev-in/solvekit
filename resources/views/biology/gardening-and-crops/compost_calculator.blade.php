<x-calc.page
    title="Compost Calculator - SolveKit"
    description="Free compost calculator: work out how much compost you need for a bed or area, in cubic yards, cubic feet, liters and bags."
    lede="Work out how much compost to spread or mix into a bed."
    about="Compost volume is the area times the depth. A 1 to 2 inch top dressing is common for lawns and existing beds; 2 to 3 inches is typical when mixing into new beds."
    :calc="['engine' => 'garden', 'tool' => 'compost', 'fields' => ['area', 'depth', 'bag', 'price'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the area', 'text' => 'Length × width of the bed, in any unit.'],
        ['name' => 'Choose the depth', 'text' => 'How thick a layer of compost you want.'],
        ['name' => 'Pick a bag size', 'text' => 'Optionally add a price per bag for the cost.'],
    ]"
    :faqs="[
        ['question' => 'How much compost should I add to a garden bed?', 'answer' => 'About 2 to 3 inches mixed into the top 6 to 8 inches of soil for a new bed.'],
        ['question' => 'How much compost for a lawn?', 'answer' => 'A top dressing of about ¼ to ½ inch.'],
        ['question' => 'How many bags make a cubic yard?', 'answer' => '13.5 bags of 2 ft³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Area" value="200" min="0" placeholder="Area">
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

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="bag" legend="Bag size" :options="['1.5' => '1.5 ft³', '2' => '2 ft³', '3' => '3 ft³']" selected="2" />
        <x-calc.field name="price" label="Price per bag (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Compost needed" />

    <x-calc.options :examples="[
        'New bed 3 in' => ['area' => 60, 'area-unit' => 'ft2', 'depth' => 3],
        'Lawn ¼ in' => ['area' => 1000, 'area-unit' => 'ft2', 'depth' => 0.25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same amount in" :grow="true" :rows="[
            'ft3' => ['label' => 'Cubic feet', 'unit' => 'ft³'],
            'm3' => ['label' => 'Cubic meters', 'unit' => 'm³'],
            'liters' => ['label' => 'Liters', 'unit' => 'L'],
            'bags' => ['label' => 'Bags'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = area × depth</li>
            <li>1 yd³ = 27 ft³ = 764.55 L</li>
            <li>bags = volume ÷ bag size, rounded up</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
