<x-calc.page
    title="Sod Calculator - SolveKit"
    description="Free sod calculator: square feet of sod to order, pieces, pallets and cost, with waste."
    lede="Work out how much sod to order, with extra for cuts."
    about="Order the lawn area plus 5 to 10% for cutting around curves and edges. Sod is commonly sold in 16 × 24 inch pieces and pallets of about 450 ft², but check your supplier."
    :calc="['engine' => 'garden', 'tool' => 'sod', 'fields' => ['area', 'waste', 'price'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Measure the lawn', 'text' => 'Split odd shapes into rectangles and add them up.'],
        ['name' => 'Add waste', 'text' => '5% for simple shapes, 10% for curved beds.'],
    ]"
    :faqs="[
        ['question' => 'How much sod is on a pallet?', 'answer' => 'Usually 400 to 500 ft²; 450 ft² is common.'],
        ['question' => 'How much extra sod should I order?', 'answer' => '5 to 10% for cuts and waste.'],
        ['question' => 'When is the best time to lay sod?', 'answer' => 'Spring or early autumn, when temperatures are mild and rain is more reliable.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Lawn area" value="1000" min="0" placeholder="Lawn area">
            <label for="calc-area-unit" class="sr-only">Lawn area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="waste" label="Extra for waste" value="5" min="0" suffix="%" />
    </div>

    <x-calc.field name="price" label="Price per ft² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Sod to order" />

    <x-calc.options :examples="[
        'Back yard 1,200 ft²' => ['area' => 1200, 'area-unit' => 'ft2', 'waste' => 5],
        'Curvy 800 ft²' => ['area' => 800, 'area-unit' => 'ft2', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm2' => ['label' => 'Square meters', 'unit' => 'm²'],
            'pieces' => ['label' => 'Pieces'],
            'pallets' => ['label' => 'Pallets'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sod = area × (1 + waste %)</li>
            <li>piece = 16 × 24 in = 2.67 ft²</li>
            <li>pallet ≈ 450 ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
