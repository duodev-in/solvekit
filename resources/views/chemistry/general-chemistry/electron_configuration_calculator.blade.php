<x-calc.page
    title="Electron Configuration Calculator - SolveKit"
    description="Free electron configuration calculator: full and noble-gas notation, orbital diagram, valence and unpaired electrons for any element or ion, with a practice mode."
    lede="Get the electron configuration of any element or ion, or practise writing one."
    about="Neutral atoms use the measured ground states from the NIST Atomic Spectra Database, so exceptions such as chromium (3d⁵ 4s¹) and copper (3d¹⁰ 4s¹) are right. For cations, electrons leave the highest shell first (Fe²⁺ is [Ar] 3d⁶); anions fill by the Aufbau order. Elements 109 to 118 are predictions."
    :calc="['engine' => 'chem-general', 'tool' => 'electron_config', 'fields' => ['mode', 'element', 'charge', 'answer'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'symbol', 'z', 'configuration', 'predicted'])]]"
    :how-to="[
        ['name' => 'Pick the element', 'text' => 'Add a charge for an ion.'],
        ['name' => 'Read the configuration', 'text' => 'Noble-gas shorthand, full form and orbital boxes.'],
        ['name' => 'Or practise', 'text' => 'Type your answer and check it.'],
    ]"
    :faqs="[
        ['question' => 'Why is chromium 3d⁵ 4s¹?', 'answer' => 'A half-filled d subshell is especially stable, so one 4s electron moves to 3d.'],
        ['question' => 'Which electrons leave first when an atom ionizes?', 'answer' => 'The outermost: for iron the 4s electrons go before 3d.'],
        ['question' => 'What does paramagnetic mean?', 'answer' => 'The atom or ion has unpaired electrons and is drawn into a magnetic field.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Mode" :options="['config' => 'Show configuration', 'practice' => 'Practise']" selected="config" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="element" label="Element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Fe" />
        <x-calc.field name="charge" label="Charge" value="0" step="1" />
    </div>

    <div data-show-when="mode:practice" hidden>
        <x-calc.field name="answer" label="Your answer" value="" type="text" help="Full or noble-gas notation" placeholder="[Ar] 3d6 4s2" />
    </div>

    <x-calc.result label="Electron configuration" />

    <x-calc.options :decimals="false" :examples="[
        'Iron' => ['mode' => 'config', 'element' => 'Fe', 'charge' => 0],
        'Fe³⁺' => ['mode' => 'config', 'element' => 'Fe', 'charge' => 3],
        'Copper' => ['mode' => 'config', 'element' => 'Cu', 'charge' => 0],
        'Practise sulfur' => ['mode' => 'practice', 'element' => 'S', 'charge' => 0, 'answer' => '[Ne] 3s2 3p4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'full' => ['label' => 'Full notation'],
            'valence' => ['label' => 'Valence electrons'],
            'unpaired' => ['label' => 'Unpaired electrons'],
            'magnetism' => ['label' => 'Magnetism'],
        ]" />
        <x-calc.quick-ref heading="Orbital diagram" name="boxes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ground states: NIST Atomic Spectra Database</li>
            <li>cations: remove from highest n, then highest l</li>
            <li>Hund's rule for unpaired electrons</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
