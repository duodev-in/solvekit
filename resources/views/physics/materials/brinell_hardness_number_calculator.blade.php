<x-calc.page
    title="Brinell Hardness Number Calculator - SolveKit"
    description="Free Brinell hardness calculator: HBW from test load, ball diameter and indentation diameter, with a tensile strength estimate."
    lede="Find the Brinell hardness number."
    about="A hard ball pressed into the surface leaves a round dent. Brinell hardness is the load divided by the curved area of the dent. For steels, tensile strength in MPa is roughly 3.45 × HB."
    :calc="['engine' => 'ph-mat', 'tool' => 'brinell', 'fields' => ['F', 'Db', 'd'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'Db' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is HB for a 4 mm dent from 3,000 kgf on a 10 mm ball?', 'answer' => '228.8 HBW.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="F" label="Test load" value="3000" placeholder="Test load">
            <label for="calc-F-unit" class="sr-only">Test load unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Db" label="Ball diameter" value="10" placeholder="Ball diameter">
            <label for="calc-Db-unit" class="sr-only">Ball diameter unit</label>
            <select id="calc-Db-unit" name="Db-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Mean indentation diameter" value="4" placeholder="Mean indentation diameter">
            <label for="calc-d-unit" class="sr-only">Mean indentation diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Brinell hardness" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['F' => 3000, 'F-unit' => 'kgf', 'Db' => 10, 'Db-unit' => 'mm', 'd' => 4, 'd-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'uts' => ['label' => 'Approximate tensile strength (steels)'],
            'ratio' => ['label' => 'Indentation ratio d/D'],
            'valid' => ['label' => 'Validity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
