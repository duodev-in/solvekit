<x-calc.page
    title="Helium Balloons Calculator - SolveKit"
    description="Free helium balloons calculator: the lift of a helium balloon from its size, temperature and altitude, and how many balloons lift a given weight."
    lede="Work out how much a helium balloon can lift."
    about="A balloon lifts the weight of the air it displaces minus the weight of its helium: lift = volume × (air density − helium density), less the balloon's own weight. Densities come from the ideal gas law at your temperature and altitude (standard atmosphere). Cold air and pure helium lift more; party-grade helium is often blended."
    :calc="['engine' => 'ev-fun', 'tool' => 'helium', 'fields' => ['size', 'balloon', 'purity', 'temperature', 'altitude', 'payload'], 'unitFields' => ['size' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'temperature' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'altitude' => collect(config('units.length'))->only(['ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the balloon size', 'text' => 'Inflated diameter and weight.'],
        ['name' => 'Enter conditions', 'text' => 'Temperature, altitude, purity.'],
    ]"
    :faqs="[
        ['question' => 'How much can an 11 inch helium balloon lift?', 'answer' => 'About 9 g net at 20 °C at sea level, for a 3 g balloon.'],
        ['question' => 'How many balloons to lift 50 g?', 'answer' => 'About 6 of 11 inches.'],
        ['question' => 'Why do balloons sink overnight?', 'answer' => 'Helium escapes through latex.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="size" label="Inflated diameter" value="11" min="0" placeholder="Inflated diameter">
            <label for="calc-size-unit" class="sr-only">Inflated diameter unit</label>
            <select id="calc-size-unit" name="size-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="balloon" label="Balloon weight" value="3" min="0" step="0.1" suffix="g" />
        <x-calc.field name="purity" label="Helium purity" value="100" min="50" max="100" step="1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="temperature" label="Air temperature" value="20" min="0" placeholder="Air temperature">
            <label for="calc-temperature-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="payload" label="Weight to lift (optional)" value="50" min="0" suffix="g" />
    </div>

    <x-calc.result label="Net lift per balloon" />

    <x-calc.options :decimals="false" :examples="[
        '11 in latex, 50 g' => ['size' => 11, 'size-unit' => 'in', 'balloon' => 3, 'purity' => 100, 'temperature' => 20, 'temperature-unit' => 'c', 'altitude' => 0, 'altitude-unit' => 'm', 'payload' => 50],
        'Big 36 in balloon' => ['size' => 36, 'size-unit' => 'in', 'balloon' => 50, 'purity' => 100, 'temperature' => 20, 'temperature-unit' => 'c', 'altitude' => 0, 'altitude-unit' => 'm', 'payload' => 500],
        'Party blend in Denver' => ['size' => 11, 'size-unit' => 'in', 'balloon' => 3, 'purity' => 90, 'temperature' => 72, 'temperature-unit' => 'f', 'altitude' => 5280, 'altitude-unit' => 'ft', 'payload' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'needed' => ['label' => 'Balloons needed'],
            'gas' => ['label' => 'Helium'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lift = V × (ρ air − ρ He) − balloon</li>
            <li>ρ = p ÷ (R T)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
