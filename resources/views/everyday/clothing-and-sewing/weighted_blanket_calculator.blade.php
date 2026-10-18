<x-calc.page
    title="Weighted Blanket Calculator - SolveKit"
    description="Free weighted blanket calculator: blanket weight from body weight using the 10% guideline, and the filler for each pocket when sewing one."
    lede="Work out how heavy a weighted blanket should be."
    about="A common guideline is a blanket of about 10% of body weight (some add a pound or two). When sewing one, divide the filler (glass or plastic beads) evenly between the pockets. Weighted blankets are not recommended for infants and toddlers; check with a doctor for children or anyone with health conditions."
    :calc="['engine' => 'ev-clothing', 'tool' => 'weighted_blanket', 'fields' => ['weight', 'percent', 'columns', 'rows'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the body weight', 'text' => 'Of the person using it.'],
        ['name' => 'Enter the pocket grid', 'text' => 'If you are sewing one.'],
    ]"
    :faqs="[
        ['question' => 'How heavy should a weighted blanket be?', 'answer' => 'About 10% of body weight: 15 lb for a 150 lb adult.'],
        ['question' => 'How much filler per pocket?', 'answer' => '15 lb over 80 pockets is about 85 g (3 oz) each.'],
        ['question' => 'Are weighted blankets safe for babies?', 'answer' => 'No, they are not recommended for infants and toddlers.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Body weight" value="150" min="0" placeholder="Body weight">
            <label for="calc-weight-unit" class="sr-only">Body weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="percent" label="Share of body weight" value="10" min="5" max="15" step="1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="columns" label="Pockets across (optional)" value="8" min="1" step="1" />
        <x-calc.field name="rows" label="Pockets down" value="10" min="1" step="1" />
    </div>

    <x-calc.result label="Blanket weight" />

    <x-calc.options :decimals="false" :examples="[
        '150 lb adult' => ['weight' => 150, 'weight-unit' => 'lb', 'percent' => 10, 'columns' => 8, 'rows' => 10],
        '70 kg, 12%' => ['weight' => 70, 'weight-unit' => 'kg', 'percent' => 12, 'columns' => 10, 'rows' => 12],
        'Teen 110 lb' => ['weight' => 110, 'weight-unit' => 'lb', 'percent' => 10, 'columns' => 6, 'rows' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pocket' => ['label' => 'Per pocket'],
            'standard' => ['label' => 'Common weights'],
            'note' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>blanket = body weight × 10%</li>
            <li>per pocket = blanket ÷ pockets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
