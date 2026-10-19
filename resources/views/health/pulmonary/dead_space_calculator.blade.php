<x-calc.page
    title="Dead Space Calculator - SolveKit"
    description="Free dead space calculator: physiological dead space fraction (Vd/Vt) by the Bohr–Enghoff equation from arterial and mixed expired CO₂."
    lede="Calculate dead space ventilation."
    about="Bohr–Enghoff: Vd/Vt = (PaCO₂ − PECO₂) ÷ PaCO₂, where PECO₂ is the mixed expired CO₂. Normal Vd/Vt is about 0.2–0.35; in ARDS, higher values are linked to higher mortality (Nuckton et al. 2002). Anatomical dead space is roughly 2 mL per kg of ideal body weight. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'dead_space', 'fields' => ['paco2', 'peco2', 'vt']]"
    :how-to="[
        ['name' => 'Enter PaCO₂ and PECO₂', 'text' => ''],
        ['name' => 'Add tidal volume', 'text' => 'For the volume in mL.'],
    ]"
    :faqs="[
        ['question' => 'What is Vd/Vt with PaCO₂ 40 and PECO₂ 28?', 'answer' => '0.30.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="paco2" label="PaCO₂" value="40" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="peco2" label="Mixed expired PECO₂" value="28" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="vt" label="Tidal volume (optional)" value="500" min="0" step="1" suffix="mL" />
    </div>

    <x-calc.result label="Dead space fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['paco2' => 40, 'peco2' => 28, 'vt' => 500],
        'ARDS' => ['paco2' => 50, 'peco2' => 18, 'vt' => 420],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'vd' => ['label' => 'Dead space volume'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Vd/Vt = (PaCO₂ − PECO₂) ÷ PaCO₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
