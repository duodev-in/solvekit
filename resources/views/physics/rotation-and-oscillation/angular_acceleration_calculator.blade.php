<x-calc.page
    title="Angular Acceleration Calculator - SolveKit"
    description="Free angular acceleration calculator: α = Δω ÷ t in rad/s², from rpm or rad/s."
    lede="Solve α = Δω ÷ t."
    about="Angular acceleration is how quickly rotation speeds up. A motor reaching 1,000 rpm in 10 s averages about 10.5 rad/s²."
    :calc="['engine' => 'ph-mech', 'tool' => 'ang_accel', 'fields' => ['solve', 'a', 'dw', 't', 'out_a', 'out_dw', 'out_t'], 'unitFields' => ['a' => collect(config('units.angular_acceleration'))->only(['rads2', 'degs2', 'rpms', 'revs2'])->all(), 'dw' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['a', 'angular_acceleration', 'angular_speed', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is α for 0–1,000 rpm in 10 s?', 'answer' => '10.472 rad/s².'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['a' => 'Angular acceleration', 'dw' => 'Change in angular velocity', 't' => 'Time']" selected="a" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:dw,t" hidden>
            <x-calc.field name="a" label="Angular acceleration" value="10.472" placeholder="Angular acceleration">
                <label for="calc-a-unit" class="sr-only">Angular acceleration unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_acceleration'))->only(['rads2', 'degs2', 'rpms', 'revs2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rads2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:a,t">
            <x-calc.field name="dw" label="Change in angular velocity" value="1000" placeholder="Change in angular velocity">
                <label for="calc-dw-unit" class="sr-only">Change in angular velocity unit</label>
                <select id="calc-dw-unit" name="dw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:a,dw">
            <x-calc.field name="t" label="Time" value="10" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:a">
            <x-calc.select name="out_a" label="Show the result in" :options="['rads2' => 'rad/s²', 'degs2' => '°/s²', 'rpms' => 'rpm/s', 'revs2' => 'rev/s²']" selected="rads2" />
        </div>
        <div data-show-when="solve:dw" hidden>
            <x-calc.select name="out_dw" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rpm" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
        </div>
    </div>

    <x-calc.result label="Angular acceleration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'a', 'a' => 10.472, 'a-unit' => 'rads2', 'out_a' => 'rads2', 'dw' => 1000, 'dw-unit' => 'rpm', 'out_dw' => 'rpm', 't' => 10, 't-unit' => 's', 'out_t' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'turns' => ['label' => 'Turns made while speeding up from rest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>α = Δω ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
