<x-calc.page
    title="Sulfur Calculator - SolveKit"
    description="Free sulfur (sulfite) calculator: potassium metabisulfite or Campden tablets for a target SO₂ level in juice, cider, wine or a sanitising solution."
    lede="Dose sulfite (SO₂) by parts per million."
    about="Sulfite is added as potassium metabisulfite (57.6% SO₂ by weight), usually as Campden tablets of about 0.44 g, or as sodium metabisulfite (67.4% SO₂). Parts per million here means mg of SO₂ per litre: SO₂ needed = ppm × litres. About 50 ppm is common for juice before fermenting; a sanitising rinse is far stronger and is not added to drinks. For finished wine use the pH-based SO₂ Wine Calculator, since the protective molecular SO₂ depends on pH."
    :calc="['engine' => 'fd-drinks', 'tool' => 'sulfite', 'fields' => ['volume', 'ppm', 'form', 'tablet'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all()]]"
    :how-to="[
        ['name' => 'Enter the volume and the SO₂ level', 'text' => ''],
        ['name' => 'Choose tablets or powder', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many Campden tablets for 5 gallons at 50 ppm?', 'answer' => '3.73 tablets.'],
        ['question' => 'How much powder for 20 L at 30 ppm?', 'answer' => '1.04 g potassium metabisulfite (57.6% SO₂); weigh it on a 0.01 g scale.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="volume" label="Volume" value="5" min="0" placeholder="Volume">
            <label for="calc-volume-unit" class="sr-only">Volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ppm" label="Target SO₂" value="50" min="0" step="any" suffix="ppm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="form" label="Show as" :options="['tablets' => 'Campden tablets', 'powder' => 'Potassium metabisulfite powder']" selected="tablets" />
        <x-calc.field name="tablet" label="Tablet weight" value="0.44" min="0" step="any" suffix="g" />
    </div>

    <x-calc.result label="Campden tablets" />

    <x-calc.options :decimals="false" :examples="[
        '5 gal juice' => ['volume' => 5, 'volume-unit' => 'gal_us', 'ppm' => 50, 'form' => 'tablets', 'tablet' => 0.44],
        '20 L wine' => ['volume' => 20, 'volume-unit' => 'l', 'ppm' => 30, 'form' => 'powder', 'tablet' => 0.44],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kms' => ['label' => 'Potassium metabisulfite'],
            'tablets' => ['label' => 'Campden tablets'],
            'sodium' => ['label' => 'Sodium metabisulfite'],
            'use' => ['label' => 'Use'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SO₂ mg = ppm × litres</li>
            <li>KMS g = SO₂ mg ÷ 0.576 ÷ 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
