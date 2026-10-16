<x-calc.page
    title="de Broglie Wavelength Calculator - SolveKit"
    description="Free de Broglie wavelength calculator: matter wavelength of electrons, protons, neutrons or any mass from speed or kinetic energy."
    lede="Work out the de Broglie wavelength of a moving particle."
    about="Every moving particle has a wavelength λ = h ÷ p. The momentum is computed relativistically, so fast electrons in microscopes come out right. Particle masses are CODATA 2018 values."
    :calc="['engine' => 'chem-physical', 'tool' => 'de_broglie', 'fields' => ['particle', 'mass', 'mode', 'energy', 'speed']]"
    :how-to="[
        ['name' => 'Pick the particle', 'text' => 'Or enter a mass.'],
        ['name' => 'Enter the energy or speed', 'text' => 'Energy in electronvolts.'],
    ]"
    :faqs="[
        ['question' => 'What is the wavelength of a 100 eV electron?', 'answer' => 'About 122.6 pm, similar to atomic spacings.'],
        ['question' => 'Why do electron microscopes see so small?', 'answer' => 'Their electrons have wavelengths of a few picometres.'],
        ['question' => 'Do everyday objects have a wavelength?', 'answer' => 'Yes, but it is far too small to notice.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="particle" label="Particle" :options="['electron' => 'Electron', 'proton' => 'Proton', 'neutron' => 'Neutron', 'custom' => 'Custom mass']" selected="electron" />
        <div data-show-when="particle:custom" hidden>
            <x-calc.field name="mass" label="Mass" value="1e-26" min="0" suffix="kg" />
        </div>
    </div>

    <x-calc.segmented name="mode" legend="From" :options="['energy' => 'Kinetic energy', 'speed' => 'Speed']" selected="energy" />

    <div data-show-when="mode:energy">
        <x-calc.field name="energy" label="Kinetic energy" value="100" min="0" suffix="eV" />
    </div>

    <div data-show-when="mode:speed" hidden>
        <x-calc.field name="speed" label="Speed" value="1000000.0" min="0" suffix="m/s" />
    </div>

    <x-calc.result label="de Broglie wavelength" />

    <x-calc.options :examples="[
        '100 eV electron' => ['particle' => 'electron', 'mode' => 'energy', 'energy' => 100],
        '200 keV microscope electron' => ['particle' => 'electron', 'mode' => 'energy', 'energy' => 200000],
        'Thermal neutron' => ['particle' => 'neutron', 'mode' => 'energy', 'energy' => 0.025],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'nm' => ['label' => 'In nm'],
            'momentum' => ['label' => 'Momentum'],
            'speed' => ['label' => 'Speed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>λ = h ÷ p</li>
            <li>pc = √(E_k² + 2E_k mc²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
