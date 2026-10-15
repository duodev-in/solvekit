@php
    $energyUnits = collect(config('units.energy'))->only(['j', 'kj', 'mj', 'wh', 'kwh', 'ev', 'cal'])->all();
    $chargeUnits = config('units.charge');
    $unitSelect = 'h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40';
@endphp

<x-calc.page
    title="Joules to Volts Calculator - SolveKit"
    description="Professional joules to volts calculator for energy to electrical potential conversion. Calculate voltage from energy and charge for electrical engineering applications."
    lede="Find the voltage from an amount of energy and the charge that carries it."
    about="Voltage is energy per unit charge: V = E ÷ Q. One volt is one joule per coulomb. Both values are converted to joules and coulombs first, so any units can be mixed; an electron moved through 1 V gains 1 eV."
    :calc="['engine' => 'joules-to-volts', 'energyUnits' => $energyUnits, 'chargeUnits' => $chargeUnits]"
    :how-to="[
        ['name' => 'Enter the energy', 'text' => 'Type the energy and choose its unit.'],
        ['name' => 'Enter the charge', 'text' => 'Type the charge and choose its unit, e.g. coulombs or mAh.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert joules to volts?', 'answer' => 'Divide the energy in joules by the charge in coulombs: V = J ÷ C.'],
        ['question' => 'Can joules be converted to volts without charge?', 'answer' => 'No. Joules measure energy and volts measure energy per charge, so you need the charge.'],
        ['question' => 'What is an electronvolt?', 'answer' => 'The energy one electron gains crossing 1 V: 1.602176634 × 10⁻¹⁹ J.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="energy" label="Energy" value="120" placeholder="Energy">
            <label for="calc-energy-unit" class="sr-only">Energy unit</label>
            <select id="calc-energy-unit" name="energy-unit" class="{{ $unitSelect }}">
                @foreach($energyUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="charge" label="Charge" value="10" placeholder="Charge">
            <label for="calc-charge-unit" class="sr-only">Charge unit</label>
            <select id="calc-charge-unit" name="charge-unit" class="{{ $unitSelect }}">
                @foreach($chargeUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Volts" />

    <x-calc.options :examples="[
        'Battery 3.7 Wh / 1 Ah' => ['energy' => 3.7, 'energy-unit' => 'wh', 'charge' => 1, 'charge-unit' => 'ah'],
        'Electron 1 eV / 1 e' => ['energy' => 1, 'energy-unit' => 'ev', 'charge' => 1, 'charge-unit' => 'e'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="In other units" :rows="[
            'mv' => ['label' => 'Millivolts', 'unit' => 'mV'],
            'kv' => ['label' => 'Kilovolts', 'unit' => 'kV'],
            'j' => ['label' => 'Energy in joules', 'unit' => 'J'],
            'c' => ['label' => 'Charge in coulombs', 'unit' => 'C'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = E ÷ Q</li>
            <li>1 V = 1 J/C</li>
            <li>1 Ah = 3,600 C · 1 Wh = 3,600 J</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
