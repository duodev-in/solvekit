<x-calc.page
    title="Telescope Magnification Calculator - SolveKit"
    description="Free telescope magnification calculator: magnification, exit pupil, focal ratio and useful magnification range."
    lede="Find a telescope’s magnification."
    about="Magnification is the telescope focal length divided by the eyepiece focal length. Above about twice the aperture in millimetres, images only get dimmer, not sharper."
    :calc="['engine' => 'ph-wave', 'tool' => 'telescope_mag', 'fields' => ['F', 'f', 'D', 'barlow'], 'unitFields' => ['F' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What magnification does a 25 mm eyepiece give on a 1,000 mm telescope?', 'answer' => '40×.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="F" label="Telescope focal length" value="1000" placeholder="Telescope focal length">
            <label for="calc-F-unit" class="sr-only">Telescope focal length unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Eyepiece focal length" value="25" placeholder="Eyepiece focal length">
            <label for="calc-f-unit" class="sr-only">Eyepiece focal length unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D" label="Aperture" value="100" placeholder="Aperture">
            <label for="calc-D-unit" class="sr-only">Aperture unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="barlow" label="Barlow factor" value="1" min="1" step="any" />
    </div>

    <x-calc.result label="Magnification" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['F' => 1000, 'F-unit' => 'mm', 'f' => 25, 'f-unit' => 'mm', 'D' => 100, 'D-unit' => 'mm', 'barlow' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ep' => ['label' => 'Exit pupil'],
            'ratio' => ['label' => 'Focal ratio'],
            'maxM' => ['label' => 'Highest useful magnification (≈ 2 × D in mm)'],
            'minM' => ['label' => 'Lowest useful magnification (7 mm exit pupil)'],
            'res' => ['label' => 'Resolving power (Dawes)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
