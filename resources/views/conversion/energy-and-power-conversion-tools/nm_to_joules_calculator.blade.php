@php
    $torqueUnits = collect(config('units.torque'))->only(['nm', 'knm', 'lbfft', 'lbfin', 'kgfm'])->all();
    $angleUnits = collect(config('units.angle'))->only(['rad', 'deg', 'turn', 'grad'])->all();
    $energyUnits = config('units.energy');
    $rows = collect(['kj', 'wh', 'cal', 'ftlbf', 'btu'])->mapWithKeys(fn ($key) => [$key => ['label' => $energyUnits[$key]['name'], 'unit' => $energyUnits[$key]['symbol']]])->all();
    $unitSelect = 'h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40';
@endphp

<x-calc.page
    title="Nm to Joules Calculator - SolveKit"
    description="Professional newton-meter to joules calculator for torque to energy conversion. Calculate rotational energy from torque and angular displacement for mechanical engineering."
    lede="Find the work done by a torque turning through an angle."
    about="Work is torque times the angle turned in radians: W = τ × θ. A newton meter of torque turned through one radian does one joule of work; one full turn is 2π radians, so 1 N·m over one revolution is 6.283 J."
    :calc="['engine' => 'nm-to-joules', 'torqueUnits' => $torqueUnits, 'angleUnits' => $angleUnits, 'energyUnits' => $energyUnits, 'rows' => array_keys($rows)]"
    :how-to="[
        ['name' => 'Enter the torque', 'text' => 'Type the torque and choose its unit.'],
        ['name' => 'Enter the angle turned', 'text' => 'In radians, degrees or full turns.'],
    ]"
    :faqs="[
        ['question' => 'Is a newton meter the same as a joule?', 'answer' => 'They have the same base units, but torque in N·m is a turning force while a joule is energy. Torque only becomes work when it turns through an angle.'],
        ['question' => 'How much work is one revolution at 1 N·m?', 'answer' => '2π J, about 6.283 J.'],
        ['question' => 'Why must the angle be in radians?', 'answer' => 'The radian is the natural unit that makes W = τ × θ exact. The calculator converts degrees and turns for you.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="torque" label="Torque" value="50" placeholder="Torque">
            <label for="calc-torque-unit" class="sr-only">Torque unit</label>
            <select id="calc-torque-unit" name="torque-unit" class="{{ $unitSelect }}">
                @foreach($torqueUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="angle" label="Angle turned" value="10" placeholder="Angle">
            <label for="calc-angle-unit" class="sr-only">Angle unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="{{ $unitSelect }}">
                @foreach($angleUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'turn')>{{ $unit['name'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Joules" />

    <x-calc.options :examples="[
        'Wrench 90° at 40 N·m' => ['torque' => 40, 'torque-unit' => 'nm', 'angle' => 90, 'angle-unit' => 'deg'],
        'Winch 25 turns at 15 N·m' => ['torque' => 15, 'torque-unit' => 'nm', 'angle' => 25, 'angle-unit' => 'turn'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same work in" :rows="$rows" />
        <x-calc.steps />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>W = τ × θ (θ in radians)</li>
            <li>1 turn = 2π rad · 1° = π/180 rad</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
