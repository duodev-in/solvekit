<x-calc.page
    title="MOA Calculator — Minute of Angle - SolveKit"
    description="Free MOA calculator: convert minutes of angle and milliradians to group or adjustment size at any distance."
    lede="Convert MOA to inches or centimetres at range."
    about="A minute of angle is 1/60 of a degree, which covers about 1.047 in at 100 yards. Scope turrets click in ¼ MOA or 0.1 mil steps, so knowing the size an angle covers at a distance tells you how many clicks to adjust."
    :calc="['engine' => 'ph-mech', 'tool' => 'moa', 'fields' => ['angle', 'd', 'out'], 'unitFields' => ['angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How big is 1 MOA at 100 yards?', 'answer' => '1.0472 in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="angle" label="Angle" value="1" placeholder="Angle">
            <label for="calc-angle-unit" class="sr-only">Angle unit</label>
            <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'arcmin')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Distance to target" value="100" placeholder="Distance to target">
            <label for="calc-d-unit" class="sr-only">Distance to target unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'yd')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="in" />
    </div>

    <x-calc.result label="Size at that distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'in', 'angle' => 1, 'angle-unit' => 'arcmin', 'd' => 100, 'd-unit' => 'yd'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'moa' => ['label' => 'In MOA'],
            'mil' => ['label' => 'In milliradians (MIL)'],
            'clicks' => ['label' => 'Quarter-MOA clicks'],
            'ipm' => ['label' => 'One MOA at this distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
