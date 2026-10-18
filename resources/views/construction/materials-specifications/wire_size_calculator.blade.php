<x-calc.page
    title="Wire Size Calculator - SolveKit"
    description="Free wire size calculator: AWG or kcmil conductor size for a load from NEC Table 310.16 ampacity, small-conductor limits and voltage drop."
    lede="Work out the wire size for a load."
    about="The smallest conductor whose NEC Table 310.16 ampacity (at most three current-carrying conductors, 30 °C ambient) covers the load, with continuous loads at 125% (210.19(A)(1)) and the 240.4(D) limits for 14–10 AWG; then upsized if needed to keep the voltage drop within your limit. Most terminations are rated 75 °C (110.14(C)). Adjustment and correction factors for crowded or hot conditions are not applied."
    :calc="['engine' => 'con-elec', 'tool' => 'wire_size', 'fields' => ['amps', 'continuous', 'material', 'temp', 'length', 'volts', 'phase', 'max_drop'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'data' => collect(config('construction_data'))->only(['wires', 'box_fill', 'conduits'])->all()]"
    :how-to="[
        ['name' => 'Enter the load', 'text' => 'Current, and whether it is continuous.'],
        ['name' => 'Choose material and column', 'text' => '75 °C for most terminations.'],
        ['name' => 'Add the length', 'text' => 'To check the voltage drop.'],
    ]"
    :faqs="[
        ['question' => 'What size wire for 40 A?', 'answer' => '8 AWG copper at 75 °C (50 A); with 125% for a continuous load, 50 A needed, still 8 AWG.'],
        ['question' => 'What size for a 30 A circuit?', 'answer' => '10 AWG copper.'],
        ['question' => 'When do I upsize for voltage drop?', 'answer' => 'On long runs; this calculator does it when the drop exceeds your limit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amps" label="Load current" value="40" min="0" suffix="A" />
        <x-calc.select name="continuous" label="Continuous (3 h or more)" :options="['no' => 'No', 'yes' => 'Yes']" selected="yes" />
        <x-calc.select name="material" label="Material" :options="['cu' => 'Copper', 'al' => 'Aluminum']" selected="cu" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="temp" label="Temperature column" :options="['60' => '60 °C', '75' => '75 °C', '90' => '90 °C']" selected="75" />
        <x-calc.field name="length" label="One-way length (optional)" value="75" min="0" placeholder="One-way length (optional)">
            <label for="calc-length-unit" class="sr-only">One-way length (optional) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="volts" label="Voltage" value="240" min="0" suffix="V" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="phase" label="Circuit" :options="['single' => 'Single phase or DC', 'three' => 'Three phase']" selected="single" />
        <x-calc.field name="max_drop" label="Voltage drop limit" value="3" min="0.5" max="10" step="0.5" suffix="%" />
    </div>

    <x-calc.result label="Wire size" />

    <x-calc.options :examples="[
        '40 A continuous, 75 ft' => ['amps' => 40, 'continuous' => 'yes', 'material' => 'cu', 'temp' => '75', 'length' => 75, 'length-unit' => 'ft', 'volts' => 240, 'phase' => 'single', 'max_drop' => 3],
        '20 A, 150 ft at 120 V' => ['amps' => 16, 'continuous' => 'no', 'material' => 'cu', 'temp' => '60', 'length' => 150, 'length-unit' => 'ft', 'volts' => 120, 'phase' => 'single', 'max_drop' => 3],
        '100 A aluminum feeder' => ['amps' => 100, 'continuous' => 'no', 'material' => 'al', 'temp' => '75', 'length' => 100, 'length-unit' => 'ft', 'volts' => 240, 'phase' => 'single', 'max_drop' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'required' => ['label' => 'Ampacity needed'],
            'ampacity' => ['label' => 'Ampacity'],
            'by_ampacity' => ['label' => 'By ampacity alone'],
            'drop' => ['label' => 'Voltage drop'],
            'note' => ['label' => 'Not included'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ampacity ≥ load (× 1.25 if continuous)</li>
            <li>14 AWG ≤ 15 A, 12 ≤ 20 A, 10 ≤ 30 A (Cu)</li>
            <li>VD% ≤ limit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
