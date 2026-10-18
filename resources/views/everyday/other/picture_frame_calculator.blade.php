<x-calc.page
    title="Picture Frame Calculator - SolveKit"
    description="Free picture frame calculator: the outside size of a frame, the mat opening, glass size and moulding length for a picture with or without a mat."
    lede="Work out frame, mat and moulding sizes for a picture."
    about="The mat opening is a little smaller than the art so the mat overlaps its edges (often ¼ in each side). The glass and backing are the mat's outer size. The frame's outside adds twice the moulding width less its rabbet (the lip that holds the glass). Moulding is measured along the outside edge; buy about 10% extra for cutting."
    :calc="['engine' => 'ev-care', 'tool' => 'picture_frame', 'fields' => ['art_w', 'art_h', 'mat', 'bottom', 'overlap', 'moulding', 'rabbet'], 'unitFields' => ['art_w' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'art_h' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'mat' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'bottom' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'overlap' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'moulding' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rabbet' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the art size', 'text' => 'Width and height.'],
        ['name' => 'Enter mat and moulding', 'text' => 'Border, overlap and moulding widths.'],
    ]"
    :faqs="[
        ['question' => 'What frame for an 11 × 14 in print with a 2.5 in mat?', 'answer' => 'The glass is 15.5 × 19 in and the outside about 18 × 21.5 in with 1.5 in moulding.'],
        ['question' => 'Why is the mat opening smaller than the art?', 'answer' => 'So the mat holds the edges.'],
        ['question' => 'What is bottom weighting?', 'answer' => 'A slightly wider bottom border, which looks balanced.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="art_w" label="Art width" value="11" min="0" placeholder="Art width">
            <label for="calc-art_w-unit" class="sr-only">Art width unit</label>
            <select id="calc-art_w-unit" name="art_w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="art_h" label="Art height" value="14" min="0" placeholder="Art height">
            <label for="calc-art_h-unit" class="sr-only">Art height unit</label>
            <select id="calc-art_h-unit" name="art_h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="mat" label="Mat border" value="2.5" min="0" placeholder="Mat border">
            <label for="calc-mat-unit" class="sr-only">Mat border unit</label>
            <select id="calc-mat-unit" name="mat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="bottom" label="Extra at the bottom" value="0.5" min="0" placeholder="Extra at the bottom">
            <label for="calc-bottom-unit" class="sr-only">Extra at the bottom unit</label>
            <select id="calc-bottom-unit" name="bottom-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="overlap" label="Mat overlap each side" value="0.25" min="0" placeholder="Mat overlap each side">
            <label for="calc-overlap-unit" class="sr-only">Mat overlap each side unit</label>
            <select id="calc-overlap-unit" name="overlap-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="moulding" label="Moulding width" value="1.5" min="0" placeholder="Moulding width">
            <label for="calc-moulding-unit" class="sr-only">Moulding width unit</label>
            <select id="calc-moulding-unit" name="moulding-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rabbet" label="Rabbet (lip) width" value="0.25" min="0" placeholder="Rabbet (lip) width">
            <label for="calc-rabbet-unit" class="sr-only">Rabbet (lip) width unit</label>
            <select id="calc-rabbet-unit" name="rabbet-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Frame outside size" />

    <x-calc.options :examples="[
        '11 × 14 print, mat' => ['art_w' => 11, 'art_w-unit' => 'in', 'art_h' => 14, 'art_h-unit' => 'in', 'mat' => 2.5, 'mat-unit' => 'in', 'bottom' => 0.5, 'bottom-unit' => 'in', 'overlap' => 0.25, 'overlap-unit' => 'in', 'moulding' => 1.5, 'moulding-unit' => 'in', 'rabbet' => 0.25, 'rabbet-unit' => 'in'],
        'A4 without mat' => ['art_w' => 21, 'art_w-unit' => 'cm', 'art_h' => 29.7, 'art_h-unit' => 'cm', 'mat' => 0, 'mat-unit' => 'cm', 'bottom' => 0, 'bottom-unit' => 'cm', 'overlap' => 0, 'overlap-unit' => 'cm', 'moulding' => 3, 'moulding-unit' => 'cm', 'rabbet' => 0.6, 'rabbet-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'opening' => ['label' => 'Mat opening'],
            'glass' => ['label' => 'Glass and backing'],
            'moulding' => ['label' => 'Moulding'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>opening = art − 2 × overlap</li>
            <li>outside = mat + 2 × (moulding − rabbet)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
