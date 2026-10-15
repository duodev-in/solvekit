<x-calc.page
    title="PPM to mg/L Converter - SolveKit"
    description="Professional PPM to mg/L converter for water quality concentration units. Convert parts per million to milligrams per liter for accurate water analysis and testing."
    lede="Convert ppm (by mass) to mg/L, or mg/L to ppm, using the solution's density."
    about="ppm by mass is mg of solute per kg of solution, while mg/L is per liter. They are linked by density: mg/L = ppm × density (kg/L). For fresh water the density is about 1 kg/L, so the numbers are equal; in seawater (1.025 kg/L) mg/L is 2.5% higher."
    :calc="['engine' => 'ppm-mgl', 'quickRef' => [1, 10, 50, 100, 500, 1000]]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'ppm to mg/L, or mg/L to ppm.'],
        ['name' => 'Set the density', 'text' => 'Leave 0.9982 kg/L for water at 20 °C, or enter your solution\'s density.'],
    ]"
    :faqs="[
        ['question' => 'Is 1 ppm equal to 1 mg/L?', 'answer' => 'For water and dilute water solutions, yes, to within a fraction of a percent.'],
        ['question' => 'When are ppm and mg/L different?', 'answer' => 'When the solution is denser or lighter than water, such as seawater, brine or oils.'],
        ['question' => 'Are µg/mL and g/m³ the same as mg/L?', 'answer' => 'Yes, all three are equal.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['ppm' => 'ppm → mg/L', 'mgl' => 'mg/L → ppm']" selected="ppm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Concentration" value="250" min="0" suffix="ppm" suffix-ref="value-suffix" placeholder="Enter a value" />
        <x-calc.field name="density" label="Solution density" value="0.9982" min="0" suffix="kg/L" placeholder="kg/L" />
    </div>

    <x-calc.result label="Milligrams per liter" />

    <x-calc.options :examples="[
        'Seawater 1.025 kg/L' => ['density' => 1.025],
        'Fresh water' => ['density' => 0.9982],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same concentration in" :rows="[
            'ugml' => ['label' => 'µg/mL (= g/m³)', 'unit' => 'µg/mL'],
            'ppb' => ['label' => 'Parts per billion', 'unit' => 'ppb'],
            'percent' => ['label' => 'Percent by mass', 'unit' => '%'],
            'gl' => ['label' => 'Grams per liter', 'unit' => 'g/L'],
        ]" />
        <x-calc.quick-ref heading="ppm to mg/L at this density" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mg/L = ppm × density (kg/L)</li>
            <li>ppm = mg/L ÷ density (kg/L)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
