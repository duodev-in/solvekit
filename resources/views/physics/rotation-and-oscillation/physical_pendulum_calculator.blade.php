<x-calc.page
    title="Physical Pendulum Calculator - SolveKit"
    description="Free physical pendulum calculator: period T = 2π√(I/mgd) for any rigid body swinging on a pivot."
    lede="Find the period of a physical pendulum."
    about="A rigid body swinging about a pivot has period 2π√(I ÷ mgd), with I about the pivot and d from the pivot to the centre of mass. A 1 m rod from one end swings like a 0.667 m simple pendulum."
    :calc="['engine' => 'ph-mech', 'tool' => 'physical_pendulum', 'fields' => ['solve', 'T', 'I', 'm', 'd', 'g', 'out_T', 'out_I', 'out_m', 'out_d', 'out_g'], 'unitFields' => ['T' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'I' => collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['T', 'acceleration', 'energy', 'force', 'length', 'mass', 'moment_of_inertia', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the period of a 1 kg, 1 m rod pivoted at one end?', 'answer' => '1.63741 s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['T' => 'Period', 'I' => 'Moment of inertia about the pivot', 'm' => 'Mass', 'd' => 'Pivot to centre of mass', 'g' => 'Gravity']" selected="T" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:I,m,d,g" hidden>
            <x-calc.field name="T" label="Period" value="1.6" placeholder="Period">
                <label for="calc-T-unit" class="sr-only">Period unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,m,d,g">
            <x-calc.field name="I" label="Moment of inertia about the pivot" value="0.333" min="0" placeholder="Moment of inertia about the pivot">
                <label for="calc-I-unit" class="sr-only">Moment of inertia about the pivot unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,I,d,g">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,I,m,g">
            <x-calc.field name="d" label="Pivot to centre of mass" value="0.5" placeholder="Pivot to centre of mass">
                <label for="calc-d-unit" class="sr-only">Pivot to centre of mass unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,I,m,d">
            <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
                <label for="calc-g-unit" class="sr-only">Gravity unit</label>
                <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T">
            <x-calc.select name="out_T" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['kgm2' => 'kg·m²', 'gcm2' => 'g·cm²', 'kgcm2' => 'kg·cm²', 'lbft2' => 'lb·ft²', 'lbin2' => 'lb·in²']" selected="kgm2" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:d" hidden>
            <x-calc.select name="out_d" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:g" hidden>
            <x-calc.select name="out_g" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
        </div>
    </div>

    <x-calc.result label="Period" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'T', 'T' => 1.6, 'T-unit' => 's', 'out_T' => 's', 'I' => 0.333, 'I-unit' => 'kgm2', 'out_I' => 'kgm2', 'm' => 1, 'm-unit' => 'kg', 'out_m' => 'kg', 'd' => 0.5, 'd-unit' => 'm', 'out_d' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2', 'out_g' => 'ms2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'Leq' => ['label' => 'Equivalent simple pendulum length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T = 2π √(I ÷ m g d)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
