<x-calc.page
    title="Critical Angle Calculator - SolveKit"
    description="Free critical angle calculator: the angle for total internal reflection between two media."
    lede="Find the critical angle."
    about="Inside a dense medium, light hitting the surface beyond the critical angle sin θ_c = n₂/n₁ cannot escape and is totally reflected. That traps light in optical fibres and makes diamonds sparkle."
    :calc="['engine' => 'ph-wave', 'tool' => 'critical_angle', 'fields' => ['m1', 'm1n', 'm2', 'm2n', 'out'], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['refractive'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the critical angle from water to air?', 'answer' => '48.6246 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="m1" label="Dense medium (light inside)" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="water" />
        <div data-show-when="m1:custom">
            <x-calc.field name="m1n" label="Dense medium (light inside): refractive index" value="1.5" min="1" step="any" />
        </div>
        <x-calc.select name="m2" label="Outside medium" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="m2:custom">
            <x-calc.field name="m2n" label="Outside medium: refractive index" value="1.5" min="1" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Critical angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'm1' => 'water', 'm1n' => 1.5, 'm2' => 'air', 'm2n' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cone' => ['label' => 'Escape cone (full angle)'],
            'n' => ['label' => 'Refractive indices'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
