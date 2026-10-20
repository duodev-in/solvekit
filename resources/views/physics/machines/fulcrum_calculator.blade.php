<x-calc.page
    title="Fulcrum Calculator - SolveKit"
    description="Free fulcrum calculator: where to put the fulcrum to balance a load with a given effort."
    lede="Find where the fulcrum goes."
    about="A lever balances when load × its distance equals effort × its distance from the fulcrum."
    :calc="['engine' => 'ph-mach', 'tool' => 'fulcrum', 'fields' => ['L', 'W', 'F', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'W' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Where does the fulcrum go to lift 600 N with 200 N on a 2 m bar?', 'answer' => '0.5 m from the load.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="Bar length" value="2" placeholder="Bar length">
            <label for="calc-L-unit" class="sr-only">Bar length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="W" label="Load at one end" value="600" placeholder="Load at one end">
            <label for="calc-W-unit" class="sr-only">Load at one end unit</label>
            <select id="calc-W-unit" name="W-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="F" label="Effort at the other end" value="200" placeholder="Effort at the other end">
            <label for="calc-F-unit" class="sr-only">Effort at the other end unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Fulcrum distance from the load" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'L' => 2, 'L-unit' => 'm', 'W' => 600, 'W-unit' => 'n', 'F' => 200, 'F-unit' => 'n'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'other' => ['label' => 'Distance from the effort'],
            'ma' => ['label' => 'Mechanical advantage'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
