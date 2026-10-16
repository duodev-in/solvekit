<x-calc.page
    title="Soil Calculator - SolveKit"
    description="Free soil calculator: work out how much soil you need for a bed or area, in cubic yards, cubic feet, liters and bags."
    lede="Work out how much topsoil you need, in cubic yards, bags and tons."
    about="Soil volume is the area times the depth. Weight uses a typical topsoil density of about 1.2 tonnes per cubic meter; moist or clay soils are heavier."
    :calc="['engine' => 'garden', 'tool' => 'soil', 'fields' => ['area', 'depth', 'bag', 'price'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the area', 'text' => 'Length × width of the bed, in any unit.'],
        ['name' => 'Choose the depth', 'text' => 'How thick a layer of soil you want.'],
        ['name' => 'Pick a bag size', 'text' => 'Optionally add a price per bag for the cost.'],
    ]"
    :faqs="[
        ['question' => 'How much does a cubic yard of topsoil weigh?', 'answer' => 'Roughly 1 to 1.4 US tons depending on moisture and type.'],
        ['question' => 'How deep should topsoil be for a lawn?', 'answer' => 'About 4 to 6 inches.'],
        ['question' => 'How do I measure an irregular area?', 'answer' => 'Split it into rectangles, add their areas, and enter the total.'],
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

    <x-calc.result label="Soil needed" />

    <x-calc.options :examples="[
        'New lawn 6 in' => ['area' => 1000, 'area-unit' => 'ft2', 'depth' => 6],
        'Bed top-up 2 in' => ['area' => 80, 'area-unit' => 'ft2', 'depth' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same amount in" :grow="true" :rows="[
            'ft3' => ['label' => 'Cubic feet', 'unit' => 'ft³'],
            'm3' => ['label' => 'Cubic meters', 'unit' => 'm³'],
            'liters' => ['label' => 'Liters', 'unit' => 'L'],
            'bags' => ['label' => 'Bags'],
            'cost' => ['label' => 'Cost'],
            'tons' => ['label' => 'Weight'],
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
