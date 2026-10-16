<x-calc.page
    title="Aquarium Volume Calculator - SolveKit"
    description="Free aquarium volume calculator: gallons and liters for rectangular, cylinder, bow-front and hexagon tanks, with water weight."
    lede="Work out an aquarium's volume in gallons and liters."
    about="Volume is the base area times the water height. Bow-front tanks add the curved front, taken here as a parabolic segment of ⅔ × length × bow depth. Real water volume is lower once gravel, rock and the gap at the top are counted, often about 85%."
    :calc="['engine' => 'animals', 'tool' => 'aquarium', 'fields' => ['shape', 'length', 'width', 'bow', 'diameter', 'side', 'height'], 'unitFields' => ['length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'bow' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'side' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Pick the shape', 'text' => 'Rectangle, cylinder, bow-front or hexagon.'],
        ['name' => 'Measure inside', 'text' => 'Inside dimensions and water height.'],
    ]"
    :faqs="[
        ['question' => 'How many gallons is a 36 × 18 × 16 in tank?', 'answer' => 'About 45 US gallons.'],
        ['question' => 'How heavy is a full aquarium?', 'answer' => 'Water alone is about 8.3 lb per gallon (1 kg per liter), plus glass, gravel and stand.'],
        ['question' => 'Does this count displacement?', 'answer' => 'No; the realistic row allows about 15% for substrate and decor.'],
    ]"
>
    <x-calc.segmented name="shape" legend="Shape" :options="['rectangle' => 'Rectangle', 'cylinder' => 'Cylinder', 'bowfront' => 'Bow-front', 'hexagon' => 'Hexagon']" selected="rectangle" />

    <div data-show-when="shape:rectangle,bowfront">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="length" label="Length" value="36" min="0" placeholder="Length">
                <label for="calc-length-unit" class="sr-only">Length unit</label>
                <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="width" label="Width (back depth)" value="18" min="0" placeholder="Width (back depth)">
                <label for="calc-width-unit" class="sr-only">Width (back depth) unit</label>
                <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="shape:bowfront" hidden>
        <x-calc.field name="bow" label="Bow depth (extra at the center)" value="3" min="0" placeholder="Bow depth (extra at the center)">
            <label for="calc-bow-unit" class="sr-only">Bow depth (extra at the center) unit</label>
            <select id="calc-bow-unit" name="bow-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="shape:cylinder" hidden>
        <x-calc.field name="diameter" label="Diameter" value="24" min="0" placeholder="Diameter">
            <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="shape:hexagon" hidden>
        <x-calc.field name="side" label="Side length" value="12" min="0" placeholder="Side length">
            <label for="calc-side-unit" class="sr-only">Side length unit</label>
            <select id="calc-side-unit" name="side-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="height" label="Water height" value="16" min="0" placeholder="Water height">
        <label for="calc-height-unit" class="sr-only">Water height unit</label>
        <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Tank volume" />

    <x-calc.options :examples="[
        '40 breeder' => ['shape' => 'rectangle', 'length' => 36, 'length-unit' => 'in', 'width' => 18, 'width-unit' => 'in', 'height' => 16, 'height-unit' => 'in'],
        'Cylinder 24 in' => ['shape' => 'cylinder', 'diameter' => 24, 'diameter-unit' => 'in', 'height' => 30, 'height-unit' => 'in'],
        '72-gal bow-front' => ['shape' => 'bowfront', 'length' => 48, 'length-unit' => 'in', 'width' => 15, 'width-unit' => 'in', 'bow' => 4, 'bow-unit' => 'in', 'height' => 22, 'height-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'In liters'],
            'real' => ['label' => 'Realistic water volume'],
            'weight' => ['label' => 'Water weight'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rectangle: L × W × H</li>
            <li>cylinder: π × (D ÷ 2)² × H</li>
            <li>bow-front: (L × W + ⅔ × L × bow) × H</li>
            <li>hexagon: 3√3 ÷ 2 × side² × H</li>
            <li>1 US gal = 3.785 L = 231 in³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
