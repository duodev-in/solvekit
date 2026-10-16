<x-calc.page
    title="Hydrogen Ion Concentration Calculator - SolveKit"
    description="Free hydrogen ion concentration calculator: convert pH to [H+] and back, with pOH and [OH-] at any water temperature."
    lede="Convert pH to hydrogen ion concentration and back."
    about="[H⁺] = 10^−pH mol/L. pOH and [OH⁻] use the ionization constant of water at your temperature from the IAPWS formulation (pKw = 13.995 at 25 °C, 14.946 at 0 °C), so neutral pH is 7.00 only near 25 °C."
    :calc="['engine' => 'chem-stoich', 'tool' => 'hydrogen_ion', 'fields' => ['direction', 'ph', 'h', 'temperature']]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'pH to [H⁺] or back.'],
        ['name' => 'Set the temperature', 'text' => 'It changes pKw and neutral pH.'],
    ]"
    :faqs="[
        ['question' => 'What is [H⁺] at pH 7?', 'answer' => '1.0 × 10⁻⁷ mol/L.'],
        ['question' => 'Is pH 7 always neutral?', 'answer' => 'Only near 25 °C; at 50 °C neutral water is pH 6.63.'],
        ['question' => 'Can pH be negative?', 'answer' => 'Yes, for very concentrated strong acids above 1 mol/L.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['ph' => 'pH → [H⁺]', 'h' => '[H⁺] → pH']" selected="ph" />

    <div data-show-when="direction:ph">
        <x-calc.field name="ph" label="pH" value="3.5" />
    </div>

    <div data-show-when="direction:h" hidden>
        <x-calc.field name="h" label="[H⁺]" value="0.0001" min="0" suffix="mol/L" />
    </div>

    <x-calc.field name="temperature" label="Temperature" value="25" min="0" max="100" suffix="°C" />

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'pH 3.5' => ['direction' => 'ph', 'ph' => 3.5, 'temperature' => 25],
        '[H⁺] = 10⁻⁴ M' => ['direction' => 'h', 'h' => 0.0001, 'temperature' => 25],
        'Neutral at 50 °C' => ['direction' => 'ph', 'ph' => 6.63, 'temperature' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'h' => ['label' => '[H⁺]'],
            'poh' => ['label' => 'pOH'],
            'oh' => ['label' => '[OH⁻]'],
            'pkw' => ['label' => 'pKw at this temperature'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>[H⁺] = 10^−pH</li>
            <li>pOH = pKw − pH</li>
            <li>pKw: IAPWS (Bandura and Lvov, 2006)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
