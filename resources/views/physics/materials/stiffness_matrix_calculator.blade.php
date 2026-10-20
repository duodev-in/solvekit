<x-calc.page
    title="Stiffness Matrix Calculator - SolveKit"
    description="Free element stiffness matrix calculator: spring, bar, 2D truss and beam element matrices for finite element analysis."
    lede="Build an element stiffness matrix."
    about="Finite element analysis assembles a structure from small elements, each described by a stiffness matrix linking its node forces to its node displacements. These are the standard matrices for the simplest elements."
    :calc="['engine' => 'ph-mat', 'tool' => 'stiffness_matrix', 'fields' => ['el', 'k', 'E', 'A', 'I', 'L', 'angle'], 'unitFields' => ['k' => collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm'])->all(), 'E' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'I' => collect(config('units.area_moment'))->only(['m4', 'cm4', 'mm4', 'in4', 'ft4'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'area', 'area_moment', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'stiffness'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the axial stiffness EA/L of the example truss bar?', 'answer' => '50,000,000 N/m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="el" label="Element" :options="['spring' => 'Spring (1D, 2 DOF)', 'bar' => 'Bar (axial, 2 DOF)', 'truss' => '2D truss bar (4 DOF)', 'beam' => 'Euler–Bernoulli beam (4 DOF)']" selected="truss" />
        <div data-show-when="el:spring">
            <x-calc.field name="k" label="Spring constant" value="100" min="0" placeholder="Spring constant">
                <label for="calc-k-unit" class="sr-only">Spring constant unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'knpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="el:bar,truss,beam">
            <x-calc.field name="E" label="Young's modulus" value="200" min="0" placeholder="Young's modulus">
                <label for="calc-E-unit" class="sr-only">Young's modulus unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'gpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="el:bar,truss">
            <x-calc.field name="A" label="Area" value="500" min="0" placeholder="Area">
                <label for="calc-A-unit" class="sr-only">Area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="el:beam">
            <x-calc.field name="I" label="Second moment I" value="500" min="0" placeholder="Second moment I">
                <label for="calc-I-unit" class="sr-only">Second moment I unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area_moment'))->only(['m4', 'cm4', 'mm4', 'in4', 'ft4']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm4')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="el:bar,truss,beam">
            <x-calc.field name="L" label="Length" value="2" placeholder="Length">
                <label for="calc-L-unit" class="sr-only">Length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="el:truss">
            <x-calc.field name="angle" label="Angle from the x-axis" value="30" placeholder="Angle from the x-axis">
                <label for="calc-angle-unit" class="sr-only">Angle from the x-axis unit</label>
                <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Element stiffness" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['el' => 'truss', 'k' => 100, 'k-unit' => 'knpm', 'E' => 200, 'E-unit' => 'gpa', 'A' => 500, 'A-unit' => 'mm2', 'I' => 500, 'I-unit' => 'cm4', 'L' => 2, 'L-unit' => 'm', 'angle' => 30, 'angle-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dofs' => ['label' => 'Degrees of freedom'],
            'units' => ['label' => 'Units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Element stiffness matrix [k]" name="K" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
