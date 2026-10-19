<x-calc.page
    title="Mean Airway Pressure Calculator - SolveKit"
    description="Free mean airway pressure calculator: mean airway pressure on a ventilator from PIP, PEEP, inspiratory time and rate."
    lede="Calculate mean airway pressure."
    about="Mean airway pressure ≈ K × (PIP − PEEP) × (Ti ÷ Ttot) + PEEP, where Ttot = 60 ÷ rate and K is 1 for a square (pressure-control) waveform and 0.5 for a sine waveform. It is used in the oxygenation index. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'mean_airway', 'fields' => ['pip', 'peep', 'ti', 'rr', 'wave']]"
    :how-to="[
        ['name' => 'Enter the ventilator settings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the mean airway pressure at PIP 25, PEEP 8, Ti 1 s and rate 16?', 'answer' => '12.5 cmH₂O.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pip" label="Peak inspiratory pressure" value="25" min="0" step="any" suffix="cmH₂O" />
        <x-calc.field name="peep" label="PEEP" value="8" min="0" step="any" suffix="cmH₂O" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ti" label="Inspiratory time" value="1.0" min="0" step="any" suffix="s" />
        <x-calc.field name="rr" label="Rate" value="16" min="0" step="1" suffix="/min" />
        <x-calc.segmented name="wave" legend="Waveform" :options="['square' => 'Square', 'sine' => 'Sine']" selected="square" />
    </div>

    <x-calc.result label="Mean airway pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pip' => 25, 'peep' => 8, 'ti' => 1, 'rr' => 16, 'wave' => 'square'],
        'Sine' => ['pip' => 30, 'peep' => 10, 'ti' => 0.8, 'rr' => 20, 'wave' => 'sine'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'k' => ['label' => 'Waveform factor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MAP = K (PIP − PEEP) Ti ÷ Ttot + PEEP</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
