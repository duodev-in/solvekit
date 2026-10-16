<x-calc.page
    title="Water Soluble Fertilizer Calculator - SolveKit"
    description="Free water soluble fertilizer calculator: grams of fertilizer to dissolve for a target ppm nitrogen."
    lede="Work out how much water-soluble fertilizer gives a target ppm of nitrogen."
    about="A target of P ppm nitrogen in V liters needs P × V mg of nitrogen. Dividing by the fertilizer's nitrogen fraction gives the amount of fertilizer to dissolve."
    :calc="['engine' => 'garden', 'tool' => 'water_soluble', 'fields' => ['ppm', 'n', 'water'], 'unitFields' => ['water' => collect(config('units.volume'))->only(['l', 'gal_us', 'ft3', 'm3'])->all()]]"
    :how-to="[
        ['name' => 'Enter the target ppm', 'text' => 'Many greenhouse crops use 100 to 200 ppm N.'],
        ['name' => 'Enter the fertilizer N% and water volume', 'text' => 'The first number on the label is N%.'],
    ]"
    :faqs="[
        ['question' => 'What ppm should I feed plants?', 'answer' => 'Often 100 to 200 ppm nitrogen for container plants; seedlings need less.'],
        ['question' => 'How do I mix 20-20-20 at 200 ppm?', 'answer' => 'About 1 g per liter, or 1.33 oz per 10 US gallons.'],
        ['question' => 'Is ppm the same as mg/L?', 'answer' => 'For fertilizer solutions in water, yes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ppm" label="Target nitrogen" value="150" min="0" suffix="ppm" />
        <x-calc.field name="n" label="Fertilizer N" value="20" min="0" suffix="%" />
        <x-calc.field name="water" label="Water" value="10" min="0" placeholder="Water">
            <label for="calc-water-unit" class="sr-only">Water unit</label>
            <select id="calc-water-unit" name="water-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['l', 'gal_us', 'ft3', 'm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Fertilizer to dissolve" />

    <x-calc.options :examples="[
        '200 ppm from 20-20-20' => ['ppm' => 200, 'n' => 20, 'water' => 10],
        'Seedlings 75 ppm' => ['ppm' => 75, 'n' => 15, 'water' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_l' => ['label' => 'Per liter'],
            'per_gal' => ['label' => 'Per US gallon'],
            'oz' => ['label' => 'Ounces', 'unit' => 'oz'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fertilizer (g) = ppm × liters ÷ (N% × 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
