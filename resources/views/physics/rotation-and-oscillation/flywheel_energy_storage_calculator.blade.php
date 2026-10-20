<x-calc.page
    title="Flywheel Energy Storage Calculator - SolveKit"
    description="Free flywheel energy calculator: stored energy ½Iω² for disc and rim flywheels, in kJ and kWh."
    lede="Find the energy a flywheel stores."
    about="A flywheel stores ½Iω². Energy grows with the square of speed, so fast thin rims store the most; rim stress sets the limit."
    :calc="['engine' => 'ph-mech', 'tool' => 'flywheel', 'fields' => ['shape', 'm', 'r', 'ri', 'w', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'ri' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all()], 'data' => ['units' => collect(config('units'))->only(['angular_speed', 'energy', 'force', 'length', 'mass', 'moment_of_inertia', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much does a 100 kg, 0.5 m disc at 3,000 rpm store?', 'answer' => '616.85 kJ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Flywheel" :options="['disc' => 'Solid disc', 'rim' => 'Thin rim (ring)', 'thick' => 'Thick ring']" selected="disc" />
        <x-calc.field name="m" label="Mass" value="100" min="0" placeholder="Mass">
            <label for="calc-m-unit" class="sr-only">Mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="r" label="Outer radius" value="0.5" placeholder="Outer radius">
            <label for="calc-r-unit" class="sr-only">Outer radius unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="shape:thick">
            <x-calc.field name="ri" label="Inner radius" value="0.3" placeholder="Inner radius">
                <label for="calc-ri-unit" class="sr-only">Inner radius unit</label>
                <select id="calc-ri-unit" name="ri-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="w" label="Speed" value="3000" placeholder="Speed">
            <label for="calc-w-unit" class="sr-only">Speed unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="kj" />
    </div>

    <x-calc.result label="Stored energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kj', 'shape' => 'disc', 'm' => 100, 'm-unit' => 'kg', 'r' => 0.5, 'r-unit' => 'm', 'ri' => 0.3, 'ri-unit' => 'm', 'w' => 3000, 'w-unit' => 'rpm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kwh' => ['label' => 'In kWh'],
            'I' => ['label' => 'Moment of inertia'],
            'rim' => ['label' => 'Rim speed'],
            'density' => ['label' => 'Energy per kilogram'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
