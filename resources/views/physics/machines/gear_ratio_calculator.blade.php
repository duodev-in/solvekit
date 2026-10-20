<x-calc.page
    title="Gear Ratio Calculator - SolveKit"
    description="Free gear ratio calculator: overall ratio, output speed and torque of a multi-stage gear train."
    lede="Find a gear train’s ratio."
    about="Each gear pair multiplies speed by driver teeth ÷ driven teeth. The overall ratio is the product of the stages; torque rises by the same factor minus losses."
    :calc="['engine' => 'ph-mach', 'tool' => 'gear_ratio', 'fields' => ['stages', 'rpm', 'T', 'eff'], 'unitFields' => ['T' => collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'torque'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the ratio of 12:36 then 15:45?', 'answer' => '9 : 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="stages" label="Stages: driver teeth, driven teeth (one pair per line)" value="12, 36
15, 45" rows="3" />
        <x-calc.field name="rpm" label="Input speed (rpm)" value="1500" min="0" step="any" />
        <x-calc.field name="T" label="Input torque (optional)" value="10" placeholder="Input torque (optional)">
            <label for="calc-T-unit" class="sr-only">Input torque (optional) unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.torque'))->only(['nm', 'knm', 'ncm', 'nmm', 'lbfft', 'lbfin', 'kgfm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="eff" label="Efficiency per stage (%)" value="98" min="0" step="any" />
    </div>

    <x-calc.result label="Overall gear ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['stages' => '12, 36
15, 45', 'rpm' => 1500, 'T' => 10, 'T-unit' => 'nm', 'eff' => 98],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'out' => ['label' => 'Output speed'],
            'torque' => ['label' => 'Output torque'],
            'each' => ['label' => 'Stage ratios'],
            'dir' => ['label' => 'Output direction (external gears)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
