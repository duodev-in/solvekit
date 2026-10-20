<x-calc.page
    title="Hydrogen Energy Levels Calculator - SolveKit"
    description="Free hydrogen energy levels calculator: level energies, photon energy and wavelength for any transition."
    lede="Find hydrogen transition wavelengths."
    about="Hydrogen’s levels are −13.6 eV/n². Jumps between them emit the Lyman, Balmer and Paschen series; the reduced-mass correction matches the measured lines."
    :calc="['engine' => 'ph-quantum', 'tool' => 'hydrogen_levels', 'fields' => ['n1', 'n2', 'Z', 'reduced', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What wavelength is the 3 → 2 transition?', 'answer' => '656.47 nm in vacuum (Hα).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n1" label="Lower level" value="2" min="1" step="any" />
        <x-calc.field name="n2" label="Upper level" value="3" min="1" step="any" />
        <x-calc.field name="Z" label="Nuclear charge Z" value="1" min="1" step="any" />
        <x-calc.select name="reduced" label="Nucleus" :options="['h' => 'Hydrogen (reduced-mass correction)', 'inf' => 'Infinitely heavy (R∞)']" selected="h" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
    </div>

    <x-calc.result label="Transition wavelength (vacuum)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'n1' => 2, 'n2' => 3, 'Z' => 1, 'reduced' => 'h'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'E1' => ['label' => 'Energy of the lower level'],
            'E2' => ['label' => 'Energy of the upper level'],
            'dE' => ['label' => 'Photon energy'],
            'series' => ['label' => 'Series'],
            'band' => ['label' => 'Region'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
