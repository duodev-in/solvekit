<x-calc.page
    title="Glove Size Calculator - SolveKit"
    description="Free glove size calculator: your glove size from hand circumference and length, with the EN 420 size and letter size."
    lede="Find your glove size."
    about="Glove sizes are traditionally the circumference of the hand around the knuckles (without the thumb) in inches: a hand 8 in around wears size 8. The European glove standard EN 420 uses the same numbers with a hand length for each size (size 8: 182 mm). Letter sizes vary between brands."
    :calc="['engine' => 'ev-clothing', 'tool' => 'glove', 'fields' => ['hand', 'length'], 'unitFields' => ['hand' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure around the knuckles', 'text' => 'Of your dominant hand, without the thumb.'],
        ['name' => 'Measure the length', 'text' => 'Wrist crease to middle fingertip.'],
    ]"
    :faqs="[
        ['question' => 'What glove size is an 8 in hand?', 'answer' => 'Size 8, usually medium for men or large for women.'],
        ['question' => 'How do I measure hand length?', 'answer' => 'From the wrist crease to the tip of the middle finger.'],
        ['question' => 'What is EN 420?', 'answer' => 'The European standard for protective glove sizes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hand" label="Hand circumference" value="8.25" min="0" placeholder="Hand circumference">
            <label for="calc-hand-unit" class="sr-only">Hand circumference unit</label>
            <select id="calc-hand-unit" name="hand-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Hand length (optional)" value="7.3" min="0" placeholder="Hand length (optional)">
            <label for="calc-length-unit" class="sr-only">Hand length (optional) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Glove size" />

    <x-calc.options :examples="[
        '8¼ in hand' => ['hand' => 8.25, 'hand-unit' => 'in', 'length' => 7.3, 'length-unit' => 'in'],
        '19 cm hand' => ['hand' => 19, 'hand-unit' => 'cm', 'length' => 17.5, 'length-unit' => 'cm'],
        'Large 10 in' => ['hand' => 10, 'hand-unit' => 'in', 'length' => 8.2, 'length-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'en' => ['label' => 'EN 420'],
            'letter' => ['label' => 'Letter size'],
            'length' => ['label' => 'Length check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size = hand circumference in inches</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
