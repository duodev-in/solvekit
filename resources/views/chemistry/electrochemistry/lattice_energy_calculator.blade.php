<x-calc.page
    title="Lattice Energy Calculator - SolveKit"
    description="Free lattice energy calculator: lattice enthalpy of an ionic solid from the Born-Haber cycle."
    lede="Work out the lattice energy of an ionic solid with the Born–Haber cycle."
    about="By Hess's law the enthalpy of formation equals the sum of each step: subliming the metal, ionizing it, splitting the nonmetal molecule into atoms, adding electrons to them, and bringing the gaseous ions together (the lattice enthalpy). The calculation is exact for the values you enter; estimates such as the Kapustinskii equation are not used."
    :calc="['engine' => 'chem-electro', 'tool' => 'lattice_energy', 'fields' => ['formation', 'sublimation', 'ionization', 'affinity', 'bond', 'nonmetal_atoms']]"
    :how-to="[
        ['name' => 'Enter each step', 'text' => 'In kJ/mol, with signs.'],
        ['name' => 'Set the nonmetal atoms', 'text' => 'Each needs half an X₂ bond.'],
    ]"
    :faqs="[
        ['question' => 'What is the lattice energy of NaCl?', 'answer' => 'About −786 kJ/mol as a formation enthalpy (+786 to break it apart).'],
        ['question' => 'Why is it negative here?', 'answer' => 'It is the enthalpy of forming the solid from gaseous ions, which releases energy.'],
        ['question' => 'Why does MgO have a much larger lattice energy?', 'answer' => 'Its ions carry 2+ and 2− charges and are small, so they attract much more strongly.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="formation" label="Enthalpy of formation ΔfH°" value="-411" suffix="kJ/mol" />
        <x-calc.field name="sublimation" label="Sublimation of the metal" value="107" suffix="kJ/mol" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ionization" label="Ionization energy (total)" value="496" suffix="kJ/mol" help="Sum of every ionization step" />
        <x-calc.field name="affinity" label="Electron affinity (total)" value="-349" suffix="kJ/mol" help="Negative when energy is released" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bond" label="Bond energy of X₂" value="242" min="0" suffix="kJ/mol" />
        <x-calc.field name="nonmetal_atoms" label="Nonmetal atoms per formula" value="1" min="1" step="1" help="1 for NaCl, 2 for MgCl₂" />
    </div>

    <x-calc.result label="Lattice enthalpy" />

    <x-calc.options :examples="[
        'Sodium chloride' => ['formation' => -411, 'sublimation' => 107, 'ionization' => 496, 'affinity' => -349, 'bond' => 242, 'nonmetal_atoms' => 1],
        'Magnesium chloride' => ['formation' => -641, 'sublimation' => 148, 'ionization' => 2188, 'affinity' => -698, 'bond' => 242, 'nonmetal_atoms' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dissociation' => ['label' => 'Lattice dissociation enthalpy'],
            'check' => ['label' => 'Cycle check'],
        ]" />
        <x-calc.quick-ref heading="Born–Haber cycle" name="cycle" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>U = ΔfH° − (ΔsubH + IE + n × ½D + EA)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
