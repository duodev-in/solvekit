<x-calc.page
    title="Atom Calculator - SolveKit"
    description="Free atom calculator: protons, neutrons and electrons of any element, isotope or ion from its atomic number, mass number and charge."
    lede="Find the protons, neutrons and electrons in an atom, isotope or ion."
    about="The atomic number Z is the number of protons and identifies the element. The mass number A is protons plus neutrons, so neutrons = A − Z. A neutral atom has Z electrons; a positive ion has lost electrons and a negative ion has gained them."
    :calc="['engine' => 'chem-general', 'tool' => 'atom', 'fields' => ['element', 'mass_number', 'charge'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'symbol', 'z', 'isotopes'])]]"
    :how-to="[
        ['name' => 'Pick the element', 'text' => 'It sets the number of protons.'],
        ['name' => 'Enter the mass number', 'text' => 'Protons plus neutrons, e.g. 12 for carbon-12.'],
        ['name' => 'Enter the charge', 'text' => '0 for a neutral atom.'],
    ]"
    :faqs="[
        ['question' => 'How do I find the number of neutrons?', 'answer' => 'Subtract the atomic number from the mass number: N = A − Z.'],
        ['question' => 'What changes in an ion?', 'answer' => 'Only the electrons: a 2+ ion has 2 fewer electrons than protons.'],
        ['question' => 'What is an isotope?', 'answer' => 'Atoms of one element with different numbers of neutrons, such as carbon-12 and carbon-14.'],
    ]"
>
    <x-calc.select name="element" label="Element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Na" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mass_number" label="Mass number (A)" value="23" min="1" step="1" />
        <x-calc.field name="charge" label="Charge" value="1" step="1" help="Use a minus sign for anions" />
    </div>

    <x-calc.result label="Protons, neutrons and electrons" />

    <x-calc.options :examples="[
        'Na⁺ (sodium-23)' => ['element' => 'Na', 'mass_number' => 23, 'charge' => 1],
        'Carbon-14' => ['element' => 'C', 'mass_number' => 14, 'charge' => 0],
        'Chloride-35' => ['element' => 'Cl', 'mass_number' => 35, 'charge' => -1],
        'Uranium-235' => ['element' => 'U', 'mass_number' => 235, 'charge' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'protons' => ['label' => 'Protons'],
            'neutrons' => ['label' => 'Neutrons'],
            'electrons' => ['label' => 'Electrons'],
            'nucleons' => ['label' => 'Nucleons'],
            'natural' => ['label' => 'Found in nature'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>protons = Z</li>
            <li>neutrons = A − Z</li>
            <li>electrons = Z − charge</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
