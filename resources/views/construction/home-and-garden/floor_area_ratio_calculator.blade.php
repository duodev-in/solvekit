<x-calc.page
    title="Floor Area Ratio Calculator - SolveKit"
    description="Free floor area ratio calculator: FAR from gross floor area and lot area, or the floor area a FAR limit allows."
    lede="Work out a floor area ratio, or how much floor area a zoning FAR allows."
    about="Floor area ratio (FAR) = gross floor area of all floors ÷ lot area. A FAR of 0.5 on a 10,000 ft² lot allows 5,000 ft² of floor, whether on one floor or several. Zoning codes define which areas count (basements, garages and so on), so check your local definition."
    :calc="['engine' => 'con-area', 'tool' => 'floor_area_ratio', 'fields' => ['mode', 'lot', 'floor', 'far', 'footprint'], 'unitFields' => ['lot' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'floor' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'footprint' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'The FAR, or the floor area a limit allows.'],
        ['name' => 'Enter the areas', 'text' => 'Lot area and floor area of every storey.'],
    ]"
    :faqs="[
        ['question' => 'What does FAR 1.0 mean?', 'answer' => 'Floor area equal to the lot area: one storey over the whole lot, or two over half of it.'],
        ['question' => 'Is FAR the same as lot coverage?', 'answer' => 'No. Lot coverage is footprint ÷ lot area; FAR counts every floor.'],
        ['question' => 'Do basements count toward FAR?', 'answer' => 'It depends on the local zoning code.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Work out" :options="['far' => 'FAR', 'allowed' => 'Floor area allowed']" selected="far" />

    <x-calc.field name="lot" label="Lot area" value="10000" min="0" placeholder="Lot area">
        <label for="calc-lot-unit" class="sr-only">Lot area unit</label>
        <select id="calc-lot-unit" name="lot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div data-show-when="mode:far">
        <x-calc.field name="floor" label="Gross floor area (all floors)" value="4500" min="0" placeholder="Gross floor area (all floors)">
            <label for="calc-floor-unit" class="sr-only">Gross floor area (all floors) unit</label>
            <select id="calc-floor-unit" name="floor-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:allowed" hidden>
        <x-calc.field name="far" label="FAR limit" value="0.5" min="0" step="0.05" />
    </div>

    <x-calc.field name="footprint" label="Building footprint (optional)" value="2250" min="0" placeholder="Building footprint (optional)">
        <label for="calc-footprint-unit" class="sr-only">Building footprint (optional) unit</label>
        <select id="calc-footprint-unit" name="footprint-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Floor area ratio" />

    <x-calc.options :examples="[
        'House on 10,000 ft²' => ['mode' => 'far', 'lot' => 10000, 'lot-unit' => 'ft2', 'floor' => 4500, 'floor-unit' => 'ft2', 'footprint' => 2250, 'footprint-unit' => 'ft2'],
        'FAR 2 on 800 m²' => ['mode' => 'allowed', 'lot' => 800, 'lot-unit' => 'm2', 'far' => 2, 'footprint' => 400, 'footprint-unit' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm2' => ['label' => 'Square meters'],
            'coverage' => ['label' => 'Lot coverage'],
            'floors' => ['label' => 'Floors'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FAR = gross floor area ÷ lot area</li>
            <li>lot coverage = footprint ÷ lot area</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
