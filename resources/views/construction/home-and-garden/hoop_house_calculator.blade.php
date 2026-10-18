<x-calc.page
    title="Hoop House Calculator - SolveKit"
    description="Free hoop house calculator: number and length of hoops, plastic sheet size and growing area for a hoop house or low tunnel."
    lede="Work out the hoops and plastic for a hoop house or low tunnel."
    about="Each hoop follows half an ellipse across the width with the chosen height (a semicircle when the height is half the width); its length is the exact half-ellipse perimeter, plus any length driven into the ground. Hoops = length ÷ spacing + 1. The plastic must cover the arc plus a burial allowance each side, and the ends."
    :calc="['engine' => 'con-framing', 'tool' => 'hoop_house', 'fields' => ['width', 'height', 'length', 'spacing', 'leg', 'bury'], 'unitFields' => ['width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'spacing' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'leg' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'bury' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the size', 'text' => 'Width, height at the center and length.'],
        ['name' => 'Set the hoop spacing', 'text' => 'And how much goes into the ground.'],
    ]"
    :faqs="[
        ['question' => 'How long is a hoop for a 12 ft wide, 6 ft tall house?', 'answer' => 'A semicircle: 18.85 ft, plus the legs.'],
        ['question' => 'How far apart should hoops be?', 'answer' => '4 ft is common; closer where snow loads are high.'],
        ['question' => 'How big a plastic sheet?', 'answer' => 'The arc plus burial on each side wide, and the length plus both ends long.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Width" value="12" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="6" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Length" value="24" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="spacing" label="Hoop spacing" value="4" min="0" placeholder="Hoop spacing">
            <label for="calc-spacing-unit" class="sr-only">Hoop spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="leg" label="Leg into the ground" value="12" min="0" placeholder="Leg into the ground">
            <label for="calc-leg-unit" class="sr-only">Leg into the ground unit</label>
            <select id="calc-leg-unit" name="leg-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bury" label="Plastic burial each side" value="12" min="0" placeholder="Plastic burial each side">
            <label for="calc-bury-unit" class="sr-only">Plastic burial each side unit</label>
            <select id="calc-bury-unit" name="bury-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Hoops" />

    <x-calc.options :examples="[
        '12 × 24 ft, 6 ft high' => ['width' => 12, 'width-unit' => 'ft', 'height' => 6, 'height-unit' => 'ft', 'length' => 24, 'length-unit' => 'ft', 'spacing' => 4, 'spacing-unit' => 'ft', 'leg' => 12, 'leg-unit' => 'in', 'bury' => 12, 'bury-unit' => 'in'],
        'Low tunnel 4 × 20 ft' => ['width' => 4, 'width-unit' => 'ft', 'height' => 2, 'height-unit' => 'ft', 'length' => 20, 'length-unit' => 'ft', 'spacing' => 5, 'spacing-unit' => 'ft', 'leg' => 8, 'leg-unit' => 'in', 'bury' => 8, 'bury-unit' => 'in'],
        'Metric 5 × 10 m' => ['width' => 5, 'width-unit' => 'm', 'height' => 2.5, 'height-unit' => 'm', 'length' => 10, 'length-unit' => 'm', 'spacing' => 1.2, 'spacing-unit' => 'm', 'leg' => 300, 'leg-unit' => 'mm', 'bury' => 300, 'bury-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hoop' => ['label' => 'Tubing'],
            'plastic' => ['label' => 'Plastic sheet'],
            'floor' => ['label' => 'Growing area'],
            'ends' => ['label' => 'End wall'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hoop = half the perimeter of an ellipse with semi-axes W ÷ 2 and H</li>
            <li>hoops = ⌊L ÷ spacing⌋ + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
