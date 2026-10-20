<x-calc.page
    title="Aperture Area Calculator - SolveKit"
    description="Free aperture area calculator: light-collecting area of a telescope or lens, with central obstruction and light grasp."
    lede="Find how much light an aperture gathers."
    about="Light collected scales with aperture area, π(D² − d²)/4, where d is any central obstruction such as a secondary mirror. A 200 mm telescope gathers over 800 times the light of a 7 mm dark-adapted eye."
    :calc="['engine' => 'ph-wave', 'tool' => 'aperture_area', 'fields' => ['mode', 'D', 'f', 'N', 'obs', 'out'], 'unitFields' => ['D' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'obs' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a 200 mm aperture?', 'answer' => '314.159 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['d' => 'The aperture diameter', 'fn' => 'Focal length and f-number']" selected="d" />
        <div data-show-when="mode:d">
            <x-calc.field name="D" label="Aperture diameter" value="200" placeholder="Aperture diameter">
                <label for="calc-D-unit" class="sr-only">Aperture diameter unit</label>
                <select id="calc-D-unit" name="D-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:fn">
            <x-calc.field name="f" label="Focal length" value="1000" placeholder="Focal length">
                <label for="calc-f-unit" class="sr-only">Focal length unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:fn">
            <x-calc.field name="N" label="f-number" value="5" min="0" step="any" />
        </div>
        <x-calc.field name="obs" label="Central obstruction diameter" value="0" placeholder="Central obstruction diameter">
            <label for="calc-obs-unit" class="sr-only">Central obstruction diameter unit</label>
            <select id="calc-obs-unit" name="obs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="cm2" />
    </div>

    <x-calc.result label="Light-collecting area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm2', 'mode' => 'd', 'D' => 200, 'D-unit' => 'mm', 'f' => 1000, 'f-unit' => 'mm', 'N' => 5, 'obs' => 0, 'obs-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'D' => ['label' => 'Aperture diameter'],
            'eye' => ['label' => 'Light grasp compared with a 7 mm eye pupil'],
            'mag' => ['label' => 'Approximate limiting magnitude'],
            'lost' => ['label' => 'Area lost to the obstruction'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
