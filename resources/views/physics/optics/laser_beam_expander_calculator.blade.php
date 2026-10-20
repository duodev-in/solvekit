<x-calc.page
    title="Laser Beam Expander Calculator - SolveKit"
    description="Free laser beam expander calculator: output diameter, divergence and lens spacing for Galilean and Keplerian expanders."
    lede="Design a beam expander."
    about="A beam expander is a telescope used backwards: it enlarges the beam by M = f₂/f₁ and divides the divergence by the same factor."
    :calc="['engine' => 'ph-wave', 'tool' => 'beam_expander', 'fields' => ['type', 'f1', 'f2', 'D', 'th', 'out'], 'unitFields' => ['f1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'th' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 25/100 mm expander do to a 2 mm beam?', 'answer' => 'It makes it 8 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Design" :options="['kepler' => 'Keplerian (two positive lenses)', 'galileo' => 'Galilean (negative then positive)']" selected="galileo" />
        <x-calc.field name="f1" label="Input lens focal length (magnitude)" value="25" placeholder="Input lens focal length (magnitude)">
            <label for="calc-f1-unit" class="sr-only">Input lens focal length (magnitude) unit</label>
            <select id="calc-f1-unit" name="f1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f2" label="Output lens focal length" value="100" placeholder="Output lens focal length">
            <label for="calc-f2-unit" class="sr-only">Output lens focal length unit</label>
            <select id="calc-f2-unit" name="f2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D" label="Input beam diameter" value="2" placeholder="Input beam diameter">
            <label for="calc-D-unit" class="sr-only">Input beam diameter unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="th" label="Input full divergence" value="1" placeholder="Input full divergence">
            <label for="calc-th-unit" class="sr-only">Input full divergence unit</label>
            <select id="calc-th-unit" name="th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mrad')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Output beam diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'type' => 'galileo', 'f1' => 25, 'f1-unit' => 'mm', 'f2' => 100, 'f2-unit' => 'mm', 'D' => 2, 'D-unit' => 'mm', 'th' => 1, 'th-unit' => 'mrad'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'M' => ['label' => 'Magnification'],
            'th' => ['label' => 'Output divergence'],
            'sep' => ['label' => 'Lens separation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
