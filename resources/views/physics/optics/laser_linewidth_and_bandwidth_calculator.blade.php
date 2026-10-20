<x-calc.page
    title="Laser Linewidth and Bandwidth Calculator - SolveKit"
    description="Free laser linewidth calculator: convert linewidth between nm, pm, GHz, MHz and cm⁻¹, with coherence length."
    lede="Convert laser linewidth units."
    about="Spectral width can be quoted in wavelength or frequency. They are linked by Δν = cΔλ/λ², so the same 0.1 nm means very different bandwidths at 400 nm and 1550 nm."
    :calc="['engine' => 'ph-wave', 'tool' => 'linewidth', 'fields' => ['value', 'unit', 'lambda'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.1 nm at 1550 nm in GHz?', 'answer' => '12.4784 GHz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Linewidth" value="0.1" min="0" step="any" />
        <x-calc.select name="unit" label="Given in" :options="['nm' => 'nm', 'pm' => 'pm', 'ghz' => 'GHz', 'mhz' => 'MHz', 'khz' => 'kHz', 'cm' => 'cm⁻¹']" selected="nm" />
        <x-calc.field name="lambda" label="Centre wavelength" value="1550" placeholder="Centre wavelength">
            <label for="calc-lambda-unit" class="sr-only">Centre wavelength unit</label>
            <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Linewidth in frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => 0.1, 'unit' => 'nm', 'lambda' => 1550, 'lambda-unit' => 'nm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'nm' => ['label' => 'In nanometres'],
            'pm' => ['label' => 'In picometres'],
            'hz' => ['label' => 'In hertz'],
            'cm' => ['label' => 'In wavenumbers'],
            'coh' => ['label' => 'Coherence length (≈ c ÷ πΔν, Lorentzian)'],
            'q' => ['label' => 'Quality factor ν ÷ Δν'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
