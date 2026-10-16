<x-calc.page
    title="Two-Photon Absorption Calculator - SolveKit"
    description="Free two-photon absorption calculator: convert between the absorption coefficient β (cm/GW) and cross-section σ₂ in Göppert-Mayer units."
    lede="Convert between two-photon absorption coefficient and cross-section."
    about="The two-photon cross-section σ₂ = ħω β ÷ N links the macroscopic coefficient β (cm/GW) to a molecular property, where ħω is the photon energy and N the number density. 1 GM (Göppert-Mayer) = 10⁻⁵⁰ cm⁴·s per photon."
    :calc="['engine' => 'chem-physical', 'tool' => 'two_photon', 'fields' => ['direction', 'wavelength', 'density', 'beta', 'sigma']]"
    :how-to="[
        ['name' => 'Choose the direction', 'text' => 'β to σ₂ or back.'],
        ['name' => 'Enter the wavelength and density', 'text' => 'Concentration as molecules per cm³.'],
    ]"
    :faqs="[
        ['question' => 'What is a GM unit?', 'answer' => '10⁻⁵⁰ cm⁴·s per photon, named after Maria Göppert-Mayer.'],
        ['question' => 'What are typical values?', 'answer' => 'Common dyes are 1 to 100 GM; optimized two-photon dyes reach thousands.'],
        ['question' => 'How do I get the number density?', 'answer' => 'Molarity × 6.022 × 10²⁰ per cm³ per mol/L.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['beta' => 'β → σ₂', 'sigma' => 'σ₂ → β']" selected="beta" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wavelength" label="Laser wavelength" value="800" min="0" suffix="nm" />
        <x-calc.field name="density" label="Number density" value="6.022e+19" min="0" suffix="molecules/cm³" help="0.1 M is 6.022 × 10¹⁹" />
    </div>

    <div data-show-when="direction:beta">
        <x-calc.field name="beta" label="β" value="0.01" min="0" suffix="cm/GW" />
    </div>

    <div data-show-when="direction:sigma" hidden>
        <x-calc.field name="sigma" label="σ₂" value="100" min="0" suffix="GM" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'β = 0.01 cm/GW at 0.1 M' => ['direction' => 'beta', 'wavelength' => 800, 'density' => 6.022e+19, 'beta' => 0.01],
        'σ₂ = 100 GM' => ['direction' => 'sigma', 'wavelength' => 800, 'density' => 6.022e+19, 'sigma' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'photon' => ['label' => 'Photon energy'],
            'si' => ['label' => 'In SI units'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>σ₂ = ħω β ÷ N</li>
            <li>1 GM = 10⁻⁵⁰ cm⁴·s</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
