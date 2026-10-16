<x-calc.page
    title="Lime Calculator - SolveKit"
    description="Free lime calculator: estimate how much ground limestone raises your soil pH."
    lede="Estimate how much lime raises your soil pH."
    about="Clay and organic soils resist pH change more than sandy soils, so they need more lime. These are rule-of-thumb rates; a soil test with a buffer pH gives the exact amount for your soil."
    :calc="['engine' => 'garden', 'tool' => 'lime', 'fields' => ['area', 'current', 'target', 'texture'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => config('biology_data.lime_per_ph_unit')]"
    :how-to="[
        ['name' => 'Test your soil', 'text' => 'Use a lab test or a home kit for the current pH.'],
        ['name' => 'Enter the target pH', 'text' => 'Most lawns and vegetables prefer 6.0 to 7.0.'],
    ]"
    :faqs="[
        ['question' => 'How long does lime take to work?', 'answer' => 'Several months; pelletized lime works a little faster than coarse lime.'],
        ['question' => 'Can I apply all the lime at once?', 'answer' => 'Apply at most about 50 lb per 1,000 ft² at a time on lawns; split larger amounts.'],
        ['question' => 'How do I lower pH?', 'answer' => 'With elemental sulfur, not lime.'],
    ]"
>
    <x-calc.field name="area" label="Area" value="1000" min="0" placeholder="Area">
        <label for="calc-area-unit" class="sr-only">Area unit</label>
        <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="current" label="Current pH" value="5.5" min="3" max="8.5" step="0.1" />
        <x-calc.field name="target" label="Target pH" value="6.5" min="3" max="8.5" step="0.1" />
        <x-calc.select name="texture" label="Soil" :options="collect(config('biology_data.lime_per_ph_unit'))->map(fn ($item) => $item['name'])->all()" selected="loam" />
    </div>

    <x-calc.result label="Ground limestone (estimate)" />

    <x-calc.options :examples="[
        'Lawn 5.5 → 6.5' => ['area' => 1000, 'current' => 5.5, 'target' => 6.5, 'texture' => 'loam'],
        'Sandy bed 5.8 → 6.5' => ['area' => 200, 'current' => 5.8, 'target' => 6.5, 'texture' => 'sandy'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms', 'unit' => 'kg'],
            'per1000' => ['label' => 'Per 1,000 ft²', 'unit' => 'lb'],
            'bags' => ['label' => 'Bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lime = rate per pH unit × (target − current) × area ÷ 1,000 ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
