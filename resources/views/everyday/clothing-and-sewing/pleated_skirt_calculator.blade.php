<x-calc.page
    title="Pleated Skirt Calculator - SolveKit"
    description="Free pleated skirt calculator: fabric width and number of pleats for a knife-pleated or box-pleated skirt from waist, pleat width and depth."
    lede="Work out the fabric for a pleated skirt."
    about="The number of pleats = waist ÷ visible pleat width. A knife pleat folds under twice its depth, so each uses its visible width + 2 × depth of fabric; a box pleat folds both ways, using width + 4 × depth. Add seam allowances for the closure."
    :calc="['engine' => 'ev-clothing', 'tool' => 'pleated_skirt', 'fields' => ['waist', 'pleat', 'depth', 'type', 'seam', 'fabric'], 'unitFields' => ['waist' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'pleat' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'seam' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'fabric' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the waist and pleats', 'text' => 'Visible width and depth.'],
        ['name' => 'Choose knife or box', 'text' => 'And the fabric width.'],
    ]"
    :faqs="[
        ['question' => 'How much fabric for a pleated skirt?', 'answer' => 'About 3× the waist for knife pleats as deep as they are wide.'],
        ['question' => 'What is pleat depth?', 'answer' => 'How far the fabric folds under.'],
        ['question' => 'How many pleats for a 28 in waist?', 'answer' => '28 pleats of 1 in.'],
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
        <x-calc.field name="pleat" label="Visible pleat width" value="1" min="0" placeholder="Visible pleat width">
            <label for="calc-pleat-unit" class="sr-only">Visible pleat width unit</label>
            <select id="calc-pleat-unit" name="pleat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="depth" label="Pleat depth" value="1" min="0" placeholder="Pleat depth">
            <label for="calc-depth-unit" class="sr-only">Pleat depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.segmented name="type" legend="Pleats" :options="['knife' => 'Knife', 'box' => 'Box']" selected="knife" />
        <x-calc.field name="seam" label="Seam allowance" value="0.625" min="0" placeholder="Seam allowance">
            <label for="calc-seam-unit" class="sr-only">Seam allowance unit</label>
            <select id="calc-seam-unit" name="seam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
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

    <x-calc.result label="Fabric width around the skirt" />

    <x-calc.options :examples="[
        'Knife pleats, 28 in waist' => ['waist' => 28, 'waist-unit' => 'in', 'pleat' => 1, 'pleat-unit' => 'in', 'depth' => 1, 'depth-unit' => 'in', 'type' => 'knife', 'seam' => 0.625, 'seam-unit' => 'in', 'fabric' => 60, 'fabric-unit' => 'in'],
        'Box pleats' => ['waist' => 30, 'waist-unit' => 'in', 'pleat' => 2, 'pleat-unit' => 'in', 'depth' => 1, 'depth-unit' => 'in', 'type' => 'box', 'seam' => 0.625, 'seam-unit' => 'in', 'fabric' => 45, 'fabric-unit' => 'in'],
        'Metric' => ['waist' => 70, 'waist-unit' => 'cm', 'pleat' => 3, 'pleat-unit' => 'cm', 'depth' => 3, 'depth-unit' => 'cm', 'type' => 'knife', 'seam' => 1.5, 'seam-unit' => 'cm', 'fabric' => 150, 'fabric-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Ratio'],
            'panels' => ['label' => 'Fabric widths'],
            'note' => ['label' => 'Rule'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>knife: n × (w + 2d)</li>
            <li>box: n × (w + 4d)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
