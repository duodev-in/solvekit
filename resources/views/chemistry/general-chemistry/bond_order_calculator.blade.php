<x-calc.page
    title="Bond Order Calculator - SolveKit"
    description="Free bond order calculator: bond order, MO configuration and magnetism of diatomic molecules and ions from molecular orbital theory."
    lede="Find the bond order of a diatomic molecule or ion."
    about="Bond order is (bonding − antibonding electrons) ÷ 2 in molecular orbital theory. This covers diatomics of two period-1 atoms (H, He) or two period-2 atoms (Li to Ne), including ions such as O₂⁻ and CN⁻. Up to 14 electrons (N₂) the π2p orbitals lie below σ2p; from O₂ on, σ2p lies lower."
    :calc="['engine' => 'chem-general', 'tool' => 'bond_order', 'fields' => ['mode', 'molecule', 'bonding', 'antibonding'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'z', 'period'])]]"
    :how-to="[
        ['name' => 'Enter the molecule', 'text' => 'Write molecular ions with ^, e.g. O2^- or H2^+.'],
        ['name' => 'Or the electron counts', 'text' => 'From an MO diagram.'],
    ]"
    :faqs="[
        ['question' => 'What is the bond order of O₂?', 'answer' => '2, with two unpaired electrons, so oxygen is paramagnetic.'],
        ['question' => 'Why is He₂ not stable?', 'answer' => 'Its bonding and antibonding electrons cancel, giving bond order 0.'],
        ['question' => 'Does a higher bond order mean a stronger bond?', 'answer' => 'Generally yes: higher bond order means shorter, stronger bonds.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['molecule' => 'Molecule or ion', 'counts' => 'Electron counts']" selected="molecule" />

    <div data-show-when="mode:molecule">
        <x-calc.field name="molecule" label="Molecule or ion" value="O2" type="text" help="e.g. O2, N2, CO, NO, CN-, O2^2-, H2^+" />
    </div>

    <div data-show-when="mode:counts" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="bonding" label="Bonding electrons" value="8" min="0" step="1" />
            <x-calc.field name="antibonding" label="Antibonding electrons" value="4" min="0" step="1" />
        </div>
    </div>

    <x-calc.result label="Bond order" />

    <x-calc.options :decimals="false" :examples="[
        'O₂' => ['mode' => 'molecule', 'molecule' => 'O2'],
        'N₂' => ['mode' => 'molecule', 'molecule' => 'N2'],
        'NO' => ['mode' => 'molecule', 'molecule' => 'NO'],
        'O₂²⁻ (peroxide)' => ['mode' => 'molecule', 'molecule' => 'O2^2-'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mo' => ['label' => 'MO configuration (valence)'],
            'unpaired' => ['label' => 'Unpaired electrons'],
            'magnetism' => ['label' => 'Magnetism'],
        ]" />
        <x-calc.quick-ref heading="Molecular orbitals" name="levels" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bond order = (bonding − antibonding) ÷ 2</li>
            <li>filling up to N₂: σ2s σ*2s π2p σ2p π*2p σ*2p</li>
            <li>from O₂: σ2s σ*2s σ2p π2p π*2p σ*2p</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
