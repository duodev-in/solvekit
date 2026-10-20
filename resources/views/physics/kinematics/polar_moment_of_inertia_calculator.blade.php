<x-calc.page
    title="Polar Moment of Inertia Calculator - SolveKit"
    description="Free polar moment of inertia calculator: J for solid and hollow shafts and rectangles, with the torsional shear stress."
    lede="Find J and the shear stress of a shaft in torsion."
    about="The polar moment of inertia J measures how a cross-section resists twisting. For a round shaft J = πD⁴/32, and the maximum shear stress under torque T is τ = Tr/J. A rectangle warps when twisted, so its torsion constant uses Roark’s approximation."
    :calc="['engine' => 'ph-mech', 'tool' => 'polar_moi', 'fields' => ['shape', 'd', 'di', 'h', 'T', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'di' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all()], 'data' => ['units' => collect(config('units'))->only(['area_moment', 'energy', 'force', 'length', 'mass', 'speed', 'torque'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is J for a 50 mm solid shaft?', 'answer' => '613,592 mm⁴.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Section" :options="['solid' => 'Solid round shaft', 'hollow' => 'Hollow round tube', 'rect' => 'Solid rectangle (torsion constant)']" selected="solid" />
        <x-calc.field name="d" label="Outer diameter (or width b)" value="50" placeholder="Outer diameter (or width b)">
            <label for="calc-d-unit" class="sr-only">Outer diameter (or width b) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="shape:hollow">
            <x-calc.field name="di" label="Inner diameter" value="40" placeholder="Inner diameter">
                <label for="calc-di-unit" class="sr-only">Inner diameter unit</label>
                <select id="calc-di-unit" name="di-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="shape:rect">
            <x-calc.field name="h" label="Height h (rectangle)" value="20" placeholder="Height h (rectangle)">
                <label for="calc-h-unit" class="sr-only">Height h (rectangle) unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="T" label="Torque (optional)" value="500" placeholder="Torque (optional)">
            <label for="calc-T-unit" class="sr-only">Torque (optional) unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m4' => 'm⁴', 'cm4' => 'cm⁴', 'mm4' => 'mm⁴', 'in4' => 'in⁴', 'ft4' => 'ft⁴']" selected="mm4" />
    </div>

    <x-calc.result label="Polar moment of inertia J" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm4', 'shape' => 'solid', 'd' => 50, 'd-unit' => 'mm', 'di' => 40, 'di-unit' => 'mm', 'h' => 20, 'h-unit' => 'mm', 'T' => 500, 'T-unit' => 'nm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'zp' => ['label' => 'Torsional section modulus'],
            'tau' => ['label' => 'Maximum shear stress at that torque'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
