<x-calc.page
    title="Garbage Bag Size Calculator - SolveKit"
    description="Free garbage bag size calculator: the flat bag width and length that fit a round or square trash can, and the can's capacity in gallons and liters."
    lede="Find the right garbage bag size for your bin."
    about="A bag's flat width is half its opening's circumference, so it must be at least half the bin's perimeter (π × diameter ÷ 2 for a round can). The length must cover the height plus half the base, plus a few inches to fold over the rim."
    :calc="['engine' => 'ev-care', 'tool' => 'garbage_bag', 'fields' => ['shape', 'diameter', 'length', 'width', 'height', 'overhang'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'overhang' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the bin shape', 'text' => 'And measure it.'],
        ['name' => 'Set the overhang', 'text' => 'About 4 inches.'],
    ]"
    :faqs="[
        ['question' => 'What size bag for a 16 × 24 in round can?', 'answer' => 'At least 26 × 36 in.'],
        ['question' => 'What does 13 gallon mean?', 'answer' => 'The bag\'s rated capacity; kitchen bags are often 24 × 27–28 in.'],
        ['question' => 'How do I measure a square bin?', 'answer' => 'Length, width and height inside.'],
    ]"
>
    <x-calc.segmented name="shape" legend="Bin shape" :options="['round' => 'Round', 'square' => 'Square or rectangular']" selected="round" />

    <div data-show-when="shape:round">
        <x-calc.field name="diameter" label="Diameter" value="16" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="shape:square" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Length" value="15" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="11" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="24" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="overhang" label="Overhang" value="4" min="0" placeholder="Overhang">
            <label for="calc-overhang-unit" class="sr-only">Overhang unit</label>
            <select id="calc-overhang-unit" name="overhang-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Bag size (flat width × length)" />

    <x-calc.options :examples="[
        'Round 16 × 24 in' => ['shape' => 'round', 'diameter' => 16, 'diameter-unit' => 'in', 'length' => '', 'length-unit' => 'in', 'width' => '', 'width-unit' => 'in', 'height' => 24, 'height-unit' => 'in', 'overhang' => 4, 'overhang-unit' => 'in'],
        'Kitchen 15 × 11 × 24 in' => ['shape' => 'square', 'diameter' => '', 'diameter-unit' => 'in', 'length' => 15, 'length-unit' => 'in', 'width' => 11, 'width-unit' => 'in', 'height' => 24, 'height-unit' => 'in', 'overhang' => 4, 'overhang-unit' => 'in'],
        'Metric 40 cm round' => ['shape' => 'round', 'diameter' => 40, 'diameter-unit' => 'cm', 'length' => '', 'length-unit' => 'cm', 'width' => '', 'width-unit' => 'cm', 'height' => 60, 'height-unit' => 'cm', 'overhang' => 10, 'overhang-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'capacity' => ['label' => 'Bin capacity'],
            'rule' => ['label' => 'Rule'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>width = perimeter ÷ 2</li>
            <li>length = height + base ÷ 2 + overhang</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
