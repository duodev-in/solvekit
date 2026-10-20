<x-calc.page
    title="Section Modulus Calculator - SolveKit"
    description="Free section modulus calculator: second moment of area, elastic and plastic section modulus of rectangles, tubes and I-beams."
    lede="Find section properties for bending."
    about="In bending, stress = M/S, where S = I/c is the elastic section modulus. The plastic modulus Z gives the moment for a fully yielded section; Z/S is the shape factor."
    :calc="['engine' => 'ph-mat', 'tool' => 'section_modulus', 'fields' => ['shape', 'b', 'h', 't', 'tw', 'd', 'di', 'out'], 'unitFields' => ['b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'tw' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'di' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area_moment', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is S for the example 200 × 100 I-beam?', 'answer' => 'S = 184.559 cm³, Z = 209.66 cm³ (bending about the strong axis).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Section" :options="['rect' => 'Rectangle', 'box' => 'Rectangular hollow section', 'round' => 'Solid round', 'tube' => 'Round tube', 'ibeam' => 'I-beam (symmetric)']" selected="ibeam" />
        <div data-show-when="shape:rect,box,ibeam">
            <x-calc.field name="b" label="Width b (flange width)" value="100" placeholder="Width b (flange width)">
                <label for="calc-b-unit" class="sr-only">Width b (flange width) unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rect,box,ibeam">
            <x-calc.field name="h" label="Depth h" value="200" placeholder="Depth h">
                <label for="calc-h-unit" class="sr-only">Depth h unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:box,ibeam">
            <x-calc.field name="t" label="Wall or flange thickness" value="8.5" placeholder="Wall or flange thickness">
                <label for="calc-t-unit" class="sr-only">Wall or flange thickness unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:ibeam">
            <x-calc.field name="tw" label="Web thickness" value="5.6" placeholder="Web thickness">
                <label for="calc-tw-unit" class="sr-only">Web thickness unit</label>
                <select id="calc-tw-unit" name="tw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:round,tube">
            <x-calc.field name="d" label="Outer diameter" value="60" placeholder="Outer diameter">
                <label for="calc-d-unit" class="sr-only">Outer diameter unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:tube">
            <x-calc.field name="di" label="Inner diameter" value="50" placeholder="Inner diameter">
                <label for="calc-di-unit" class="sr-only">Inner diameter unit</label>
                <select id="calc-di-unit" name="di-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m4' => 'm⁴', 'cm4' => 'cm⁴', 'mm4' => 'mm⁴', 'in4' => 'in⁴', 'ft4' => 'ft⁴']" selected="cm4" />
    </div>

    <x-calc.result label="Second moment of area I" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm4', 'shape' => 'ibeam', 'b' => 100, 'b-unit' => 'mm', 'h' => 200, 'h-unit' => 'mm', 't' => 8.5, 't-unit' => 'mm', 'tw' => 5.6, 'tw-unit' => 'mm', 'd' => 60, 'd-unit' => 'mm', 'di' => 50, 'di-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'S' => ['label' => 'Elastic section modulus S = I/c'],
            'Z' => ['label' => 'Plastic section modulus Z'],
            'shape' => ['label' => 'Shape factor Z/S'],
            'A' => ['label' => 'Area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
