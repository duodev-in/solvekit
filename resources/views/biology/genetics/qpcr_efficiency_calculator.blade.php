<x-calc.page
    title="qPCR Efficiency Calculator - SolveKit"
    description="Free qPCR efficiency calculator: amplification efficiency and factor from the slope of a standard curve."
    lede="Work out qPCR amplification efficiency from a standard-curve slope."
    about="Plot Ct against log₁₀ of the template amount for a dilution series; the slope gives the efficiency E = 10^(−1/slope) − 1. A slope of −3.32 means perfect doubling each cycle (100%). 90 to 110% is generally acceptable."
    :calc="['engine' => 'genetics', 'tool' => 'qpcr', 'fields' => ['slope']]"
    :how-to="[
        ['name' => 'Run a dilution series', 'text' => 'At least five 10-fold or 4-fold dilutions.'],
        ['name' => 'Fit the line', 'text' => 'Ct against log₁₀ of quantity.'],
        ['name' => 'Enter the slope', 'text' => 'The efficiency follows.'],
    ]"
    :faqs="[
        ['question' => 'What slope gives 100% efficiency?', 'answer' => '−3.32 for a 10-fold series.'],
        ['question' => 'Why is efficiency above 100%?', 'answer' => 'Usually inhibitors in concentrated samples or pipetting errors.'],
        ['question' => 'Does efficiency matter for ΔΔCt?', 'answer' => 'Yes, ΔΔCt assumes both assays are close to 100% and to each other.'],
    ]"
>
    <x-calc.field name="slope" label="Standard curve slope" value="-3.32" step="any" help="Ct vs log₁₀(quantity); usually about −3.1 to −3.6" />

    <x-calc.result label="Efficiency" />

    <x-calc.options :examples="[
        'Ideal −3.32' => ['slope' => -3.32],
        'Low −3.8' => ['slope' => -3.8],
        'High −3.0' => ['slope' => -3.0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Amplification'],
            'ideal' => ['label' => 'Ideal slope'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = (10^(−1 ÷ slope) − 1) × 100</li>
            <li>amplification factor = 10^(−1 ÷ slope)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
