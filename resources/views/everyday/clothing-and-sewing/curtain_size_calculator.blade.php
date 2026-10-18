<x-calc.page
    title="Curtain Size Calculator - SolveKit"
    description="Free curtain size calculator: curtain length and width for a window, from where the rod hangs to sill, apron, floor or puddle length."
    lede="Work out the curtain size for a window."
    about="Hang the rod about 4 inches above the window (higher makes a window look taller) and extend it 3–10 inches past each side. Length runs from the rod to the chosen finish: ½ in above the sill, 4 in below it (apron), ½ in above the floor, or 6 in of pooling. Width = rod width × fullness."
    :calc="['engine' => 'ev-clothing', 'tool' => 'curtain_size', 'fields' => ['width', 'height', 'extension', 'above', 'sill_to_floor', 'style', 'fullness'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'extension' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'above' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'sill_to_floor' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the window', 'text' => 'And the sill to the floor.'],
        ['name' => 'Choose the length style', 'text' => 'And fullness.'],
    ]"
    :faqs="[
        ['question' => 'How long should curtains be?', 'answer' => 'Floor-length curtains end about ½ in above the floor.'],
        ['question' => 'What length for a 60 in window, sill 30 in from the floor?', 'answer' => '93.5 in from a rod 4 in above it: buy 95 in.'],
        ['question' => 'How wide should a curtain rod be?', 'answer' => 'About 3–10 in past each side of the window.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width" label="Window width" value="48" min="0" placeholder="Window width">
            <label for="calc-width-unit" class="sr-only">Window width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Window height" value="60" min="0" placeholder="Window height">
            <label for="calc-height-unit" class="sr-only">Window height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="extension" label="Rod past each side" value="6" min="0" placeholder="Rod past each side">
            <label for="calc-extension-unit" class="sr-only">Rod past each side unit</label>
            <select id="calc-extension-unit" name="extension-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="above" label="Rod above the window" value="4" min="0" placeholder="Rod above the window">
            <label for="calc-above-unit" class="sr-only">Rod above the window unit</label>
            <select id="calc-above-unit" name="above-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="sill_to_floor" label="Sill to floor" value="30" min="0" placeholder="Sill to floor">
            <label for="calc-sill_to_floor-unit" class="sr-only">Sill to floor unit</label>
            <select id="calc-sill_to_floor-unit" name="sill_to_floor-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="style" label="Length" :options="['sill' => 'Sill', 'apron' => 'Apron (below the sill)', 'floor' => 'Floor', 'puddle' => 'Puddle']" selected="floor" />
        <x-calc.field name="fullness" label="Fullness" value="2" min="1" max="4" step="0.25" suffix="×" />
    </div>

    <x-calc.result label="Curtain length" />

    <x-calc.options :examples="[
        'Floor length' => ['width' => 48, 'width-unit' => 'in', 'height' => 60, 'height-unit' => 'in', 'extension' => 6, 'extension-unit' => 'in', 'above' => 4, 'above-unit' => 'in', 'sill_to_floor' => 30, 'sill_to_floor-unit' => 'in', 'style' => 'floor', 'fullness' => 2],
        'Sill length' => ['width' => 36, 'width-unit' => 'in', 'height' => 40, 'height-unit' => 'in', 'extension' => 4, 'extension-unit' => 'in', 'above' => 3, 'above-unit' => 'in', 'sill_to_floor' => '', 'sill_to_floor-unit' => 'in', 'style' => 'sill', 'fullness' => 2],
        'Puddle, metric' => ['width' => 150, 'width-unit' => 'cm', 'height' => 180, 'height-unit' => 'cm', 'extension' => 15, 'extension-unit' => 'cm', 'above' => 15, 'above-unit' => 'cm', 'sill_to_floor' => 70, 'sill_to_floor-unit' => 'cm', 'style' => 'puddle', 'fullness' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rod' => ['label' => 'Rod'],
            'width' => ['label' => 'Curtain width'],
            'note' => ['label' => 'Standard lengths'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>length = rod height above window + window + finish</li>
            <li>width = (window + 2 × extension) × fullness</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
