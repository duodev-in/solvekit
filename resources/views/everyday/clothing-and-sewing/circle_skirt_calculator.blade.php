<x-calc.page
    title="Circle Skirt Calculator - SolveKit"
    description="Free circle skirt calculator: the waist radius to cut and fabric needed for a full, half or quarter circle skirt."
    lede="Draft a circle skirt from your waist and length."
    about="A full circle skirt is a ring: its inner edge is the waist, so the waist radius = waist ÷ 2π. A half circle uses waist ÷ π and a quarter circle 2 × waist ÷ π. The outer radius adds the skirt length, hem and seam allowances. The skirt is cut in quarter-circle sections, each needing a square of fabric the size of the outer radius."
    :calc="['engine' => 'ev-clothing', 'tool' => 'circle_skirt', 'fields' => ['waist', 'length', 'fraction', 'seam', 'hem', 'fabric'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'seam' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'hem' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'fabric' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter waist and length', 'text' => 'Choose full, half or quarter.'],
        ['name' => 'Enter allowances and fabric width', 'text' => 'For the cutting layout.'],
    ]"
    :faqs="[
        ['question' => 'What is the waist radius for a 28 in waist full circle skirt?', 'answer' => 'About 4.46 in, cut at 3.83 in after the seam allowance.'],
        ['question' => 'How much fabric for a full circle skirt?', 'answer' => 'Four quarter-circle sections, each in a square the size of the outer radius.'],
        ['question' => 'Why cut the waist smaller?', 'answer' => 'The seam allowance at the waist is inside the radius.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="waist" label="Waist" value="28" min="0" placeholder="Waist">
            <label for="calc-waist-unit" class="sr-only">Waist unit</label>
            <select id="calc-waist-unit" name="waist-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Skirt length" value="22" min="0" placeholder="Skirt length">
            <label for="calc-length-unit" class="sr-only">Skirt length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="fraction" label="Skirt" :options="['1' => 'Full circle', '0.5' => 'Half circle', '0.25' => 'Quarter circle']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="seam" label="Waist seam allowance" value="0.625" min="0" placeholder="Waist seam allowance">
            <label for="calc-seam-unit" class="sr-only">Waist seam allowance unit</label>
            <select id="calc-seam-unit" name="seam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hem" label="Hem allowance" value="1" min="0" placeholder="Hem allowance">
            <label for="calc-hem-unit" class="sr-only">Hem allowance unit</label>
            <select id="calc-hem-unit" name="hem-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fabric" label="Fabric width" value="60" min="0" placeholder="Fabric width">
            <label for="calc-fabric-unit" class="sr-only">Fabric width unit</label>
            <select id="calc-fabric-unit" name="fabric-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Waist radius to cut" />

    <x-calc.options :examples="[
        'Full circle, 28 in waist' => ['waist' => 28, 'waist-unit' => 'in', 'length' => 22, 'length-unit' => 'in', 'fraction' => '1', 'seam' => 0.625, 'seam-unit' => 'in', 'hem' => 1, 'hem-unit' => 'in', 'fabric' => 60, 'fabric-unit' => 'in'],
        'Half circle, metric' => ['waist' => 72, 'waist-unit' => 'cm', 'length' => 60, 'length-unit' => 'cm', 'fraction' => '0.5', 'seam' => 1.5, 'seam-unit' => 'cm', 'hem' => 2, 'hem-unit' => 'cm', 'fabric' => 150, 'fabric-unit' => 'cm'],
        'Quarter circle' => ['waist' => 30, 'waist-unit' => 'in', 'length' => 24, 'length-unit' => 'in', 'fraction' => '0.25', 'seam' => 0.5, 'seam-unit' => 'in', 'hem' => 1, 'hem-unit' => 'in', 'fabric' => 45, 'fabric-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'outer' => ['label' => 'Outer radius'],
            'fabric' => ['label' => 'Fabric'],
            'hem' => ['label' => 'Hem length'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = waist ÷ (2π × fraction)</li>
            <li>R = r + length + hem</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
