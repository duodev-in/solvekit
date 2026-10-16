<x-calc.page
    title="Photon Energy Calculator - SolveKit"
    description="Free photon energy calculator: convert between wavelength, frequency and energy in eV, J and kJ/mol, and hydrogen Rydberg transitions."
    lede="Convert between a photon's wavelength, frequency and energy."
    about="E = hf = hc ÷ λ with exact SI constants. For hydrogen, 1/λ = R_H (1/n₁² − 1/n₂²), using the Rydberg constant corrected for the electron–proton reduced mass, which gives the measured vacuum wavelengths (Balmer α: 656.5 nm)."
    :calc="['engine' => 'chem-physical', 'tool' => 'photon_energy', 'fields' => ['mode', 'wavelength', 'frequency', 'energy', 'n1', 'n2']]"
    :how-to="[
        ['name' => 'Pick what you know', 'text' => 'Wavelength, frequency, energy or a hydrogen transition.'],
    ]"
    :faqs="[
        ['question' => 'What is the energy of green light?', 'answer' => 'About 2.4 eV at 520 nm.'],
        ['question' => 'Why does shorter wavelength mean more energy?', 'answer' => 'E = hc ÷ λ, so energy rises as wavelength falls.'],
        ['question' => 'What is the Balmer series?', 'answer' => 'Hydrogen transitions down to n = 2; they are visible light.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['wavelength' => 'Wavelength', 'frequency' => 'Frequency', 'energy' => 'Energy', 'hydrogen' => 'Hydrogen transition']" selected="wavelength" />

    <div data-show-when="mode:wavelength">
        <x-calc.field name="wavelength" label="Wavelength" value="500" min="0" suffix="nm" />
    </div>

    <div data-show-when="mode:frequency" hidden>
        <x-calc.field name="frequency" label="Frequency" value="600000000000000.0" min="0" suffix="Hz" />
    </div>

    <div data-show-when="mode:energy" hidden>
        <x-calc.field name="energy" label="Energy" value="2.5" min="0" suffix="eV" />
    </div>

    <div data-show-when="mode:hydrogen" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="n1" label="Lower level n₁" value="2" min="1" step="1" />
            <x-calc.field name="n2" label="Upper level n₂" value="3" min="2" step="1" />
        </div>
    </div>

    <x-calc.result label="Photon energy" />

    <x-calc.options :examples="[
        'Green light 500 nm' => ['mode' => 'wavelength', 'wavelength' => 500],
        'Balmer α (3 → 2)' => ['mode' => 'hydrogen', 'n1' => 2, 'n2' => 3],
        'Lyman α (2 → 1)' => ['mode' => 'hydrogen', 'n1' => 1, 'n2' => 2],
        'Wi-Fi 2.4 GHz' => ['mode' => 'frequency', 'frequency' => 2400000000.0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'wavelength' => ['label' => 'Wavelength'],
            'frequency' => ['label' => 'Frequency'],
            'joules' => ['label' => 'Energy per photon'],
            'molar' => ['label' => 'Per mole of photons'],
            'wavenumber' => ['label' => 'Wavenumber'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = hc ÷ λ = hf</li>
            <li>1/λ = R_H (1/n₁² − 1/n₂²), R_H = R∞ ÷ (1 + mₑ/mₚ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
