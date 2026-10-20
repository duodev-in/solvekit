<x-calc.page
    title="Atwood Machine Calculator - SolveKit"
    description="Free Atwood machine calculator: acceleration and rope tensions for two masses over a pulley, including pulley inertia."
    lede="Solve an Atwood machine."
    about="Two masses on a rope over a pulley accelerate at (m₁ − m₂)g ÷ (m₁ + m₂ + I/r²). With a light pulley I is zero."
    :calc="['engine' => 'ph-mech', 'tool' => 'atwood', 'fields' => ['m1', 'm2', 'I', 'r', 'd', 'out'], 'unitFields' => ['m1' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'm2' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'I' => collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'moment_of_inertia', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the acceleration with 3 kg and 2 kg?', 'answer' => '1.96133 m/s².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m1" label="Heavier mass m₁" value="3" min="0" placeholder="Heavier mass m₁">
            <label for="calc-m1-unit" class="sr-only">Heavier mass m₁ unit</label>
            <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m2" label="Lighter mass m₂" value="2" min="0" placeholder="Lighter mass m₂">
            <label for="calc-m2-unit" class="sr-only">Lighter mass m₂ unit</label>
            <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Pulley moment of inertia (0 for ideal)" value="0" min="0" placeholder="Pulley moment of inertia (0 for ideal)">
            <label for="calc-I-unit" class="sr-only">Pulley moment of inertia (0 for ideal) unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="r" label="Pulley radius" value="10" placeholder="Pulley radius">
            <label for="calc-r-unit" class="sr-only">Pulley radius unit</label>
            <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance moved" value="1" placeholder="Distance moved">
            <label for="calc-d-unit" class="sr-only">Distance moved unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Acceleration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'm1' => 3, 'm1-unit' => 'kg', 'm2' => 2, 'm2-unit' => 'kg', 'I' => 0, 'I-unit' => 'kgm2', 'r' => 10, 'r-unit' => 'cm', 'd' => 1, 'd-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'T1' => ['label' => 'Tension on the m₁ side'],
            'T2' => ['label' => 'Tension on the m₂ side'],
            'v' => ['label' => 'Speed after that distance'],
            't' => ['label' => 'Time to move it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
