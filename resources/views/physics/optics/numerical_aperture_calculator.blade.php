<x-calc.page
    title="Numerical Aperture Calculator - SolveKit"
    description="Free numerical aperture calculator: NA, acceptance angle and V-number of an optical fibre."
    lede="Find a fibre’s numerical aperture."
    about="A fibre accepts light within a cone set by its core and cladding indices: NA = √(n₁² − n₂²). The V-number tells whether it guides one mode or many."
    :calc="['engine' => 'ph-wave', 'tool' => 'numerical_aperture', 'fields' => ['n1', 'n2', 'n0', 'a', 'lambda'], 'unitFields' => ['a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the NA of the example single-mode fibre?', 'answer' => '0.12464.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n1" label="Core index" value="1.4682" min="1" step="any" />
        <x-calc.field name="n2" label="Cladding index" value="1.4629" min="1" step="any" />
        <x-calc.field name="n0" label="Outside medium index" value="1" min="1" step="any" />
        <x-calc.field name="a" label="Core diameter (optional)" value="8.2" placeholder="Core diameter (optional)">
            <label for="calc-a-unit" class="sr-only">Core diameter (optional) unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'um')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="lambda" label="Wavelength (optional)" value="1310" placeholder="Wavelength (optional)">
            <label for="calc-lambda-unit" class="sr-only">Wavelength (optional) unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Numerical aperture" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n1' => 1.4682, 'n2' => 1.4629, 'n0' => 1, 'a' => 8.2, 'a-unit' => 'um', 'lambda' => 1310, 'lambda-unit' => 'nm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'half' => ['label' => 'Acceptance half-angle'],
            'full' => ['label' => 'Acceptance cone (full angle)'],
            'V' => ['label' => 'V-number'],
            'modes' => ['label' => 'Guiding'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
