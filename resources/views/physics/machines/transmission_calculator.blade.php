<x-calc.page
    title="Transmission Calculator - SolveKit"
    description="Free transmission calculator: road speed in every gear from gear ratios, final drive, tyre size and rpm."
    lede="Find speed in each gear."
    about="Road speed is engine speed divided by the overall ratio, times the tyre’s circumference."
    :calc="['engine' => 'ph-mach', 'tool' => 'transmission', 'fields' => ['gears', 'final', 'tyre', 'rpm', 'out'], 'unitFields' => ['tyre' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is the example car in top gear at 2,500 rpm?', 'answer' => '168.743 km/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="gears" label="Gear ratios (first to top, comma or line separated)" value="3.36, 2.07, 1.43, 1.00, 0.84, 0.56" rows="3" />
        <x-calc.field name="final" label="Final drive ratio" value="3.42" min="0" step="any" />
        <x-calc.field name="tyre" label="Tyre diameter" value="27" placeholder="Tyre diameter">
            <label for="calc-tyre-unit" class="sr-only">Tyre diameter unit</label>
            <select id="calc-tyre-unit" name="tyre-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rpm" label="Engine speed (rpm)" value="2500" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
    </div>

    <x-calc.result label="Speed in top gear" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kmh', 'gears' => '3.36, 2.07, 1.43, 1.00, 0.84, 0.56', 'final' => 3.42, 'tyre' => 27, 'tyre-unit' => 'in', 'rpm' => 2500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'drop' => ['label' => 'rpm after each upshift'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Speed in each gear" name="gears" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
