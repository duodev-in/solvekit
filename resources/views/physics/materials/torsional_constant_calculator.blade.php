<x-calc.page
    title="Torsional Constant Calculator - SolveKit"
    description="Free torsional constant calculator: J for round bars, tubes, rectangles and thin-walled open and closed sections."
    lede="Find the torsional constant J."
    about="The torsional constant sets how stiff a section is in twist. For round sections it equals the polar moment; rectangles need Saint-Venant’s series; thin closed tubes are far stiffer than open sections of the same material."
    :calc="['engine' => 'ph-mat', 'tool' => 'torsional_constant', 'fields' => ['shape', 'd', 'di', 'a', 'b', 'Am', 'per', 'tw', 'segs', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'di' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'Am' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'per' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'tw' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'area_moment', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is J for a 100 × 20 mm rectangle?', 'answer' => '233,053 mm⁴.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Section" :options="['round' => 'Solid round', 'tube' => 'Round tube', 'rect' => 'Solid rectangle', 'closed' => 'Thin-walled closed section', 'open' => 'Thin-walled open section (angle, channel, I)']" selected="rect" />
        <div data-show-when="shape:round,tube">
            <x-calc.field name="d" label="Outer diameter" value="50" placeholder="Outer diameter">
                <label for="calc-d-unit" class="sr-only">Outer diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:tube">
            <x-calc.field name="di" label="Inner diameter" value="40" placeholder="Inner diameter">
                <label for="calc-di-unit" class="sr-only">Inner diameter unit</label>
                <select id="calc-di-unit" name="di-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rect">
            <x-calc.field name="a" label="Long side" value="100" placeholder="Long side">
                <label for="calc-a-unit" class="sr-only">Long side unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rect">
            <x-calc.field name="b" label="Short side" value="20" placeholder="Short side">
                <label for="calc-b-unit" class="sr-only">Short side unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:closed">
            <x-calc.field name="Am" label="Area enclosed by the wall mid-line" value="5000" min="0" placeholder="Area enclosed by the wall mid-line">
                <label for="calc-Am-unit" class="sr-only">Area enclosed by the wall mid-line unit</label>
                <select id="calc-Am-unit" name="Am-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:closed">
            <x-calc.field name="per" label="Mid-line perimeter" value="300" placeholder="Mid-line perimeter">
                <label for="calc-per-unit" class="sr-only">Mid-line perimeter unit</label>
                <select id="calc-per-unit" name="per-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:closed">
            <x-calc.field name="tw" label="Wall thickness" value="3" placeholder="Wall thickness">
                <label for="calc-tw-unit" class="sr-only">Wall thickness unit</label>
                <select id="calc-tw-unit" name="tw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:open">
            <x-calc.textarea name="segs" label="Open-section parts: length, thickness in mm (one per line)" value="100, 8
100, 8
184, 5" rows="3" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m4' => 'm⁴', 'cm4' => 'cm⁴', 'mm4' => 'mm⁴', 'in4' => 'in⁴', 'ft4' => 'ft⁴']" selected="mm4" />
    </div>

    <x-calc.result label="Torsional constant J" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm4', 'shape' => 'rect', 'd' => 50, 'd-unit' => 'mm', 'di' => 40, 'di-unit' => 'mm', 'a' => 100, 'a-unit' => 'mm', 'b' => 20, 'b-unit' => 'mm', 'Am' => 5000, 'Am-unit' => 'mm2', 'per' => 300, 'per-unit' => 'mm', 'tw' => 3, 'tw-unit' => 'mm', 'segs' => '100, 8
100, 8
184, 5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'method' => ['label' => 'Method'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
