<x-calc.page
    title="Lung Nodule Growth Rate Calculator - SolveKit"
    description="Free lung nodule growth calculator: volume doubling time from two CT diameters and the days between scans, with the BTS growth thresholds."
    lede="Calculate nodule volume doubling time."
    about="Treating a nodule as a sphere, volume doubling time = days × ln 2 ÷ (3 × ln(d₂ ÷ d₁)). The British Thoracic Society (2015) treats a VDT under 400 days in a solid nodule as worrying for cancer, and over 600 days as slow. Volumetric software measurement is more accurate than diameters. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'nodule', 'fields' => ['d1', 'd2', 'days']]"
    :how-to="[
        ['name' => 'Enter both diameters', 'text' => ''],
        ['name' => 'Enter the days between scans', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the doubling time for 6 mm growing to 7.5 mm in 180 days?', 'answer' => '186 days: Under 400 days: growth worrying for a solid nodule.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="d1" label="First diameter" value="6" min="0" step="any" suffix="mm" />
        <x-calc.field name="d2" label="Second diameter" value="7.5" min="0" step="any" suffix="mm" />
        <x-calc.field name="days" label="Days between scans" value="180" min="0" step="1" suffix="days" />
    </div>

    <x-calc.result label="Volume doubling time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d1' => 6, 'd2' => 7.5, 'days' => 180],
        'Slow' => ['d1' => 8, 'd2' => 8.5, 'days' => 365],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'volume' => ['label' => 'Volume change'],
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Thresholds'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VDT = t ln 2 ÷ (3 ln(d₂/d₁))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
