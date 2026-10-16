<x-calc.page
    title="OD600 to Cell Concentration Calculator - SolveKit"
    description="Free OD600 calculator: estimate cells per mL from optical density at 600 nm, with an editable cells-per-OD factor."
    lede="Estimate bacterial cells per mL from an OD600 reading."
    about="For E. coli an OD600 of 1.0 is roughly 8 × 10⁸ cells per mL, but the factor depends on the organism, cell size and spectrophotometer. Calibrate it against plate counts for accurate work."
    :calc="['engine' => 'lab', 'tool' => 'od600', 'fields' => ['od', 'factor', 'volume'], 'unitFields' => ['volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Read the OD600', 'text' => 'Blank against clean medium; dilute if above 1.'],
        ['name' => 'Check the factor', 'text' => 'Use 8 × 10⁸ for E. coli or your own calibration.'],
    ]"
    :faqs="[
        ['question' => 'How many cells is OD 1 of E. coli?', 'answer' => 'About 8 × 10⁸ cells per mL; published values range from about 5 × 10⁸ to 1 × 10⁹.'],
        ['question' => 'Why dilute above OD 1?', 'answer' => 'The reading stops being proportional to cell number at high density.'],
        ['question' => 'Does OD600 count dead cells?', 'answer' => 'Yes, it measures light scattering by all cells and debris.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="od" label="OD600 reading" value="0.5" min="0" />
        <x-calc.field name="factor" label="Cells per mL at OD 1.0" value="800000000" min="0" help="E. coli ≈ 8 × 10⁸; yeast ≈ 3 × 10⁷" />
    </div>

    <x-calc.field name="volume" label="Culture volume (optional)" value="50" min="0" placeholder="Culture volume (optional)">
        <label for="calc-volume-unit" class="sr-only">Culture volume (optional) unit</label>
        <select id="calc-volume-unit" name="volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Cell concentration" />

    <x-calc.options :examples="[
        'E. coli OD 0.5' => ['od' => 0.5, 'factor' => 800000000],
        'Yeast OD 1.2' => ['od' => 1.2, 'factor' => 30000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_ul' => ['label' => 'Cells per µL'],
            'total' => ['label' => 'Cells in the culture'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cells/mL = OD600 × cells per OD unit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
