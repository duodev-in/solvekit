<x-calc.page
    title="Horse Weight Calculator - SolveKit"
    description="Free horse weight calculator: estimate weight from heart girth and body length with a weight tape formula."
    lede="Estimate a horse's weight from heart girth and body length."
    about="Weight (lb) = heart girth² × body length ÷ 330, with both in inches, for adult horses (Carroll and Huntington, 1988). Measure the girth just behind the elbow and the length from the point of the shoulder to the point of the buttock."
    :calc="['engine' => 'animals', 'tool' => 'horse_weight', 'fields' => ['girth', 'length', 'group'], 'unitFields' => ['girth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the girth', 'text' => 'Around the barrel behind the elbow, after breathing out.'],
        ['name' => 'Measure the length', 'text' => 'Point of shoulder to point of buttock.'],
    ]"
    :faqs="[
        ['question' => 'How accurate is a weight tape?', 'answer' => 'Usually within about 3 to 10% of a scale.'],
        ['question' => 'How much should a horse eat?', 'answer' => 'About 1.5 to 2.5% of body weight a day in forage dry matter.'],
        ['question' => 'Does this work for ponies and drafts?', 'answer' => 'Roughly; very heavy or fine-boned breeds are less accurate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="girth" label="Heart girth" value="72" min="0" placeholder="Heart girth">
            <label for="calc-girth-unit" class="sr-only">Heart girth unit</label>
            <select id="calc-girth-unit" name="girth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Body length" value="64" min="0" placeholder="Body length">
            <label for="calc-length-unit" class="sr-only">Body length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.segmented name="group" legend="Age group" :options="['adult' => 'Adult', 'yearling' => 'Yearling', 'weanling' => 'Weanling']" selected="adult" />

    <x-calc.result label="Estimated weight" />

    <x-calc.options :examples="[
        'Average horse' => ['girth' => 72, 'girth-unit' => 'in', 'length' => 64, 'length-unit' => 'in', 'group' => 'adult'],
        'Pony' => ['girth' => 60, 'girth-unit' => 'in', 'length' => 52, 'length-unit' => 'in', 'group' => 'adult'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'In kilograms'],
            'forage' => ['label' => 'Forage a day'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>adult: lb = girth² × length ÷ 330</li>
            <li>yearling ÷ 301 · weanling ÷ 280</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
