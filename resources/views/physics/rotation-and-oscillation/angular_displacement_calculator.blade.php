<x-calc.page
    title="Angular Displacement Calculator - SolveKit"
    description="Free angular displacement calculator: θ = ω₀t + ½αt² for angle, initial speed, acceleration or time."
    lede="Solve θ = ω₀t + ½αt²."
    about="Angular displacement is the angle turned. With constant angular acceleration it follows the same equations as straight-line motion."
    :calc="['engine' => 'ph-mech', 'tool' => 'ang_disp', 'fields' => ['solve', 'th', 'w0', 'a', 't', 'out_th', 'out_w0', 'out_a', 'out_t'], 'unitFields' => ['th' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'w0' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all(), 'a' => collect(config('units.angular_acceleration'))->only(['rads2', 'degs2', 'rpms', 'revs2'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'angular_acceleration', 'angular_speed', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What angle is turned in the example?', 'answer' => '31.4 rad.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['th' => 'Angular displacement', 'w0' => 'Initial angular velocity', 'a' => 'Angular acceleration', 't' => 'Time']" selected="th" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:w0,a,t" hidden>
            <x-calc.field name="th" label="Angular displacement" value="31.4159" placeholder="Angular displacement">
                <label for="calc-th-unit" class="sr-only">Angular displacement unit</label>
                <select id="calc-th-unit" name="th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rad')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:th,a,t">
            <x-calc.field name="w0" label="Initial angular velocity" value="1" placeholder="Initial angular velocity">
                <label for="calc-w0-unit" class="sr-only">Initial angular velocity unit</label>
                <select id="calc-w0-unit" name="w0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rads')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:th,w0,t">
            <x-calc.field name="a" label="Angular acceleration" value="0.428" placeholder="Angular acceleration">
                <label for="calc-a-unit" class="sr-only">Angular acceleration unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_acceleration'))->only(['rads2', 'degs2', 'rpms', 'revs2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rads2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:th,w0,a">
            <x-calc.field name="t" label="Time" value="10" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:th">
            <x-calc.select name="out_th" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="rad" />
        </div>
        <div data-show-when="solve:w0" hidden>
            <x-calc.select name="out_w0" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rads" />
        </div>
        <div data-show-when="solve:a" hidden>
            <x-calc.select name="out_a" label="Show the result in" :options="['rads2' => 'rad/s²', 'degs2' => '°/s²', 'rpms' => 'rpm/s', 'revs2' => 'rev/s²']" selected="rads2" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
        </div>
    </div>

    <x-calc.result label="Angular displacement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'th', 'th' => 31.4159, 'th-unit' => 'rad', 'out_th' => 'rad', 'w0' => 1, 'w0-unit' => 'rads', 'out_w0' => 'rads', 'a' => 0.428, 'a-unit' => 'rads2', 'out_a' => 'rads2', 't' => 10, 't-unit' => 's', 'out_t' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'turns' => ['label' => 'Revolutions'],
            'w' => ['label' => 'Final angular velocity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = ω₀t + ½αt²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
