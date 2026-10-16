<x-calc.page
    title="Rabbit Cage Size Calculator - SolveKit"
    description="Free rabbit cage size calculator: check an enclosure against the RWAF minimum of 3 × 2 × 1 m for a pair of rabbits."
    lede="Check whether your rabbit enclosure is big enough."
    about="The Rabbit Welfare Association and Fund (RWAF) recommends a continuous space of at least 3 m × 2 m × 1 m high (10 × 6 × 3 ft) for a pair of average-sized rabbits, with the shelter as part of it. For bigger groups this calculator adds 3 m² per extra rabbit as a working estimate."
    :calc="['engine' => 'animals', 'tool' => 'rabbit_enclosure', 'fields' => ['rabbits', 'length', 'width', 'height'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Count the rabbits', 'text' => 'Pairs are recommended.'],
        ['name' => 'Measure the enclosure', 'text' => 'The whole space they can use all the time.'],
    ]"
    :faqs="[
        ['question' => 'How big should a rabbit enclosure be?', 'answer' => 'At least 3 × 2 × 1 m (10 × 6 × 3 ft) for a pair.'],
        ['question' => 'Is a hutch enough?', 'answer' => 'No, a hutch should be a shelter within a larger run.'],
        ['question' => 'Should rabbits live alone?', 'answer' => 'No, they are social and do best with a neutered companion.'],
    ]"
>
    <x-calc.field name="rabbits" label="Number of rabbits" value="2" min="1" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="10" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="6" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="3" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Your floor area" />

    <x-calc.options :examples="[
        'RWAF minimum' => ['rabbits' => 2, 'length' => 3, 'length-unit' => 'm', 'width' => 2, 'width-unit' => 'm', 'height' => 1, 'height-unit' => 'm'],
        'Pet-shop hutch' => ['rabbits' => 2, 'length' => 4, 'length-unit' => 'ft', 'width' => 2, 'width-unit' => 'ft', 'height' => 2, 'height-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'required' => ['label' => 'Minimum area'],
            'length' => ['label' => 'Long enough to run'],
            'height' => ['label' => 'Tall enough'],
            'single' => ['label' => 'Company'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pair minimum: 3 m × 2 m × 1 m</li>
            <li>groups: + 3 m² per extra rabbit (estimate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
