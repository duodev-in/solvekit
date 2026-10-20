<x-calc.page
    title="Magnetic Dipole Moment Calculator - SolveKit"
    description="Free magnetic dipole moment calculator: μ = NIA of a coil, with torque in a field."
    lede="Find a coil’s magnetic moment."
    about="A current loop behaves like a small magnet with moment NIA. In a field it feels torque μB sin θ."
    :calc="['engine' => 'ph-em', 'tool' => 'magnetic_moment', 'fields' => ['N', 'I', 'shape', 'r', 'w', 'h', 'B'], 'unitFields' => ['I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is μ for 100 turns of 5 cm radius at 2 A?', 'answer' => '1.5708 A·m² A·m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="N" label="Turns" value="100" min="1" step="any" />
        <x-calc.field name="I" label="Current" value="2" placeholder="Current">
            <label for="calc-I-unit" class="sr-only">Current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="shape" label="Loop shape" :options="['circle' => 'Circle', 'rect' => 'Rectangle']" selected="circle" />
        <div data-show-when="shape:circle">
            <x-calc.field name="r" label="Loop radius" value="5" placeholder="Loop radius">
                <label for="calc-r-unit" class="sr-only">Loop radius unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rect">
            <x-calc.field name="w" label="Width" value="5" placeholder="Width">
                <label for="calc-w-unit" class="sr-only">Width unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rect">
            <x-calc.field name="h" label="Height" value="10" placeholder="Height">
                <label for="calc-h-unit" class="sr-only">Height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="B" label="External field (optional)" value="50" placeholder="External field (optional)">
            <label for="calc-B-unit" class="sr-only">External field (optional) unit</label>
            <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mt')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Magnetic dipole moment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['N' => 100, 'I' => 2, 'I-unit' => 'a', 'shape' => 'circle', 'r' => 5, 'r-unit' => 'cm', 'w' => 5, 'w-unit' => 'cm', 'h' => 10, 'h-unit' => 'cm', 'B' => 50, 'B-unit' => 'mt'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'torque' => ['label' => 'Maximum torque in that field'],
            'centre' => ['label' => 'Field at the centre of a circular coil'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
