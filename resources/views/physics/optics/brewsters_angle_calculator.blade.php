<x-calc.page
    title="Brewster's Angle Calculator - SolveKit"
    description="Free Brewster's angle calculator: the polarising angle between any two media, from a list or your own refractive indices."
    lede="Find the angle of zero p-reflection."
    about="At Brewster’s angle, tan θ = n₂/n₁, light polarised in the plane of incidence is not reflected at all, so the reflected light is fully polarised. That is why polarised sunglasses cut glare from water and roads."
    :calc="['engine' => 'ph-wave', 'tool' => 'brewster', 'fields' => ['m1', 'm1n', 'm2', 'm2n', 'out'], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['refractive'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is Brewster’s angle from air into crown glass?', 'answer' => '56.5965 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="m1" label="Light comes from" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="m1:custom">
            <x-calc.field name="m1n" label="Light comes from: refractive index" value="1.5" min="1" step="any" />
        </div>
        <x-calc.select name="m2" label="Into" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="bk7" />
        <div data-show-when="m2:custom">
            <x-calc.field name="m2n" label="Into: refractive index" value="1.5" min="1" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Brewster’s angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'm1' => 'air', 'm1n' => 1.5, 'm2' => 'bk7', 'm2n' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'refr' => ['label' => 'Refracted angle'],
            'back' => ['label' => 'Brewster’s angle the other way'],
            'rs' => ['label' => 'Reflectance of s-polarised light there'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
