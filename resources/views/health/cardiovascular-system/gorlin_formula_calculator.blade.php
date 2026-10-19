<x-calc.page
    title="Gorlin Formula Calculator - SolveKit"
    description="Free Gorlin formula calculator: aortic or mitral valve area from cardiac output, heart rate, systolic ejection or diastolic filling period and mean gradient (cardiac catheterisation)."
    lede="Calculate valve area with the Gorlin formula."
    about="Gorlin & Gorlin (1951): area = CO ÷ (HR × SEP or DFP) ÷ (44.3 × C × √mean gradient), with CO in mL/min, the period in seconds per beat and C = 1 for the aortic valve, 0.85 for the mitral. It is used in the catheter lab; low flow makes it less reliable. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'gorlin', 'fields' => ['valve', 'co', 'hr', 'period', 'gradient']]"
    :how-to="[
        ['name' => 'Choose the valve', 'text' => ''],
        ['name' => 'Enter output, rate, period and gradient', 'text' => 'From the catheter study.'],
    ]"
    :faqs="[
        ['question' => 'What aortic valve area gives CO 5 L/min, HR 70, SEP 330 ms and a 45 mmHg mean gradient?', 'answer' => '0.73 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="valve" legend="Valve" :options="['aortic' => 'Aortic', 'mitral' => 'Mitral']" selected="aortic" />
        <x-calc.field name="co" label="Cardiac output" value="5" min="0" step="any" suffix="L/min" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="hr" label="Heart rate" value="70" min="0" max="300" step="1" suffix="bpm" />
        <x-calc.field name="period" label="Ejection (SEP) or filling (DFP) period" value="330" min="0" step="1" suffix="ms/beat" />
        <x-calc.field name="gradient" label="Mean gradient" value="45" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Valve area (Gorlin)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['valve' => 'aortic', 'co' => 5, 'hr' => 70, 'period' => 330, 'gradient' => 45],
        'Mitral' => ['valve' => 'mitral', 'co' => 4.5, 'hr' => 80, 'period' => 400, 'gradient' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'severity' => ['label' => 'Severity'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = CO ÷ (HR × P × 44.3 C √ΔP)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
