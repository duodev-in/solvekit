<x-calc.page
    title="Laser Beam Spot Size Calculator - SolveKit"
    description="Free laser spot size calculator: focused spot diameter and depth of focus from wavelength, beam size and focal length."
    lede="Find the focused spot size."
    about="A lens focuses a Gaussian beam to a spot of diameter 4M²λf/(πD). A larger beam on the lens or a shorter focal length gives a smaller spot, but less depth of focus."
    :calc="['engine' => 'ph-wave', 'tool' => 'spot_size', 'fields' => ['lambda', 'D', 'f', 'M2', 'out'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What spot does a 100 mm lens make from a 5 mm 1064 nm beam?', 'answer' => '27.0945 µm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lambda" label="Wavelength" value="1064" placeholder="Wavelength">
            <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="D" label="Beam diameter at the lens" value="5" placeholder="Beam diameter at the lens">
            <label for="calc-D-unit" class="sr-only">Beam diameter at the lens unit</label>
            <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Focal length" value="100" placeholder="Focal length">
            <label for="calc-f-unit" class="sr-only">Focal length unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="M2" label="Beam quality M²" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="um" />
    </div>

    <x-calc.result label="Focused spot diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'um', 'lambda' => 1064, 'lambda-unit' => 'nm', 'D' => 5, 'D-unit' => 'mm', 'f' => 100, 'f-unit' => 'mm', 'M2' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dof' => ['label' => 'Depth of focus (2 × Rayleigh range)'],
            'na' => ['label' => 'Focusing NA (approx.)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
