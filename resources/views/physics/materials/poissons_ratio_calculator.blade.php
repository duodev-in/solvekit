<x-calc.page
    title="Poisson's Ratio Calculator - SolveKit"
    description="Free Poisson's ratio calculator: ν from lateral and axial strain or measured dimensions."
    lede="Find Poisson's ratio."
    about="Stretch a bar and it gets thinner. Poisson's ratio is the lateral strain divided by the axial strain, with a minus sign. It is about 0.3 for metals and close to 0.5 for rubber."
    :calc="['engine' => 'ph-mat', 'tool' => 'poisson', 'fields' => ['mode', 'elat', 'eax', 'L0', 'L1', 'd0', 'd1'], 'unitFields' => ['L0' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd0' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is ν for the example test?', 'answer' => '0.3.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['strain' => 'The two strains', 'dims' => 'Original and deformed dimensions']" selected="dims" />
        <div data-show-when="mode:strain">
            <x-calc.field name="elat" label="Lateral strain" value="-0.0003" step="any" />
        </div>
        <div data-show-when="mode:strain">
            <x-calc.field name="eax" label="Axial strain" value="0.001" step="any" />
        </div>
        <div data-show-when="mode:dims">
            <x-calc.field name="L0" label="Original length" value="100" placeholder="Original length">
                <label for="calc-L0-unit" class="sr-only">Original length unit</label>
                <select id="calc-L0-unit" name="L0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:dims">
            <x-calc.field name="L1" label="Stretched length" value="100.1" placeholder="Stretched length">
                <label for="calc-L1-unit" class="sr-only">Stretched length unit</label>
                <select id="calc-L1-unit" name="L1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:dims">
            <x-calc.field name="d0" label="Original width" value="10" placeholder="Original width">
                <label for="calc-d0-unit" class="sr-only">Original width unit</label>
                <select id="calc-d0-unit" name="d0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:dims">
            <x-calc.field name="d1" label="New width" value="9.997" placeholder="New width">
                <label for="calc-d1-unit" class="sr-only">New width unit</label>
                <select id="calc-d1-unit" name="d1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Poisson's ratio ν" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'dims', 'elat' => -0.0003, 'eax' => 0.001, 'L0' => 100, 'L0-unit' => 'mm', 'L1' => 100.1, 'L1-unit' => 'mm', 'd0' => 10, 'd0-unit' => 'mm', 'd1' => 9.997, 'd1-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'strains' => ['label' => 'Strains'],
            'typical' => ['label' => 'Typical values'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
