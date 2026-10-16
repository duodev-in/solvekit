<x-calc.page
    title="Grass Seed Calculator - SolveKit"
    description="Free grass seed calculator: pounds of seed for a new lawn or overseeding, by grass type."
    lede="Work out how much grass seed you need for a new lawn or overseeding."
    about="Seed is spread at a rate in pounds per 1,000 ft² that depends on the grass: small-seeded grasses like bluegrass need far less than tall fescue. Rates here are typical extension-service figures; the seed bag label takes priority."
    :calc="['engine' => 'garden', 'tool' => 'grass_seed', 'fields' => ['area', 'grass', 'job'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()], 'data' => config('biology_data.grass_seed')]"
    :how-to="[
        ['name' => 'Measure the lawn', 'text' => 'Enter the area to be seeded.'],
        ['name' => 'Pick the grass and the job', 'text' => 'New lawns need about twice the seed of overseeding.'],
    ]"
    :faqs="[
        ['question' => 'How much tall fescue seed per 1,000 ft²?', 'answer' => 'About 7 to 9 lb for a new lawn and 4 lb for overseeding.'],
        ['question' => 'How much Kentucky bluegrass seed do I need?', 'answer' => 'About 2 to 3 lb per 1,000 ft² for a new lawn.'],
        ['question' => 'Can I use more seed than recommended?', 'answer' => 'Too much seed crowds seedlings and invites disease. Stick close to the rate.'],
    ]"
>
    <x-calc.field name="area" label="Lawn area" value="2000" min="0" placeholder="Lawn area">
        <label for="calc-area-unit" class="sr-only">Lawn area unit</label>
        <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="grass" label="Grass type" :options="collect(config('biology_data.grass_seed'))->map(fn ($item) => $item['name'])->all()" selected="tall_fescue" />
        <x-calc.segmented name="job" legend="Job" :options="['new' => 'New lawn', 'overseed' => 'Overseed']" selected="new" />
    </div>

    <x-calc.result label="Seed needed" />

    <x-calc.options :examples="[
        'New lawn 5,000 ft²' => ['area' => 5000, 'area-unit' => 'ft2', 'job' => 'new'],
        'Overseed 1,000 ft²' => ['area' => 1000, 'area-unit' => 'ft2', 'job' => 'overseed'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms', 'unit' => 'kg'],
            'rate' => ['label' => 'Rate'],
            'bags' => ['label' => 'Bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>seed (lb) = area ÷ 1,000 × rate</li>
            <li>rates in lb per 1,000 ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
