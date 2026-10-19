<x-calc.page
    title="Bacon Curing Calculator - SolveKit"
    description="Free bacon curing calculator: Prague Powder #1, salt and sugar for curing bacon, ham or sausage, kept within USDA FSIS nitrite limits."
    lede="Work out curing salt for homemade bacon."
    about="Prague Powder #1 (Cure #1, pink curing salt) is 6.25% sodium nitrite. Cure needed = meat weight × target ppm ÷ 1,000,000 ÷ 0.0625. USDA FSIS limits ingoing nitrite to 120 ppm for brine-cured (pumped or immersion) bacon, 200 ppm for dry-cured bacon and 156 ppm for sausage and ground meats. Salt (about 2–2.5%) and sugar (1–2%) are by weight of the meat. Weigh the cure precisely, mix it evenly, cure in the refrigerator and cook bacon before eating. This is general guidance; follow a tested recipe. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-other', 'tool' => 'curing', 'fields' => ['meat', 'product', 'ppm', 'salt', 'sugar'], 'unitFields' => ['meat' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the meat weight', 'text' => ''],
        ['name' => 'Choose the product', 'text' => 'It sets the nitrite limit.'],
        ['name' => 'Set salt and sugar', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much Cure #1 for a 5 lb pork belly?', 'answer' => '7.26 g (200 ppm ingoing nitrite for 2,268 g (5 lb) of bacon, dry cure; FSIS limit 200 ppm).'],
        ['question' => 'And salt?', 'answer' => '49.9 g (2.5% of the meat, less the salt in the cure).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="meat" label="Meat weight" value="5" min="0" placeholder="Meat weight">
            <label for="calc-meat-unit" class="sr-only">Meat weight unit</label>
            <select id="calc-meat-unit" name="meat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="product" label="Product" :options="['bacon_dry' => 'Bacon, dry cure (200 ppm max)', 'bacon_wet' => 'Bacon, brine cure (120 ppm max)', 'sausage' => 'Sausage or ground meat (156 ppm max)', 'whole' => 'Ham or whole muscle, brine (200 ppm max)']" selected="bacon_dry" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ppm" label="Target nitrite" value="" min="0" step="1" suffix="ppm" placeholder="The limit" />
        <x-calc.field name="salt" label="Salt" value="2.5" min="0" step="any" suffix="%" />
        <x-calc.field name="sugar" label="Sugar" value="1.5" min="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Prague Powder #1 (Cure #1)" />

    <x-calc.options :decimals="false" :examples="[
        '5 lb belly' => ['meat' => 5, 'meat-unit' => 'lb', 'product' => 'bacon_dry', 'ppm' => '', 'salt' => 2.5, 'sugar' => 1.5],
        '2 kg sausage' => ['meat' => 2, 'meat-unit' => 'kg', 'product' => 'sausage', 'ppm' => '', 'salt' => 2, 'sugar' => 0.5],
        'Lower nitrite' => ['meat' => 5, 'meat-unit' => 'lb', 'product' => 'bacon_dry', 'ppm' => 120, 'salt' => 2.5, 'sugar' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'salt' => ['label' => 'Salt'],
            'sugar' => ['label' => 'Sugar'],
            'nitrite' => ['label' => 'Sodium nitrite'],
            'time' => ['label' => 'Curing'],
            'warning' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cure g = meat g × ppm ÷ 10⁶ ÷ 0.0625</li>
            <li>salt = meat × % − salt in the cure</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
