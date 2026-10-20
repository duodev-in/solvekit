<x-calc.page
    title="Angular Velocity Calculator - SolveKit"
    description="Free angular velocity calculator: ω = θ ÷ t in rad/s and rpm."
    lede="Solve ω = θ ÷ t."
    about="Angular velocity is the angle turned per unit time. Rim speed is ω times the radius."
    :calc="['engine' => 'ph-mech', 'tool' => 'ang_velocity', 'fields' => ['solve', 'w', 'th', 't', 'out_w', 'out_th', 'out_t'], 'unitFields' => ['w' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all(), 'th' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'angular_speed', 'energy', 'force', 'length', 'mass', 'speed', 'time', 'w'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is ω for one turn in 2 s?', 'answer' => '3.14159 rad/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['w' => 'Angular velocity', 'th' => 'Angle turned', 't' => 'Time']" selected="w" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:th,t" hidden>
            <x-calc.field name="w" label="Angular velocity" value="3.14159" placeholder="Angular velocity">
                <label for="calc-w-unit" class="sr-only">Angular velocity unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rads')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:w,t">
            <x-calc.field name="th" label="Angle turned" value="360" placeholder="Angle turned">
                <label for="calc-th-unit" class="sr-only">Angle turned unit</label>
                <select id="calc-th-unit" name="th-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:w,th">
            <x-calc.field name="t" label="Time" value="2" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:w">
            <x-calc.select name="out_w" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rads" />
        </div>
        <div data-show-when="solve:th" hidden>
            <x-calc.select name="out_th" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
        </div>
    </div>

    <x-calc.result label="Angular velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'w', 'w' => 3.14159, 'w-unit' => 'rads', 'out_w' => 'rads', 'th' => 360, 'th-unit' => 'deg', 'out_th' => 'deg', 't' => 2, 't-unit' => 's', 'out_t' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'rpm' => ['label' => 'In rpm'],
            'speed' => ['label' => 'Rim speed at 1 m radius'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ω = θ ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
