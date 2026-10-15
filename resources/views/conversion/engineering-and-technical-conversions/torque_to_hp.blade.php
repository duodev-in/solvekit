@php
    $torqueUnits = collect(config('units.torque'))->only(['nm', 'lbfft', 'lbfin', 'kgfm', 'knm'])->all();
    $powerUnits = collect(config('units.power'))->only(['hp', 'ps', 'kw', 'w', 'btuh'])->all();
    $rows = collect($powerUnits)->mapWithKeys(fn ($unit, $key) => [$key => ['label' => $unit['name'], 'unit' => $unit['symbol']]])->all();
@endphp

<x-calc.page
    title="Torque to HP Calculator - SolveKit"
    description="Professional torque to horsepower calculator for engineering applications. Calculate power output from torque and RPM values with precision."
    lede="Work out power from torque and engine speed."
    about="Power is torque times angular speed: P = τ × ω, where ω = rpm × 2π ÷ 60. In imperial units this is the familiar hp = lbf·ft × rpm ÷ 5,252. Any torque and power unit can be used."
    :calc="['engine' => 'torque-to-hp', 'torqueUnits' => $torqueUnits, 'powerUnits' => $powerUnits, 'rows' => array_keys($rows)]"
    :how-to="[
        ['name' => 'Enter the torque', 'text' => 'Type the torque and choose its unit.'],
        ['name' => 'Enter the engine speed', 'text' => 'Type the speed in revolutions per minute.'],
        ['name' => 'Choose the power unit', 'text' => 'Horsepower, kilowatts and others are all listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'What is the torque to horsepower formula?', 'answer' => 'hp = torque (lbf·ft) × rpm ÷ 5,252. In SI units, power (W) = torque (N·m) × rpm × 2π ÷ 60.'],
        ['question' => 'Why do torque and horsepower curves cross at 5,252 rpm?', 'answer' => 'Because 5,252 is the constant in the formula, so at that speed hp and lbf·ft are numerically equal.'],
        ['question' => 'Is this crank or wheel horsepower?', 'answer' => 'Whatever the torque figure is. Engine torque gives crank horsepower; dyno torque at the wheels gives wheel horsepower.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="torque" label="Torque" value="300" min="0" placeholder="Torque">
            <label for="calc-torque-unit" class="sr-only">Torque unit</label>
            <select id="calc-torque-unit" name="torque-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach($torqueUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lbfft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rpm" label="Engine speed" value="5252" min="0" suffix="rpm" placeholder="RPM" />
    </div>

    <x-calc.select name="power-unit" label="Show power in" :options="collect($powerUnits)->mapWithKeys(fn ($unit, $key) => [$key => $unit['name']])->all()" selected="hp" />

    <x-calc.result label="Horsepower" />

    <x-calc.options :examples="[
        'Hatchback 180 N·m at 4,500' => ['torque' => 180, 'torque-unit' => 'nm', 'rpm' => 4500],
        'V8 400 lbf·ft at 4,000' => ['torque' => 400, 'torque-unit' => 'lbfft', 'rpm' => 4000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same power in" :rows="$rows" />
        <x-calc.quick-ref heading="At other speeds" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P (W) = τ (N·m) × rpm × 2π ÷ 60</li>
            <li>hp = τ (lbf·ft) × rpm ÷ 5,252</li>
            <li>kW = τ (N·m) × rpm ÷ 9,549</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
