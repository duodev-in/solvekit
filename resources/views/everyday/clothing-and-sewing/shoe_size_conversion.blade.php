<x-calc.page
    title="Shoe Size Conversion - SolveKit"
    description="Free shoe size conversion: US men's and women's, UK, EU, Japanese and Mondopoint shoe sizes from foot length or any size."
    lede="Convert shoe sizes between systems."
    about="Shoe sizes are conventions built on foot length. Mondopoint (ISO 9407) is the foot length in millimeters, and Japanese sizes are the foot length in centimeters. On the Brannock scale used in the US, men's size ≈ 3 × foot length (in) − 22 and women's 1.5 sizes more; UK sizes are one less than US men's; EU (Paris points) ≈ 1.5 × (foot cm + 2). Makers' lasts differ, so try shoes on."
    :calc="['engine' => 'ev-clothing', 'tool' => 'shoe', 'fields' => ['from', 'foot', 'size'], 'unitFields' => ['foot' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Foot length or a size.'],
        ['name' => 'Enter it', 'text' => 'Measure the foot standing, heel to longest toe.'],
    ]"
    :faqs="[
        ['question' => 'What is a US men\'s 9.5 in EU?', 'answer' => 'About 43.'],
        ['question' => 'How do I measure my foot?', 'answer' => 'Stand on paper, mark heel and longest toe, and measure.'],
        ['question' => 'What is Mondopoint?', 'answer' => 'The international system: foot length in millimeters.'],
    ]"
>
    <x-calc.select name="from" label="I know" :options="['length' => 'Foot length', 'us_men' => 'US men\'s size', 'us_women' => 'US women\'s size', 'uk' => 'UK size', 'eu' => 'EU size', 'mondo' => 'Mondopoint (mm)']" selected="length" />

    <div data-show-when="from:length">
        <x-calc.field name="foot" label="Foot length" value="26.5" min="0" placeholder="Foot length">
            <label for="calc-foot-unit" class="sr-only">Foot length unit</label>
            <select id="calc-foot-unit" name="foot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="from:us_men,us_women,uk,eu,mondo" hidden>
        <x-calc.field name="size" label="Size" value="9.5" min="0" step="0.5" />
    </div>

    <x-calc.result label="Shoe size" />

    <x-calc.options :decimals="false" :examples="[
        '26.5 cm foot' => ['from' => 'length', 'foot' => 26.5, 'foot-unit' => 'cm', 'size' => ''],
        'US women 8' => ['from' => 'us_women', 'foot' => '', 'foot-unit' => 'cm', 'size' => 8],
        'EU 42' => ['from' => 'eu', 'foot' => '', 'foot-unit' => 'cm', 'size' => 42],
        'UK 10' => ['from' => 'uk', 'foot' => '', 'foot-unit' => 'cm', 'size' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'women' => ['label' => 'US women'],
            'uk' => ['label' => 'UK'],
            'eu' => ['label' => 'EU'],
            'jp' => ['label' => 'Japan'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>US men = 3L − 22, US women = 3L − 20.5, UK = 3L − 23 (L in inches)</li>
            <li>EU = 1.5 × (cm + 2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
