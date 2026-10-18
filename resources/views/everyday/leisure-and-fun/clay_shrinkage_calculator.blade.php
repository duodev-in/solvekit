<x-calc.page
    title="Clay Shrinkage Calculator - SolveKit"
    description="Free clay shrinkage calculator: the shrinkage of a clay body from a test bar, and how big to make a pot so it fires to the size you want."
    lede="Work out clay shrinkage and the size to make a piece."
    about="Clay shrinks as it dries and again as it fires; total shrinkage is often 10–15%. Measure a line on a wet test tile and again after firing: shrinkage = (wet − fired) ÷ wet. To end up a given size, make the piece fired size ÷ (1 − shrinkage). Volume shrinks much more than length."
    :calc="['engine' => 'ev-fun', 'tool' => 'clay', 'fields' => ['mode', 'wet', 'after', 'fired', 'shrink'], 'unitFields' => ['wet' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'after' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'fired' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Shrinkage or the size to make.'],
        ['name' => 'Enter the measurements', 'text' => 'From a test tile or the clay maker.'],
    ]"
    :faqs="[
        ['question' => 'How much does clay shrink?', 'answer' => 'Often 10–15% from wet to fired, depending on the clay and temperature.'],
        ['question' => 'How big should I throw an 8 in bowl?', 'answer' => 'About 9.09 in with 12% shrinkage.'],
        ['question' => 'Why does volume shrink more?', 'answer' => 'It shrinks in all three directions: 12% in length is about 32% in volume.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['shrinkage' => 'Shrinkage from a test', 'size' => 'Size to make']" selected="shrinkage" />

    <div data-show-when="mode:shrinkage">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="wet" label="Wet length" value="10" min="0" placeholder="Wet length">
                <label for="calc-wet-unit" class="sr-only">Wet length unit</label>
                <select id="calc-wet-unit" name="wet-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="after" label="Fired length" value="8.8" min="0" placeholder="Fired length">
                <label for="calc-after-unit" class="sr-only">Fired length unit</label>
                <select id="calc-after-unit" name="after-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:size" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="fired" label="Fired size you want" value="8" min="0" placeholder="Fired size you want">
                <label for="calc-fired-unit" class="sr-only">Fired size you want unit</label>
                <select id="calc-fired-unit" name="fired-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="shrink" label="Shrinkage" value="12" min="0.1" max="49" step="0.5" suffix="%" />
        </div>
    </div>

    <x-calc.result label="Total shrinkage" />

    <x-calc.options :decimals="false" :examples="[
        'Test tile 10 → 8.8 cm' => ['mode' => 'shrinkage', 'wet' => 10, 'wet-unit' => 'cm', 'after' => 8.8, 'after-unit' => 'cm', 'fired' => '', 'fired-unit' => 'in', 'shrink' => ''],
        '8 in bowl at 12%' => ['mode' => 'size', 'wet' => '', 'wet-unit' => 'cm', 'after' => '', 'after-unit' => 'cm', 'fired' => 8, 'fired-unit' => 'in', 'shrink' => 12],
        'Porcelain mug 14%' => ['mode' => 'size', 'wet' => '', 'wet-unit' => 'cm', 'after' => '', 'after-unit' => 'cm', 'fired' => 9, 'fired-unit' => 'cm', 'shrink' => 14],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Scale'],
            'volume' => ['label' => 'Volume'],
            'note' => ['label' => 'Test'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>shrinkage = (wet − fired) ÷ wet</li>
            <li>make = fired ÷ (1 − shrinkage)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
