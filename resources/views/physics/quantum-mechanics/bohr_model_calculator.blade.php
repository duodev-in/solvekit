<x-calc.page
    title="Bohr Model Calculator - SolveKit"
    description="Free Bohr model calculator: orbit radius, speed and energy of an electron in hydrogen-like atoms."
    lede="Explore the Bohr atom."
    about="Bohr’s 1913 model puts the electron on circular orbits with quantised angular momentum. It gets hydrogen’s energy levels right: −13.6 eV/n²."
    :calc="['engine' => 'ph-quantum', 'tool' => 'bohr', 'fields' => ['Z', 'n', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the radius of hydrogen’s ground state?', 'answer' => '0.0529177 nm (the Bohr radius).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Z" label="Atomic number Z (hydrogen-like ion)" value="1" min="1" step="any" />
        <x-calc.field name="n" label="Level n" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
    </div>

    <x-calc.result label="Orbit radius" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'Z' => 1, 'n' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'E' => ['label' => 'Energy'],
            'v' => ['label' => 'Electron speed'],
            'T' => ['label' => 'Orbital period'],
            'L' => ['label' => 'Angular momentum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
