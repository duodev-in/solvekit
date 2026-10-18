<x-calc.page
    title="Curtain Panel Calculator - SolveKit"
    description="Free curtain panel calculator: how many curtain panels a window needs for the fullness you want, and the fabric to make them."
    lede="Work out how many curtain panels to buy or sew."
    about="Total curtain width = rod width × fullness: about 1.5× for flat panels, 2× for a standard gathered look and 2.5–3× for sheers. Panels = total width ÷ panel width, rounded up. For sewing, each panel uses one fabric width cut to the finished length plus hems."
    :calc="['engine' => 'ev-clothing', 'tool' => 'curtain_panels', 'fields' => ['width', 'fullness', 'panel', 'length', 'hems'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'panel' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'hems' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the rod width', 'text' => 'Including the extension past the window.'],
        ['name' => 'Choose fullness and panel width', 'text' => 'And length for yardage.'],
    ]"
    :faqs="[
        ['question' => 'How many 54 in panels for an 80 in rod?', 'answer' => '3 panels at 2× fullness.'],
        ['question' => 'What is fullness?', 'answer' => 'How much wider the curtains are than the rod.'],
        ['question' => 'How much fabric per panel?', 'answer' => 'Finished length + hems, one fabric width each.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Rod width" value="80" min="0" placeholder="Rod width">
            <label for="calc-width-unit" class="sr-only">Rod width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="fullness" label="Fullness" value="2" min="1" max="4" step="0.25" suffix="×" />
        <x-calc.field name="panel" label="Panel width (flat)" value="54" min="0" placeholder="Panel width (flat)">
            <label for="calc-panel-unit" class="sr-only">Panel width (flat) unit</label>
            <select id="calc-panel-unit" name="panel-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Finished length (optional)" value="84" min="0" placeholder="Finished length (optional)">
            <label for="calc-length-unit" class="sr-only">Finished length (optional) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hems" label="Top and bottom hems" value="12" min="0" placeholder="Top and bottom hems">
            <label for="calc-hems-unit" class="sr-only">Top and bottom hems unit</label>
            <select id="calc-hems-unit" name="hems-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Panels needed" />

    <x-calc.options :decimals="false" :examples="[
        '80 in rod, 2×' => ['width' => 80, 'width-unit' => 'in', 'fullness' => 2, 'panel' => 54, 'panel-unit' => 'in', 'length' => 84, 'length-unit' => 'in', 'hems' => 12, 'hems-unit' => 'in'],
        'Sheers, 3×' => ['width' => 120, 'width-unit' => 'in', 'fullness' => 3, 'panel' => 54, 'panel-unit' => 'in', 'length' => 96, 'length-unit' => 'in', 'hems' => 10, 'hems-unit' => 'in'],
        'Metric' => ['width' => 200, 'width-unit' => 'cm', 'fullness' => 2, 'panel' => 140, 'panel-unit' => 'cm', 'length' => 250, 'length-unit' => 'cm', 'hems' => 30, 'hems-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pairs' => ['label' => 'Pairs'],
            'fabric' => ['label' => 'Fabric'],
            'fullness' => ['label' => 'Fullness'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>panels = ⌈rod × fullness ÷ panel width⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
