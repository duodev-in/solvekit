<x-calc.page
    title="Calibration Curve Calculator - SolveKit"
    description="Free calibration curve calculator: least-squares line with R², standard errors, LOD and LOQ, and unknown concentrations."
    lede="Fit a calibration line and read unknown concentrations from it."
    about="An ordinary least-squares line is fitted to your standards. The limits of detection and quantitation use the residual standard deviation: LOD = 3.3σ ÷ slope, LOQ = 10σ ÷ slope (ICH Q2). Unknowns outside the standards' range are flagged as extrapolated."
    :calc="['engine' => 'chem-biochem', 'tool' => 'calibration', 'fields' => ['standards', 'unknowns']]"
    :how-to="[
        ['name' => 'Enter the standards', 'text' => 'Concentration and signal, one per line.'],
        ['name' => 'Enter unknown signals', 'text' => 'To convert to concentrations.'],
    ]"
    :faqs="[
        ['question' => 'What R² is good enough?', 'answer' => 'Usually above 0.995 for analytical work, but also check the residuals.'],
        ['question' => 'How are LOD and LOQ found here?', 'answer' => 'From the residual standard deviation and slope (3.3σ/S and 10σ/S).'],
        ['question' => 'Should I extrapolate?', 'answer' => 'No; dilute or add standards so unknowns fall within range.'],
    ]"
>
    <x-calc.textarea name="standards" label="Standards: concentration and signal" value="0 0.002
1 0.101
2 0.198
4 0.401
8 0.799" help="One pair per line" rows="5" />

    <x-calc.field name="unknowns" label="Unknown signals" value="0.3, 0.55" type="text" help="Separated by commas" />

    <x-calc.result label="Calibration line" />

    <x-calc.options :examples="[
        'Absorbance standards' => ['standards' => '0 0.002
1 0.101
2 0.198
4 0.401
8 0.799', 'unknowns' => '0.3, 0.55'],
        'Protein assay' => ['standards' => '0 0.05
250 0.21
500 0.36
1000 0.66
1500 0.93
2000 1.18', 'unknowns' => '0.5, 0.8'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Calibration plot" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'slope' => ['label' => 'Slope'],
            'intercept' => ['label' => 'Intercept'],
            'lod' => ['label' => 'Limit of detection'],
            'loq' => ['label' => 'Limit of quantitation'],
            'sy' => ['label' => 'Residual SD'],
        ]" />
        <x-calc.quick-ref heading="Unknowns" name="unknowns" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>y = slope × x + intercept (least squares)</li>
            <li>LOD = 3.3σ ÷ S; LOQ = 10σ ÷ S</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
