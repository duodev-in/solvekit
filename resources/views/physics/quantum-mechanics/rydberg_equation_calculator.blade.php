<x-calc.page
    title="Rydberg Equation Calculator - SolveKit"
    description="Free Rydberg equation calculator: wavelength of hydrogen-like spectral lines from n₁ and n₂."
    lede="Solve the Rydberg formula."
    about="The Rydberg formula predicts every hydrogen line from two integers. Lines with the same lower level form a series."
    :calc="['engine' => 'ph-quantum', 'tool' => 'rydberg', 'fields' => ['n1', 'n2', 'Z', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the wavelength of the 2 → 3 Balmer line?', 'answer' => '656.47 nm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n1" label="Lower level n₁" value="2" min="1" step="any" />
        <x-calc.field name="n2" label="Upper level n₂" value="3" min="1" step="any" />
        <x-calc.field name="Z" label="Nuclear charge Z" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
    </div>

    <x-calc.result label="Wavelength (vacuum)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nm', 'n1' => 2, 'n2' => 3, 'Z' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wn' => ['label' => 'Wavenumber'],
            'series' => ['label' => 'Series'],
            'limit' => ['label' => 'Series limit'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
