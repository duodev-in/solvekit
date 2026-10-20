<x-calc.page
    title="Lens Maker Equation Calculator - SolveKit"
    description="Free lensmaker's equation calculator: focal length of a thick or thin lens from its radii, thickness and index."
    lede="Find a lens’s focal length from its shape."
    about="The lensmaker’s equation links a lens’s focal length to its refractive index and surface curvatures. A thick-lens term corrects for centre thickness. Use R = 0 for a flat surface."
    :calc="['engine' => 'ph-wave', 'tool' => 'lens_maker', 'fields' => ['n', 'R1', 'R2', 'd', 'nm', 'out'], 'unitFields' => ['R1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'R2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is f for an equiconvex BK7 lens with R = 100 mm?', 'answer' => '97.5804 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Refractive index of the lens" value="1.5168" min="1" step="any" />
        <x-calc.field name="R1" label="Radius of the first surface R₁" value="100" placeholder="Radius of the first surface R₁">
            <label for="calc-R1-unit" class="sr-only">Radius of the first surface R₁ unit</label>
            <select id="calc-R1-unit" name="R1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="R2" label="Radius of the second surface R₂" value="-100" placeholder="Radius of the second surface R₂">
            <label for="calc-R2-unit" class="sr-only">Radius of the second surface R₂ unit</label>
            <select id="calc-R2-unit" name="R2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Centre thickness" value="5" placeholder="Centre thickness">
            <label for="calc-d-unit" class="sr-only">Centre thickness unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="nm" label="Index of the surrounding medium" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Focal length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'n' => 1.5168, 'R1' => 100, 'R1-unit' => 'mm', 'R2' => -100, 'R2-unit' => 'mm', 'd' => 5, 'd-unit' => 'mm', 'nm' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'P' => ['label' => 'Power'],
            'thin' => ['label' => 'Thin-lens value (thickness ignored)'],
            'kind' => ['label' => 'Lens type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
