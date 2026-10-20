<x-calc.page
    title="Linear Actuator Force Calculator - SolveKit"
    description="Free linear actuator force calculator: force and stroke needed to open a hinged lid or hatch."
    lede="Size an actuator for a hinged lid."
    about="A lid’s weight makes a moment about its hinge that is largest when closed. The actuator force depends on how far its line passes from the hinge, which changes as the lid opens."
    :calc="['engine' => 'ph-mach', 'tool' => 'linear_actuator', 'fields' => ['m', 'c', 'a', 'bx', 'by', 'open', 'n', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'c' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'a' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'bx' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'by' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'open' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force does the example lid need?', 'answer' => '657.01 N per actuator.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Lid or hatch mass" value="20" min="0" placeholder="Lid or hatch mass">
            <label for="calc-m-unit" class="sr-only">Lid or hatch mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="c" label="Hinge to the lid’s centre of mass" value="40" placeholder="Hinge to the lid’s centre of mass">
            <label for="calc-c-unit" class="sr-only">Hinge to the lid’s centre of mass unit</label>
            <select id="calc-c-unit" name="c-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="a" label="Hinge to the actuator mount on the lid" value="15" placeholder="Hinge to the actuator mount on the lid">
            <label for="calc-a-unit" class="sr-only">Hinge to the actuator mount on the lid unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bx" label="Base mount: distance along the lid from the hinge" value="5" placeholder="Base mount: distance along the lid from the hinge">
            <label for="calc-bx-unit" class="sr-only">Base mount: distance along the lid from the hinge unit</label>
            <select id="calc-bx-unit" name="bx-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="by" label="Base mount: distance below the hinge" value="20" placeholder="Base mount: distance below the hinge">
            <label for="calc-by-unit" class="sr-only">Base mount: distance below the hinge unit</label>
            <select id="calc-by-unit" name="by-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="open" label="Fully open angle" value="80" placeholder="Fully open angle">
            <label for="calc-open-unit" class="sr-only">Fully open angle unit</label>
            <select id="calc-open-unit" name="open-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Number of actuators" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Maximum force per actuator" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'm' => 20, 'm-unit' => 'kg', 'c' => 40, 'c-unit' => 'cm', 'a' => 15, 'a-unit' => 'cm', 'bx' => 5, 'bx-unit' => 'cm', 'by' => 20, 'by-unit' => 'cm', 'open' => 80, 'open-unit' => 'deg', 'n' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Force needed as the lid opens" name="force" />
        <x-calc.rows heading="Details" :rows="[
            'closed' => ['label' => 'Force with the lid closed'],
            'stroke' => ['label' => 'Stroke needed'],
            'lengths' => ['label' => 'Installed length (closed → open)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
