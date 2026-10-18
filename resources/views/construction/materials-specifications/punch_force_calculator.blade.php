<x-calc.page
    title="Punch Force Calculator - SolveKit"
    description="Free punch force calculator: tonnage to punch a round, rectangular or any hole in sheet metal from perimeter, thickness and shear strength."
    lede="Work out the press tonnage to punch a hole."
    about="Punch force = cut perimeter × sheet thickness × shear strength. Aluminum shear strengths are Aluminum Association typical values; for steels the calculator uses 80% of the specified minimum tensile strength, a common press-shop convention. Stripping the punch takes about another 10–20%."
    :calc="['engine' => 'con-mech', 'tool' => 'punch_force', 'fields' => ['hole', 'diameter', 'length', 'width', 'perimeter', 'thickness', 'material', 'shear'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'perimeter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'shear' => collect(config('units.pressure'))->only(['psi', 'ksi', 'mpa'])->all()], 'data' => ['shear' => config('construction_data.shear')]]"
    :how-to="[
        ['name' => 'Choose the hole shape', 'text' => 'And its size.'],
        ['name' => 'Enter the thickness and material', 'text' => 'Or a shear strength.'],
    ]"
    :faqs="[
        ['question' => 'How many tons to punch ½ in in ⅛ in mild steel?', 'answer' => 'About 4.6 US tons.'],
        ['question' => 'Why does a square hole take more?', 'answer' => 'It has a longer perimeter than a round hole of the same width.'],
        ['question' => 'What about stainless?', 'answer' => 'Its higher strength needs roughly 30% more force than mild steel.'],
    ]"
>
    <x-calc.select name="hole" label="Hole" :options="['round' => 'Round', 'rect' => 'Rectangle or square', 'custom' => 'Any shape (perimeter)']" selected="round" />

    <div data-show-when="hole:round">
        <x-calc.field name="diameter" label="Diameter" value="0.5" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="hole:rect" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Length" value="1" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width" value="0.5" min="0" placeholder="Width">
                <label for="calc-width-unit" class="sr-only">Width unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="hole:custom" hidden>
        <x-calc.field name="perimeter" label="Perimeter" value="3" min="0" placeholder="Perimeter">
            <label for="calc-perimeter-unit" class="sr-only">Perimeter unit</label>
            <select id="calc-perimeter-unit" name="perimeter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="thickness" label="Sheet thickness" value="0.125" min="0" placeholder="Sheet thickness">
            <label for="calc-thickness-unit" class="sr-only">Sheet thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="material" label="Material" :options="collect(config('construction_data.shear'))->map(fn ($s) => $s['name'])->all() + ['custom' => 'My shear strength']" selected="mild_steel" />
    </div>

    <div data-show-when="material:custom" hidden>
        <x-calc.field name="shear" label="Shear strength" value="50" min="0" placeholder="Shear strength">
            <label for="calc-shear-unit" class="sr-only">Shear strength unit</label>
            <select id="calc-shear-unit" name="shear-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['psi', 'ksi', 'mpa']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ksi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Punch force" />

    <x-calc.options :examples="[
        '½ in in ⅛ in mild steel' => ['hole' => 'round', 'diameter' => 0.5, 'diameter-unit' => 'in', 'thickness' => 0.125, 'thickness-unit' => 'in', 'material' => 'mild_steel'],
        'Square 1 in in 304' => ['hole' => 'rect', 'length' => 1, 'length-unit' => 'in', 'width' => 1, 'width-unit' => 'in', 'thickness' => 0.0625, 'thickness-unit' => 'in', 'material' => 'stainless_304'],
        '10 mm in 3 mm 5052' => ['hole' => 'round', 'diameter' => 10, 'diameter-unit' => 'mm', 'thickness' => 3, 'thickness-unit' => 'mm', 'material' => 'al_5052_h32'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kn' => ['label' => 'Kilonewtons'],
            'metric' => ['label' => 'Metric tons'],
            'lbf' => ['label' => 'Pounds-force'],
            'stripping' => ['label' => 'Stripping force'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>F = perimeter × thickness × shear strength</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
