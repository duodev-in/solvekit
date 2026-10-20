<x-calc.page
    title="Spherical Capacitor Calculator - SolveKit"
    description="Free spherical capacitor calculator: capacitance of concentric spheres with a dielectric."
    lede="Find a spherical capacitor’s capacitance."
    about="Two concentric spheres form a capacitor of 4πεab/(b − a)."
    :calc="['engine' => 'ph-elec', 'tool' => 'spherical_capacitor', 'fields' => ['a', 'b', 'er', 'out'], 'unitFields' => ['a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is C for radii 5 and 6 cm in air?', 'answer' => '33.3795 pF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Inner radius" value="5" placeholder="Inner radius">
            <label for="calc-a-unit" class="sr-only">Inner radius unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="b" label="Outer radius" value="6" placeholder="Outer radius">
            <label for="calc-b-unit" class="sr-only">Outer radius unit</label>
            <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="er" label="Relative permittivity" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['f' => 'F', 'mf' => 'mF', 'uf' => 'µF', 'nf' => 'nF', 'pf' => 'pF']" selected="pf" />
    </div>

    <x-calc.result label="Capacitance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'pf', 'a' => 5, 'a-unit' => 'cm', 'b' => 6, 'b-unit' => 'cm', 'er' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'isolated' => ['label' => 'Isolated inner sphere alone'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
