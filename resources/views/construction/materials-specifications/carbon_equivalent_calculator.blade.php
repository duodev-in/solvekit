<x-calc.page
    title="Carbon Equivalent Calculator - SolveKit"
    description="Free carbon equivalent calculator: IIW carbon equivalent and Pcm of a steel from its composition, with weldability guidance."
    lede="Work out the carbon equivalent of a steel for welding."
    about="The International Institute of Welding formula CE = C + Mn/6 + (Cr + Mo + V)/5 + (Ni + Cu)/15 rates how hardenable a steel is, and so how prone to cracking when welded. Pcm (Ito–Bessyo) suits low-carbon steels. The weldability bands shown are common guidance; preheat for a real job comes from the welding procedure (for example AWS D1.1)."
    :calc="['engine' => 'con-mech', 'tool' => 'carbon_equivalent', 'fields' => ['c', 'mn', 'si', 'cr', 'mo', 'v', 'ni', 'cu', 'b']]"
    :how-to="[
        ['name' => 'Enter the composition', 'text' => 'From the mill certificate, in weight %.'],
    ]"
    :faqs="[
        ['question' => 'What is a good carbon equivalent?', 'answer' => 'Below about 0.35–0.40 welds easily without preheat.'],
        ['question' => 'What is the CE of A36 steel?', 'answer' => 'Typically about 0.35–0.45, depending on the heat.'],
        ['question' => 'When is Pcm used?', 'answer' => 'For low-carbon (under about 0.18% C) and microalloyed steels.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="c" label="C" value="0.2" min="0" step="0.01" suffix="%" />
        <x-calc.field name="mn" label="Mn" value="1.0" min="0" step="0.01" suffix="%" />
        <x-calc.field name="si" label="Si" value="0.25" min="0" step="0.01" suffix="%" />
        <x-calc.field name="cr" label="Cr" value="0" min="0" step="0.01" suffix="%" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="mo" label="Mo" value="0" min="0" step="0.01" suffix="%" />
        <x-calc.field name="v" label="V" value="0" min="0" step="0.01" suffix="%" />
        <x-calc.field name="ni" label="Ni" value="0" min="0" step="0.01" suffix="%" />
        <x-calc.field name="cu" label="Cu" value="0" min="0" step="0.01" suffix="%" />
    </div>

    <x-calc.field name="b" label="B" value="0" min="0" step="0.0001" suffix="%" />

    <x-calc.result label="Carbon equivalent" />

    <x-calc.options :examples="[
        'Mild steel' => ['c' => 0.2, 'mn' => 1.0, 'si' => 0.25, 'cr' => 0, 'mo' => 0, 'v' => 0, 'ni' => 0, 'cu' => 0, 'b' => 0],
        '4140' => ['c' => 0.4, 'mn' => 0.88, 'si' => 0.25, 'cr' => 0.95, 'mo' => 0.2, 'v' => 0, 'ni' => 0, 'cu' => 0, 'b' => 0],
        'Pipeline X65' => ['c' => 0.08, 'mn' => 1.45, 'si' => 0.25, 'cr' => 0.03, 'mo' => 0.01, 'v' => 0.04, 'ni' => 0.02, 'cu' => 0.02, 'b' => 0.0003],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pcm' => ['label' => 'Pcm'],
            'guide' => ['label' => 'Weldability'],
            'iiw' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CE(IIW) = C + Mn/6 + (Cr + Mo + V)/5 + (Ni + Cu)/15</li>
            <li>Pcm = C + Si/30 + (Mn + Cu + Cr)/20 + Ni/60 + Mo/15 + V/10 + 5B</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
