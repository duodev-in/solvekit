<x-calc.page
    title="Square Yards Calculator - SolveKit"
    description="Free square yards calculator: square yards of any shape for carpet, sod, paving or concrete, with square feet, square meters and cost."
    lede="Work out square yards for carpet, sod, paving or fabric."
    about="A square yard is 3 ft × 3 ft = 9 ft² (0.8361 m²). Carpet, sod and some paving are priced by the square yard. Pick a shape and enter its sizes in any unit."
    :calc="['engine' => 'con-area', 'tool' => 'square_yards', 'fields' => ['shape', 'length', 'width', 'diameter', 'base', 'side_a', 'side_b', 'height', 'cut_length', 'cut_width', 'outer', 'inner', 'waste', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Pick a shape', 'text' => 'Rectangle, circle, triangle, trapezoid, L-shape, ring or oval.'],
        ['name' => 'Enter the sizes', 'text' => 'In feet, inches, yards or metric.'],
    ]"
    :faqs="[
        ['question' => 'How many square feet in a square yard?', 'answer' => '9.'],
        ['question' => 'How many square yards is a 12 × 15 ft room?', 'answer' => '180 ft² ÷ 9 = 20 yd².'],
        ['question' => 'How do I convert square meters to square yards?', 'answer' => 'Multiply by 1.196.'],
    ]"
>
    <div class="flex flex-col gap-3">
        <x-calc.shape :shapes="['rectangle', 'circle', 'triangle', 'trapezoid', 'l_shape', 'ring', 'oval']" selected="rectangle" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="shape:rectangle,l_shape,oval">
                <x-calc.field name="length" label="Length" value="20" min="0" placeholder="Length">
                    <label for="calc-length-unit" class="sr-only">Length unit</label>
                    <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:rectangle,l_shape,oval">
                <x-calc.field name="width" label="Width" value="10" min="0" placeholder="Width">
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
            <div data-show-when="shape:triangle" hidden>
                <x-calc.field name="base" label="Base" value="12" min="0" placeholder="Base">
                    <label for="calc-base-unit" class="sr-only">Base unit</label>
                    <select id="calc-base-unit" name="base-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:trapezoid" hidden>
                <x-calc.field name="side_a" label="Top side a" value="8" min="0" placeholder="Top side a">
                    <label for="calc-side_a-unit" class="sr-only">Top side a unit</label>
                    <select id="calc-side_a-unit" name="side_a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:trapezoid" hidden>
                <x-calc.field name="side_b" label="Bottom side b" value="14" min="0" placeholder="Bottom side b">
                    <label for="calc-side_b-unit" class="sr-only">Bottom side b unit</label>
                    <select id="calc-side_b-unit" name="side_b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:triangle,trapezoid" hidden>
                <x-calc.field name="height" label="Height" value="10" min="0" placeholder="Height">
                    <label for="calc-height-unit" class="sr-only">Height unit</label>
                    <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:l_shape" hidden>
                <x-calc.field name="cut_length" label="Cut-out length" value="8" min="0" placeholder="Cut-out length">
                    <label for="calc-cut_length-unit" class="sr-only">Cut-out length unit</label>
                    <select id="calc-cut_length-unit" name="cut_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:l_shape" hidden>
                <x-calc.field name="cut_width" label="Cut-out width" value="4" min="0" placeholder="Cut-out width">
                    <label for="calc-cut_width-unit" class="sr-only">Cut-out width unit</label>
                    <select id="calc-cut_width-unit" name="cut_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:ring" hidden>
                <x-calc.field name="outer" label="Outer diameter" value="12" min="0" placeholder="Outer diameter">
                    <label for="calc-outer-unit" class="sr-only">Outer diameter unit</label>
                    <select id="calc-outer-unit" name="outer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="shape:ring" hidden>
                <x-calc.field name="inner" label="Inner diameter" value="6" min="0" placeholder="Inner diameter">
                    <label for="calc-inner-unit" class="sr-only">Inner diameter unit</label>
                    <select id="calc-inner-unit" name="inner-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="waste" label="Extra for waste (optional)" value="" min="0" max="100" suffix="%" placeholder="0" />
        <x-calc.field name="price" label="Price per yd² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Square yards" />

    <x-calc.options :examples="[
        'Room 12 × 15 ft' => ['shape' => 'rectangle', 'length' => 12, 'width' => 15, 'length-unit' => 'ft', 'width-unit' => 'ft'],
        'Round rug 8 ft' => ['shape' => 'circle', 'diameter' => 8, 'diameter-unit' => 'ft'],
        'Lawn 30 × 20 m' => ['shape' => 'rectangle', 'length' => 30, 'width' => 20, 'length-unit' => 'm', 'width-unit' => 'm', 'waste' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ft2' => ['label' => 'Square feet'],
            'm2' => ['label' => 'Square meters'],
            'perimeter' => ['label' => 'Perimeter'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>yd² = ft² ÷ 9</li>
            <li>1 yd² = 0.836 127 m²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
