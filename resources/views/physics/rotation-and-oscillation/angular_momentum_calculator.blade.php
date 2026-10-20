<x-calc.page
    title="Angular Momentum Calculator - SolveKit"
    description="Free angular momentum calculator: L = Iω for angular momentum, moment of inertia or angular velocity."
    lede="Solve L = Iω."
    about="Angular momentum is conserved without outside torque, which is why a skater spins faster when pulling the arms in."
    :calc="['engine' => 'ph-mech', 'tool' => 'ang_momentum', 'fields' => ['solve', 'L', 'I', 'w', 'out_L', 'out_I', 'out_w'], 'unitFields' => ['L' => collect(config('units.angular_momentum'))->only(['kgm2s', 'gcm2s', 'lbft2s'])->all(), 'I' => collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2'])->all(), 'w' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all()], 'data' => ['units' => collect(config('units'))->only(['L', 'angular_momentum', 'angular_speed', 'energy', 'force', 'length', 'mass', 'moment_of_inertia', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is L for I = 2 kg·m² at 30 rpm?', 'answer' => '6.28319 kg·m²/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['L' => 'Angular momentum', 'I' => 'Moment of inertia', 'w' => 'Angular velocity']" selected="L" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:I,w" hidden>
            <x-calc.field name="L" label="Angular momentum" value="6.2832" placeholder="Angular momentum">
                <label for="calc-L-unit" class="sr-only">Angular momentum unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_momentum'))->only(['kgm2s', 'gcm2s', 'lbft2s']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm2s')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:L,w">
            <x-calc.field name="I" label="Moment of inertia" value="2" min="0" placeholder="Moment of inertia">
                <label for="calc-I-unit" class="sr-only">Moment of inertia unit</label>
                <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.moment_of_inertia'))->only(['kgm2', 'gcm2', 'kgcm2', 'lbft2', 'lbin2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:L,I">
            <x-calc.field name="w" label="Angular velocity" value="30" placeholder="Angular velocity">
                <label for="calc-w-unit" class="sr-only">Angular velocity unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:L">
            <x-calc.select name="out_L" label="Show the result in" :options="['kgm2s' => 'kg·m²/s', 'gcm2s' => 'g·cm²/s', 'lbft2s' => 'lb·ft²/s']" selected="kgm2s" />
        </div>
        <div data-show-when="solve:I" hidden>
            <x-calc.select name="out_I" label="Show the result in" :options="['kgm2' => 'kg·m²', 'gcm2' => 'g·cm²', 'kgcm2' => 'kg·cm²', 'lbft2' => 'lb·ft²', 'lbin2' => 'lb·in²']" selected="kgm2" />
        </div>
        <div data-show-when="solve:w" hidden>
            <x-calc.select name="out_w" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rpm" />
        </div>
    </div>

    <x-calc.result label="Angular momentum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'L', 'L' => 6.2832, 'L-unit' => 'kgm2s', 'out_L' => 'kgm2s', 'I' => 2, 'I-unit' => 'kgm2', 'out_I' => 'kgm2', 'w' => 30, 'w-unit' => 'rpm', 'out_w' => 'rpm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ke' => ['label' => 'Rotational kinetic energy'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = I ω</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
