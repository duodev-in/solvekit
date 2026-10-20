<x-calc.page
    title="Binoculars Range Calculator - SolveKit"
    description="Free binoculars calculator: exit pupil, twilight factor, field width and the smallest detail you can see at a distance."
    lede="Compare binoculars and what they show."
    about="Binoculars are named magnification × objective size, like 8×42. The exit pupil (D ÷ M) sets brightness in dim light; the twilight factor √(M·D) estimates how much detail they show at dusk; magnification sets how small a detail you can pick out at a distance."
    :calc="['engine' => 'ph-wave', 'tool' => 'binoculars', 'fields' => ['M', 'D', 'fov', 'd', 'out'], 'unitFields' => ['D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'fov' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the exit pupil of 8×42 binoculars?', 'answer' => '5.25 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M" label="Magnification" value="8" min="0" step="any" />
        <x-calc.field name="D" label="Objective diameter" value="42" placeholder="Objective diameter">
            <label for="calc-D-unit" class="sr-only">Objective diameter unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fov" label="Real field of view (0 if unknown)" value="7" placeholder="Real field of view (0 if unknown)">
            <label for="calc-fov-unit" class="sr-only">Real field of view (0 if unknown) unit</label>
            <select id="calc-fov-unit" name="fov-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Viewing distance" value="1000" placeholder="Viewing distance">
            <label for="calc-d-unit" class="sr-only">Viewing distance unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Exit pupil" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'M' => 8, 'D' => 42, 'D-unit' => 'mm', 'fov' => 7, 'fov-unit' => 'deg', 'd' => 1000, 'd-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'twilight' => ['label' => 'Twilight factor √(M × D)'],
            'bright' => ['label' => 'Relative brightness (exit pupil²)'],
            'field' => ['label' => 'Width of view at that distance'],
            'detail' => ['label' => 'Smallest detail visible at that distance'],
            'same' => ['label' => 'Seen as large as with the naked eye at'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
