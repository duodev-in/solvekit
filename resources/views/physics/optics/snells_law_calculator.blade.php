<x-calc.page
    title="Snell's Law Calculator - SolveKit"
    description="Free Snell's law calculator: angle of refraction between common materials, with critical angle and Fresnel reflectance."
    lede="Solve n₁ sin θ₁ = n₂ sin θ₂."
    about="Light bends toward the normal when it slows down entering a denser medium. Snell’s law links the angles to the refractive indices. Going into a less dense medium beyond the critical angle, light is totally internally reflected."
    :calc="['engine' => 'ph-wave', 'tool' => 'snell', 'fields' => ['m1', 'm1n', 'm2', 'm2n', 't1', 'out'], 'unitFields' => ['t1' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['refractive'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'At what angle does light hitting water at 30° continue?', 'answer' => '22.0365 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="m1" label="Light comes from" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="m1:custom">
            <x-calc.field name="m1n" label="Light comes from: refractive index" value="1.5" min="1" step="any" />
        </div>
        <x-calc.select name="m2" label="Into" :options="['vacuum' => 'Vacuum', 'air' => 'Air (15 °C, 1 atm)', 'water' => 'Water', 'ice' => 'Ice', 'ethanol' => 'Ethanol', 'glycerol' => 'Glycerol', 'silica' => 'Fused silica (quartz glass)', 'acrylic' => 'Acrylic (PMMA)', 'bk7' => 'Crown glass (N-BK7)', 'polycarbonate' => 'Polycarbonate', 'flint' => 'Dense flint glass (SF2)', 'sapphire' => 'Sapphire', 'zirconia' => 'Cubic zirconia', 'diamond' => 'Diamond', 'custom' => 'Other (enter the value)']" selected="water" />
        <div data-show-when="m2:custom">
            <x-calc.field name="m2n" label="Into: refractive index" value="1.5" min="1" step="any" />
        </div>
        <x-calc.field name="t1" label="Angle of incidence" value="30" placeholder="Angle of incidence">
            <label for="calc-t1-unit" class="sr-only">Angle of incidence unit</label>
            <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['deg' => '°', 'rad' => 'rad', 'arcmin' => '′', 'arcsec' => '″', 'mrad' => 'mrad', 'turn' => 'rev']" selected="deg" />
    </div>

    <x-calc.result label="Angle of refraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'deg', 'm1' => 'air', 'm1n' => 1.5, 'm2' => 'water', 'm2n' => 1.5, 't1' => 30, 't1-unit' => 'deg'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Ray diagram" name="rays" />
        <x-calc.rows heading="Details" :rows="[
            'n' => ['label' => 'Refractive indices'],
            'crit' => ['label' => 'Critical angle'],
            'dev' => ['label' => 'Deviation'],
            'R' => ['label' => 'Reflected share (unpolarised)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
