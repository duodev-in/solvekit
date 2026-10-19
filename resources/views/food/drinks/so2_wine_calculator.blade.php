<x-calc.page
    title="SO2 Wine Calculator - SolveKit"
    description="Free SO₂ wine calculator: potassium metabisulfite or Campden tablets to reach a target molecular SO₂ at your wine's pH, from the free SO₂ you have now."
    lede="Work out sulfite additions for wine."
    about="Only the molecular form of SO₂ protects wine, and its share depends strongly on pH: free SO₂ needed = molecular × (1 + 10^(pH − 1.81)). Common targets are 0.8 mg/L molecular for whites and 0.5 for reds. Potassium metabisulfite (KMS) is 57.6% SO₂ by weight. Measure free SO₂ and pH before adding; very high-pH wines need impractical amounts and are better acidified first."
    :calc="['engine' => 'fd-drinks', 'tool' => 'so2', 'fields' => ['volume', 'ph', 'current', 'molecular', 'tablet'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk'])->all()]]"
    :how-to="[
        ['name' => 'Enter the volume and pH', 'text' => ''],
        ['name' => 'Enter the free SO₂ now and your target', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much KMS for 5 gallons of white wine at pH 3.4?', 'answer' => '0.72 g (Raise free SO₂ from 10 to 31.9 mg/L (21.9 mg/L in 18.9 L)).'],
        ['question' => 'And a red at pH 3.6?', 'answer' => '0.65 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="volume" label="Wine volume" value="5" min="0" placeholder="Wine volume">
            <label for="calc-volume-unit" class="sr-only">Wine volume unit</label>
            <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['gal_us', 'l', 'ft3', 'm3', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gal_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ph" label="pH" value="3.4" min="2.8" max="4.2" step="0.01" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="current" label="Free SO₂ now" value="10" min="0" step="any" suffix="mg/L" />
        <x-calc.select name="molecular" label="Target molecular SO₂" :options="['0.5' => '0.5 mg/L (reds)', '0.8' => '0.8 mg/L (whites, rosés)', '0.6' => '0.6 mg/L']" selected="0.8" />
        <x-calc.field name="tablet" label="Campden tablet weight" value="0.44" min="0" step="any" suffix="g" />
    </div>

    <x-calc.result label="Potassium metabisulfite to add" />

    <x-calc.options :decimals="false" :examples="[
        'White 5 gal' => ['volume' => 5, 'volume-unit' => 'gal_us', 'ph' => 3.4, 'current' => 10, 'molecular' => '0.8', 'tablet' => 0.44],
        'Red' => ['volume' => 23, 'volume-unit' => 'l', 'ph' => 3.6, 'current' => 15, 'molecular' => '0.5', 'tablet' => 0.44],
        'New wine, no SO₂' => ['volume' => 6, 'volume-unit' => 'gal_us', 'ph' => 3.3, 'current' => 0, 'molecular' => '0.8', 'tablet' => 0.44],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'free' => ['label' => 'Free SO₂ needed'],
            'add' => ['label' => 'To add'],
            'tablets' => ['label' => 'Campden tablets'],
            'solution' => ['label' => '10% solution'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>free = molecular × (1 + 10^(pH − 1.81))</li>
            <li>KMS g = SO₂ mg ÷ 0.576 ÷ 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
