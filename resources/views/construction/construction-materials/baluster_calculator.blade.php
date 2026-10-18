<x-calc.page
    title="Baluster Calculator - SolveKit"
    description="Free baluster and spindle spacing calculator: balusters per section and the equal gap between them, checked against the 4 in sphere rule."
    lede="Work out how many balusters or spindles you need and how to space them."
    about="For a clear span S between posts, n balusters of width b leave n + 1 equal gaps of (S − n b) ÷ (n + 1). The calculator picks the fewest balusters that keep every gap under your limit. IRC R312.1.3 requires that a 4 in sphere cannot pass, so gaps must be under 4 in. This also covers spindle spacing."
    :calc="['engine' => 'con-framing', 'tool' => 'baluster', 'fields' => ['span', 'sections', 'baluster', 'max_gap'], 'unitFields' => ['span' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'baluster' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'max_gap' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the clear span', 'text' => 'Between the faces of the posts.'],
        ['name' => 'Enter the baluster width', 'text' => 'And the largest gap you want.'],
    ]"
    :faqs="[
        ['question' => 'How far apart should balusters be?', 'answer' => 'Close enough that a 4 in sphere cannot pass: gaps under 4 in.'],
        ['question' => 'How many balusters for a 6 ft section?', 'answer' => 'With 1½ in balusters: 13, leaving gaps of 3¾ in.'],
        ['question' => 'Are spindles the same as balusters?', 'answer' => 'Yes, spindle is another name for a baluster.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Clear span between posts" value="70" min="0" placeholder="Clear span between posts">
            <label for="calc-span-unit" class="sr-only">Clear span between posts unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sections" label="Sections" value="4" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="baluster" label="Baluster width" value="1.5" min="0" placeholder="Baluster width">
            <label for="calc-baluster-unit" class="sr-only">Baluster width unit</label>
            <select id="calc-baluster-unit" name="baluster-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="max_gap" label="Largest gap allowed" value="3.875" min="0" placeholder="Largest gap allowed">
            <label for="calc-max_gap-unit" class="sr-only">Largest gap allowed unit</label>
            <select id="calc-max_gap-unit" name="max_gap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Balusters" />

    <x-calc.options :examples="[
        '4 sections of 70 in' => ['span' => 70, 'span-unit' => 'in', 'sections' => 4, 'baluster' => 1.5, 'baluster-unit' => 'in', 'max_gap' => 3.875, 'max_gap-unit' => 'in'],
        'Stair section 6 ft, 1¼ in spindles' => ['span' => 72, 'span-unit' => 'in', 'sections' => 1, 'baluster' => 1.25, 'baluster-unit' => 'in', 'max_gap' => 3.875, 'max_gap-unit' => 'in'],
        'Metric 1.8 m, 40 mm' => ['span' => 1.8, 'span-unit' => 'm', 'sections' => 3, 'baluster' => 40, 'baluster-unit' => 'mm', 'max_gap' => 95, 'max_gap-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_section' => ['label' => 'Per section'],
            'gap' => ['label' => 'Gap'],
            'spacing' => ['label' => 'Spacing'],
            'code' => ['label' => 'Code check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = ⌈(S − gap) ÷ (b + gap)⌉</li>
            <li>actual gap = (S − n b) ÷ (n + 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
