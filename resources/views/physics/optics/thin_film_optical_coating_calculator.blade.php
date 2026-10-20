<x-calc.page
    title="Thin-Film Optical Coating Calculator - SolveKit"
    description="Free thin-film coating calculator: reflectance of a single-layer coating across the visible spectrum."
    lede="Find the reflectance of a coating."
    about="A thin film reflects light from both of its surfaces; the two reflections interfere. A quarter-wave layer of index √(n₀n_s) cancels reflection at one wavelength. Magnesium fluoride on glass cuts 4% reflection to about 1.3%."
    :calc="['engine' => 'ph-wave', 'tool' => 'thin_film', 'fields' => ['n1', 't', 'ns', 'n0', 'lambda'], 'unitFields' => ['t' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a quarter-wave MgF₂ layer do at 550 nm?', 'answer' => 'Reflectance 1.2601%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n1" label="Film index" value="1.38" min="1" step="any" />
        <x-calc.field name="t" label="Film thickness" value="99.64" placeholder="Film thickness">
            <label for="calc-t-unit" class="sr-only">Film thickness unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ns" label="Substrate index" value="1.52" min="1" step="any" />
        <x-calc.field name="n0" label="Surrounding medium index" value="1" min="1" step="any" />
        <x-calc.field name="lambda" label="Wavelength" value="550" placeholder="Wavelength">
            <label for="calc-lambda-unit" class="sr-only">Wavelength unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Reflectance at that wavelength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n1' => 1.38, 't' => 99.64, 't-unit' => 'nm', 'ns' => 1.52, 'n0' => 1, 'lambda' => 550, 'lambda-unit' => 'nm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Reflectance across the visible spectrum" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'bare' => ['label' => 'Bare substrate reflectance'],
            'qw' => ['label' => 'Quarter-wave thickness for this wavelength'],
            'ideal' => ['label' => 'Ideal film index √(n₀ n_s)'],
            'min' => ['label' => 'Lowest reflectance in 380–780 nm'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
