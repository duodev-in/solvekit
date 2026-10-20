<x-calc.page
    title="Arrow Speed Calculator - SolveKit"
    description="Free arrow speed calculator: estimate real arrow speed from the IBO rating, draw length, draw weight and arrow weight."
    lede="Estimate how fast your arrow really flies."
    about="Bow makers quote an IBO speed measured at 30 in of draw, 70 lb and a 350-grain arrow. Your own set-up is usually slower: shorter draw, heavier arrows and string accessories all cost speed. This calculator applies the common archery rules of thumb and adds the kinetic energy and momentum that matter for hunting."
    :calc="['engine' => 'ph-mech', 'tool' => 'arrow_speed', 'fields' => ['ibo', 'draw', 'weight', 'arrow', 'extra', 'out'], 'unitFields' => ['ibo' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'draw' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'momentum', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is a 420-grain arrow from a 320 ft/s bow at 29 in?', 'answer' => 'About 283.333 ft/s with 10 grains on the string.'],
        ['question' => 'Is this exact?', 'answer' => 'No. It is the standard rule-of-thumb estimate; cam design and tuning change the real speed, so a chronograph gives the true figure.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ibo" label="IBO speed rating" value="320" placeholder="IBO speed rating">
            <label for="calc-ibo-unit" class="sr-only">IBO speed rating unit</label>
            <select id="calc-ibo-unit" name="ibo-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'fts')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="draw" label="Draw length" value="29" placeholder="Draw length">
            <label for="calc-draw-unit" class="sr-only">Draw length unit</label>
            <select id="calc-draw-unit" name="draw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Draw weight (lbf)" value="70" min="0" step="any" />
        <x-calc.field name="arrow" label="Arrow weight (grains)" value="420" min="0" step="any" />
        <x-calc.field name="extra" label="Extra weight on the string (grains)" value="10" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="fts" />
    </div>

    <x-calc.result label="Estimated arrow speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'fts', 'ibo' => 320, 'ibo-unit' => 'fts', 'draw' => 29, 'draw-unit' => 'in', 'weight' => 70, 'arrow' => 420, 'extra' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ke' => ['label' => 'Kinetic energy'],
            'momentum' => ['label' => 'Momentum'],
            'ratio' => ['label' => 'Arrow weight per pound of draw'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
