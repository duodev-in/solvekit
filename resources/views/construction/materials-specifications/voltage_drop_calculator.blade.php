<x-calc.page
    title="Voltage Drop Calculator - SolveKit"
    description="Free voltage drop calculator: volts and percent drop for copper or aluminum conductors from NEC Chapter 9 Table 8 resistance, single or three phase."
    lede="Work out the voltage drop in a circuit."
    about="Voltage drop = 2 × length × resistance × current for single-phase or DC circuits, √3 × length × resistance × current for three-phase, with the DC resistance of stranded conductors at 75 °C from NEC Chapter 9 Table 8. For AC circuits with large conductors, reactance (Table 9) adds a little. NEC informational notes suggest at most 3% on a branch circuit and 5% in total."
    :calc="['engine' => 'con-elec', 'tool' => 'voltage_drop', 'fields' => ['size', 'material', 'phase', 'length', 'amps', 'volts'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => collect(config('construction_data'))->only(['wires', 'box_fill', 'conduits'])->all()]"
    :how-to="[
        ['name' => 'Choose the conductor', 'text' => 'Size and material.'],
        ['name' => 'Enter the run', 'text' => 'One-way length, current and voltage.'],
    ]"
    :faqs="[
        ['question' => 'What is the drop on 100 ft of 12 AWG at 16 A, 120 V?', 'answer' => '6.3 V, 5.3%.'],
        ['question' => 'What voltage drop is allowed?', 'answer' => 'The NEC suggests 3% for branch circuits and 5% overall (informational notes).'],
        ['question' => 'Why use the one-way length?', 'answer' => 'The formula doubles it for the return conductor.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="size" label="Conductor" :options="collect(config('construction_data.wires'))->map(fn ($w) => $w['label'])->all()" selected="12" />
        <x-calc.select name="material" label="Material" :options="['cu' => 'Copper', 'al' => 'Aluminum']" selected="cu" />
        <x-calc.select name="phase" label="Circuit" :options="['single' => 'Single phase or DC', 'three' => 'Three phase']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="One-way length" value="100" min="0" placeholder="One-way length">
            <label for="calc-length-unit" class="sr-only">One-way length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="amps" label="Current" value="16" min="0" suffix="A" />
        <x-calc.field name="volts" label="Voltage" value="120" min="0" suffix="V" />
    </div>

    <x-calc.result label="Voltage drop" />

    <x-calc.options :examples="[
        '12 AWG, 100 ft, 16 A' => ['size' => '12', 'material' => 'cu', 'phase' => 'single', 'length' => 100, 'length-unit' => 'ft', 'amps' => 16, 'volts' => 120],
        '1/0 aluminum feeder, 240 V' => ['size' => '1/0', 'material' => 'al', 'phase' => 'single', 'length' => 150, 'length-unit' => 'ft', 'amps' => 100, 'volts' => 240],
        'Three phase 480 V, 4 AWG' => ['size' => '4', 'material' => 'cu', 'phase' => 'three', 'length' => 60, 'length-unit' => 'm', 'amps' => 60, 'volts' => 480],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'percent' => ['label' => 'Percent'],
            'at_load' => ['label' => 'At the load'],
            'guide' => ['label' => 'Guidance'],
            'smallest' => ['label' => 'Size for 3%'],
            'resistance' => ['label' => 'Resistance'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>single phase: VD = 2 × L × R × I</li>
            <li>three phase: VD = √3 × L × R × I</li>
            <li>R in Ω per ft from Table 8 (Ω/1000 ft ÷ 1000)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
