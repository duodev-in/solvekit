<x-calc.page
    title="RPM Calculator - SolveKit"
    description="Free RPM calculator: engine RPM at a road speed from tire diameter, transmission gear ratio and axle ratio."
    lede="Work out engine RPM at any speed and gear."
    about="Wheel rpm = speed ÷ tire circumference; engine rpm = wheel rpm × gear ratio × axle (final drive) ratio. Use the loaded tire diameter if you have it; tires flatten slightly under load. Torque-converter and clutch slip are ignored."
    :calc="['engine' => 'ev-transport', 'tool' => 'rpm', 'fields' => ['speed', 'diameter', 'gear', 'axle'], 'unitFields' => ['speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all(), 'diameter' => collect(config('units.length'))->only(['mm', 'in', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the speed and tire size', 'text' => 'Tire diameter from the Tire Size calculator.'],
        ['name' => 'Enter the ratios', 'text' => 'Gear and axle.'],
    ]"
    :faqs="[
        ['question' => 'What RPM at 65 mph with 3.73 gears and 0.70 overdrive?', 'answer' => 'About 1,970 rpm with 28.9-inch tires.'],
        ['question' => 'Do bigger tires lower RPM?', 'answer' => 'Yes, each turn covers more ground.'],
        ['question' => 'What is overall ratio?', 'answer' => 'Gear ratio × axle ratio.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="speed" label="Speed" value="65" min="0" placeholder="Speed">
            <label for="calc-speed-unit" class="sr-only">Speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
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
        <x-calc.field name="gear" label="Gear ratio" value="0.7" min="0.1" step="0.01" suffix=":1" />
        <x-calc.field name="axle" label="Axle ratio" value="3.73" min="0.5" step="0.01" suffix=":1" />
    </div>

    <x-calc.result label="Engine speed" />

    <x-calc.options :examples="[
        '65 mph, overdrive' => ['speed' => 65, 'speed-unit' => 'mph', 'diameter' => 28.9, 'diameter-unit' => 'in', 'gear' => 0.7, 'axle' => 3.73],
        '100 km/h, 5th gear' => ['speed' => 100, 'speed-unit' => 'kmh', 'diameter' => 634, 'diameter-unit' => 'mm', 'gear' => 0.81, 'axle' => 4.06],
        '30 mph in 2nd' => ['speed' => 30, 'speed-unit' => 'mph', 'diameter' => 31, 'diameter-unit' => 'in', 'gear' => 1.53, 'axle' => 4.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'wheel' => ['label' => 'Wheel speed'],
            'overall' => ['label' => 'Overall ratio'],
            'per1000' => ['label' => 'Speed per 1,000 rpm'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rpm = speed ÷ (π × diameter) × gear × axle</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
