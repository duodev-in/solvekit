<x-calc.page
    title="Pulse per Mile Calculator - SolveKit"
    description="Free pulse per mile calculator: vehicle speed sensor pulses per mile (PPM) from tire size, axle ratio and pulses per driveshaft revolution, for speedometer calibration."
    lede="Work out the pulses per mile to calibrate a speedometer."
    about="Pulses per mile = tire revolutions per mile × axle ratio × pulses per driveshaft (transmission output) revolution. Common sensors give 4, 8, 16 or 40 pulses per revolution. Tire revolutions per mile come from the tire maker, or from the diameter: 63,360 ÷ (π × diameter in inches)."
    :calc="['engine' => 'ev-transport', 'tool' => 'pulse_per_mile', 'fields' => ['tire_mode', 'revs', 'diameter', 'axle', 'pulses'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the tire', 'text' => 'Revs per mile or diameter.'],
        ['name' => 'Enter axle ratio and sensor pulses', 'text' => 'From the sensor\'s data sheet.'],
    ]"
    :faqs="[
        ['question' => 'What is pulses per mile?', 'answer' => 'The number of speed-sensor pulses for each mile driven, used to calibrate electronic speedometers.'],
        ['question' => 'What is the PPM for 700 revs/mile, 3.73 gears and 8 pulses?', 'answer' => '20,888 pulses per mile.'],
        ['question' => 'What is a K-factor?', 'answer' => 'Pulses per mile in thousands.'],
    ]"
>
    <x-calc.segmented name="tire_mode" legend="Tire by" :options="['revs' => 'Revs per mile', 'diameter' => 'Diameter']" selected="revs" />

    <div data-show-when="tire_mode:revs">
        <x-calc.field name="revs" label="Tire revolutions per mile" value="700" min="1" step="1" />
    </div>

    <div data-show-when="tire_mode:diameter" hidden>
        <x-calc.field name="diameter" label="Tire diameter" value="28.9" min="0" placeholder="Tire diameter">
            <label for="calc-diameter-unit" class="sr-only">Tire diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['mm', 'in', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="axle" label="Axle ratio" value="3.73" min="0.5" step="0.01" suffix=":1" />
        <x-calc.field name="pulses" label="Pulses per driveshaft rev" value="8" min="1" step="1" />
    </div>

    <x-calc.result label="Speed sensor setting" />

    <x-calc.options :examples="[
        '700 revs, 3.73, 8 pulses' => ['tire_mode' => 'revs', 'revs' => 700, 'diameter' => '', 'diameter-unit' => 'in', 'axle' => 3.73, 'pulses' => 8],
        '33 in tire, 4.10, 16 pulses' => ['tire_mode' => 'diameter', 'revs' => '', 'diameter' => 33, 'diameter-unit' => 'in', 'axle' => 4.1, 'pulses' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'km' => ['label' => 'Per km'],
            'k' => ['label' => 'K-factor'],
            'driveshaft' => ['label' => 'Driveshaft revs'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PPM = revs/mile × axle ratio × pulses/rev</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
