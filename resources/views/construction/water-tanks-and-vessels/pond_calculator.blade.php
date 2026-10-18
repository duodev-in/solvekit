<x-calc.page
    title="Pond Calculator - SolveKit"
    description="Free pond calculator: pond volume in gallons, liner size and pump flow for a garden or koi pond."
    lede="Work out a pond's volume, liner size and pump flow."
    about="Volume = surface area × average depth. A liner must cover the length and width plus twice the deepest depth and an overlap each side (often 1–2 ft). Garden ponds commonly circulate their volume about once an hour or two; koi ponds often more."
    :calc="['engine' => 'con-water', 'tool' => 'pond', 'fields' => ['shape', 'length', 'width', 'diameter', 'average', 'max_depth', 'overlap', 'turnover'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'average' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'max_depth' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'overlap' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Pick the shape', 'text' => 'And the surface size.'],
        ['name' => 'Enter the depths', 'text' => 'Average for volume, deepest for the liner.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons in a 12 × 8 ft pond 2 ft deep?', 'answer' => 'About 1,130 gallons for an oval and 1,440 for a rectangle.'],
        ['question' => 'What size liner for a 12 × 8 ft pond 3 ft deep?', 'answer' => '20 × 16 ft with 1 ft overlap.'],
        ['question' => 'What size pump do I need?', 'answer' => 'About the pond volume per hour for a garden pond.'],
    ]"
>
    <div class="flex flex-col gap-3">
        <x-calc.shape :shapes="['rectangle', 'oval', 'circle']" selected="rectangle" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="shape:rectangle,oval">
                <x-calc.field name="length" label="Length" value="12" min="0" placeholder="Length">
                    <label for="calc-length-unit" class="sr-only">Length unit</label>
                    <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:rectangle,oval">
                <x-calc.field name="width" label="Width" value="8" min="0" placeholder="Width">
                    <label for="calc-width-unit" class="sr-only">Width unit</label>
                    <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:circle" hidden>
                <x-calc.field name="diameter" label="Diameter" value="10" min="0" placeholder="Diameter">
                    <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                    <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="average" label="Average depth" value="2" min="0" placeholder="Average depth">
            <label for="calc-average-unit" class="sr-only">Average depth unit</label>
            <select id="calc-average-unit" name="average-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="max_depth" label="Deepest depth" value="3" min="0" placeholder="Deepest depth">
            <label for="calc-max_depth-unit" class="sr-only">Deepest depth unit</label>
            <select id="calc-max_depth-unit" name="max_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="overlap" label="Liner overlap each side" value="12" min="0" placeholder="Liner overlap each side">
            <label for="calc-overlap-unit" class="sr-only">Liner overlap each side unit</label>
            <select id="calc-overlap-unit" name="overlap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="turnover" label="Turn the water over every" value="1" min="0.1" step="0.5" suffix="h" />
    </div>

    <x-calc.result label="Pond volume" />

    <x-calc.options :examples="[
        'Rectangle 12 × 8 ft' => ['shape' => 'rectangle', 'length' => 12, 'width' => 8, 'length-unit' => 'ft', 'width-unit' => 'ft', 'average' => 2, 'average-unit' => 'ft', 'max_depth' => 3, 'max_depth-unit' => 'ft', 'overlap' => 12, 'overlap-unit' => 'in', 'turnover' => 1],
        'Oval koi pond 5 × 3 m' => ['shape' => 'oval', 'length' => 5, 'width' => 3, 'length-unit' => 'm', 'width-unit' => 'm', 'average' => 1.2, 'average-unit' => 'm', 'max_depth' => 1.5, 'max_depth-unit' => 'm', 'overlap' => 300, 'overlap-unit' => 'mm', 'turnover' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liner' => ['label' => 'Liner size'],
            'pump' => ['label' => 'Pump flow'],
            'liters' => ['label' => 'Liters'],
            'ft3' => ['label' => 'Cubic feet'],
            'weight' => ['label' => 'Water weight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = area × average depth</li>
            <li>liner = (L + 2D + 2 overlap) × (W + 2D + 2 overlap)</li>
            <li>pump = V ÷ turnover time</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
