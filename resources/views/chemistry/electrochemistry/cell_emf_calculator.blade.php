<x-calc.page
    title="Cell EMF Calculator - SolveKit"
    description="Free cell EMF calculator: standard and actual cell potential from two half-reactions, with ΔG° and K, using CRC standard reduction potentials."
    lede="Work out a cell's electromotive force from two half-reactions."
    about="E°cell = E°cathode − E°anode, with both written as reductions. 172 standard reduction potentials from the CRC Handbook are available, or type your own. With a reaction quotient Q the Nernst equation gives the actual potential. The electrons transferred are the least common multiple of the two half-reactions."
    :calc="['engine' => 'chem-electro', 'tool' => 'cell_emf', 'fields' => ['mode', 'cathode', 'anode', 'e_cathode', 'e_anode', 'electrons', 'q', 'temperature'], 'data' => ['potentials' => config('chemistry_data.potentials')]]"
    :how-to="[
        ['name' => 'Pick the cathode', 'text' => 'Where reduction happens.'],
        ['name' => 'Pick the anode', 'text' => 'Where oxidation happens, as its reduction half-reaction.'],
        ['name' => 'Add Q', 'text' => 'For non-standard conditions.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate E°cell?', 'answer' => 'E°cathode − E°anode, both as reduction potentials.'],
        ['question' => 'What is the Daniell cell potential?', 'answer' => 'Cu²⁺/Cu (0.342 V) against Zn²⁺/Zn (−0.762 V) gives 1.10 V.'],
        ['question' => 'What does a negative E°cell mean?', 'answer' => 'The reaction is not spontaneous and needs an applied voltage.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Potentials" :options="['table' => 'From the table', 'custom' => 'My values']" selected="table" />

    <div data-show-when="mode:table">
        <x-calc.select name="cathode" label="Cathode (reduction)" :options="collect(config('chemistry_data.potentials'))->map(fn ($p) => $p['name'].'  E° '.$p['e'].' V')->all()" selected="copper_50" />
    </div>

    <div data-show-when="mode:table">
        <x-calc.select name="anode" label="Anode (oxidation, written as reduction)" :options="collect(config('chemistry_data.potentials'))->map(fn ($p) => $p['name'].'  E° '.$p['e'].' V')->all()" selected="zinc_167" />
    </div>

    <div data-show-when="mode:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="e_cathode" label="E° cathode" value="0.34" suffix="V" />
            <x-calc.field name="e_anode" label="E° anode" value="-0.76" suffix="V" />
            <x-calc.field name="electrons" label="Electrons n" value="2" min="1" step="1" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q" label="Reaction quotient Q (optional)" value="" min="0" placeholder="1 (standard)" />
        <x-calc.field name="temperature" label="Temperature" value="25" suffix="°C" />
    </div>

    <x-calc.result label="Cell potential" />

    <x-calc.options :examples="[
        'Daniell cell (Zn | Cu)' => ['mode' => 'table', 'cathode' => 'copper_50', 'anode' => 'zinc_167', 'q' => '', 'temperature' => 25],
        'Daniell cell, Q = 0.01' => ['mode' => 'table', 'cathode' => 'copper_50', 'anode' => 'zinc_167', 'q' => 0.01, 'temperature' => 25],
        'Custom values' => ['mode' => 'custom', 'e_cathode' => 0.8, 'e_anode' => -0.44, 'electrons' => 2, 'q' => '', 'temperature' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'standard' => ['label' => 'Standard potential'],
            'gibbs' => ['label' => 'ΔG°'],
            'k' => ['label' => 'Equilibrium constant K'],
            'n' => ['label' => 'Electrons transferred'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E°cell = E°cathode − E°anode</li>
            <li>E = E° − (RT ÷ nF) ln Q</li>
            <li>ΔG° = −nFE°</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
