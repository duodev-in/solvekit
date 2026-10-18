<x-calc.page
    title="Roof Truss Calculator - SolveKit"
    description="Free roof truss calculator: number of trusses for a building and the member lengths of king post and Fink (W) trusses."
    lede="Work out how many trusses you need and their member lengths."
    about="Trusses = building length ÷ spacing + 1 (two are gable ends). Member lengths are to the centerlines: top chords run from the heel to the peak plus the overhang, the bottom chord spans the walls, and Fink webs connect the bottom chord third points to the top chord midpoints and the peak. Real trusses are designed and stamped by the truss maker."
    :calc="['engine' => 'con-roof', 'tool' => 'truss', 'fields' => ['length', 'spacing', 'span', 'pitch', 'overhang', 'type'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'spacing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'span' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'overhang' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the building length and spacing', 'text' => 'Usually 24 in on center.'],
        ['name' => 'Enter the span, pitch and type', 'text' => 'For the member lengths.'],
    ]"
    :faqs="[
        ['question' => 'How many trusses for a 40 ft building?', 'answer' => '21 at 24 in on center.'],
        ['question' => 'What is a Fink truss?', 'answer' => 'A W-shaped web truss, the most common house truss for spans up to about 30–40 ft.'],
        ['question' => 'Can I build my own trusses?', 'answer' => 'Codes require engineered trusses or a design; site-built trusses need a stamped design in most places.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Building length" value="40" min="0" placeholder="Building length">
            <label for="calc-length-unit" class="sr-only">Building length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="spacing" label="Truss spacing" value="24" min="0" placeholder="Truss spacing">
            <label for="calc-spacing-unit" class="sr-only">Truss spacing unit</label>
            <select id="calc-spacing-unit" name="spacing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="span" label="Span" value="28" min="0" placeholder="Span">
            <label for="calc-span-unit" class="sr-only">Span unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pitch" label="Pitch (rise per 12)" value="5" min="0.5" step="0.5" />
        <x-calc.field name="overhang" label="Overhang" value="12" min="0" placeholder="Overhang">
            <label for="calc-overhang-unit" class="sr-only">Overhang unit</label>
            <select id="calc-overhang-unit" name="overhang-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.select name="type" label="Truss type" :options="['fink' => 'Fink (W)', 'king' => 'King post']" selected="fink" />

    <x-calc.result label="Trusses" />

    <x-calc.options :examples="[
        '40 ft, 28 ft span Fink' => ['length' => 40, 'length-unit' => 'ft', 'spacing' => 24, 'spacing-unit' => 'in', 'span' => 28, 'span-unit' => 'ft', 'pitch' => 5, 'overhang' => 12, 'overhang-unit' => 'in', 'type' => 'fink'],
        'Shed 12 ft king post' => ['length' => 12, 'length-unit' => 'ft', 'spacing' => 24, 'spacing-unit' => 'in', 'span' => 10, 'span-unit' => 'ft', 'pitch' => 6, 'overhang' => 6, 'overhang-unit' => 'in', 'type' => 'king'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rise' => ['label' => 'Peak height'],
            'top' => ['label' => 'Top chord'],
            'gables' => ['label' => 'Gable ends'],
            'note' => ['label' => 'Design'],
        ]" />
        <x-calc.quick-ref heading="Members (one truss)" name="members" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>trusses = ⌊L ÷ spacing⌋ + 1</li>
            <li>rise = span ÷ 2 × pitch ÷ 12</li>
            <li>Fink webs: (S/4, H/2)–(S/3, 0) and (S/3, 0)–(S/2, H)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
