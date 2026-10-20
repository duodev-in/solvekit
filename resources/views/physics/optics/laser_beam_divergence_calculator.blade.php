<x-calc.page
    title="Laser Beam Divergence Calculator - SolveKit"
    description="Free laser beam divergence calculator: divergence from waist and wavelength or from two measured diameters."
    lede="Find how fast a laser beam spreads."
    about="A Gaussian beam spreads with half-angle θ = M²λ/(πw₀) far from its waist. A smaller waist diverges faster. The Rayleigh range is the distance over which the beam stays roughly collimated."
    :calc="['engine' => 'ph-wave', 'tool' => 'laser_divergence', 'fields' => ['mode', 'w0', 'lambda', 'M2', 'd1', 'd2', 'L', 'out'], 'unitFields' => ['w0' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the divergence of a 1064 nm beam with a 0.5 mm waist?', 'answer' => '0.677363 mrad.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['waist' => 'The waist and wavelength', 'two' => 'Two beam diameters and their spacing']" selected="waist" />
        <div data-show-when="mode:waist">
            <x-calc.field name="w0" label="Waist radius w₀" value="0.5" placeholder="Waist radius w₀">
                <label for="calc-w0-unit" class="sr-only">Waist radius w₀ unit</label>
                <select id="calc-w0-unit" name="w0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:waist">
            <x-calc.field name="lambda" label="Wavelength" value="1064" placeholder="Wavelength">
                <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
                <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:waist">
            <x-calc.field name="M2" label="Beam quality M²" value="1" min="1" step="any" />
        </div>
        <div data-show-when="mode:two">
            <x-calc.field name="d1" label="Diameter at the first point" value="2" placeholder="Diameter at the first point">
                <label for="calc-d1-unit" class="sr-only">Diameter at the first point unit</label>
                <select id="calc-d1-unit" name="d1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:two">
            <x-calc.field name="d2" label="Diameter at the second point" value="6" placeholder="Diameter at the second point">
                <label for="calc-d2-unit" class="sr-only">Diameter at the second point unit</label>
                <select id="calc-d2-unit" name="d2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:two">
            <x-calc.field name="L" label="Distance between them" value="5" placeholder="Distance between them">
                <label for="calc-L-unit" class="sr-only">Distance between them unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="mrad" />
    </div>

    <x-calc.result label="Half-angle divergence" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mrad', 'mode' => 'waist', 'w0' => 0.5, 'w0-unit' => 'mm', 'lambda' => 1064, 'lambda-unit' => 'nm', 'M2' => 1, 'd1' => 2, 'd1-unit' => 'mm', 'd2' => 6, 'd2-unit' => 'mm', 'L' => 5, 'L-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'full' => ['label' => 'Full-angle divergence'],
            'zr' => ['label' => 'Rayleigh range'],
            'at100' => ['label' => 'Beam diameter at 100 m'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
