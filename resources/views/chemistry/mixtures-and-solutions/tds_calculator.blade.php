<x-calc.page
    title="TDS Calculator - SolveKit"
    description="Free TDS calculator: total dissolved solids in mg/L from the dried residue of a filtered water sample."
    lede="Work out total dissolved solids from a dried sample."
    about="Total dissolved solids is the mass left when a filtered water sample is evaporated and dried at 180 °C, divided by the sample volume (Standard Methods 2540 C). TDS meters estimate it from conductivity with a factor of about 0.55 to 0.7, which depends on the water, so that estimate is not used here."
    :calc="['engine' => 'chem-mix', 'tool' => 'tds', 'fields' => ['residue', 'sample'], 'unitFields' => ['residue' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'sample' => collect(config('units.volume'))->only(['ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Filter and dry the sample', 'text' => 'Evaporate a known volume and dry at 180 °C.'],
        ['name' => 'Enter the residue and volume', 'text' => 'Mass gained by the dish, and the sample volume.'],
    ]"
    :faqs="[
        ['question' => 'What is a good TDS for drinking water?', 'answer' => 'The US EPA secondary guideline is 500 mg/L.'],
        ['question' => 'Is TDS the same as hardness?', 'answer' => 'No: hardness is only calcium and magnesium; TDS is everything dissolved.'],
        ['question' => 'Why not use a TDS meter?', 'answer' => 'Meters convert conductivity with an assumed factor, so they only estimate TDS.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="residue" label="Dried residue mass" value="50" min="0" placeholder="Dried residue mass">
            <label for="calc-residue-unit" class="sr-only">Dried residue mass unit</label>
            <select id="calc-residue-unit" name="residue-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sample" label="Sample volume" value="100" min="0" placeholder="Sample volume">
            <label for="calc-sample-unit" class="sr-only">Sample volume unit</label>
            <select id="calc-sample-unit" name="sample-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Total dissolved solids" />

    <x-calc.options :examples="[
        '50 mg from 100 mL' => ['residue' => 50, 'residue-unit' => 'mg', 'sample' => 100, 'sample-unit' => 'ml'],
        'Sea water' => ['residue' => 3.5, 'residue-unit' => 'g', 'sample' => 100, 'sample-unit' => 'ml'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ppm' => ['label' => 'In ppm'],
            'class' => ['label' => 'Water type'],
            'grams' => ['label' => 'In g/L'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TDS (mg/L) = residue (mg) ÷ sample (L)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
