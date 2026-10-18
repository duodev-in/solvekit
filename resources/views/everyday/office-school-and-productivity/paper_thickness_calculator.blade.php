<x-calc.page
    title="Paper Thickness Calculator - SolveKit"
    description="Free paper thickness calculator: the caliper of one sheet from a stack measurement, or from its weight in GSM and density, in microns, mm and mils."
    lede="Work out how thick a sheet of paper is."
    about="Measuring one sheet is hard, so measure a stack and divide: thickness = stack height ÷ sheets. Or use thickness (µm) = GSM ÷ density (g/cm³); uncoated office paper is about 0.8 g/cm³, so 80 GSM paper is about 100 µm (0.1 mm)."
    :calc="['engine' => 'ev-office', 'tool' => 'paper_thickness', 'fields' => ['mode', 'stack', 'sheets', 'gsm', 'density'], 'unitFields' => ['stack' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Measure a stack', 'text' => 'Or enter GSM and density.'],
    ]"
    :faqs="[
        ['question' => 'How thick is a sheet of printer paper?', 'answer' => 'About 0.1 mm (100 µm, 4 mils) for 80 GSM.'],
        ['question' => 'How thick is a ream?', 'answer' => 'About 50 mm (2 in) for 500 sheets.'],
        ['question' => 'What is a mil?', 'answer' => 'A thousandth of an inch, 25.4 µm.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['stack' => 'A stack', 'gsm' => 'GSM and density']" selected="stack" />

    <div data-show-when="mode:stack">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="stack" label="Stack height" value="50" min="0" placeholder="Stack height">
                <label for="calc-stack-unit" class="sr-only">Stack height unit</label>
                <select id="calc-stack-unit" name="stack-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="sheets" label="Sheets in the stack" value="500" min="1" step="1" />
        </div>
    </div>

    <div data-show-when="mode:gsm" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="gsm" label="Paper weight" value="80" min="1" suffix="GSM" />
            <x-calc.field name="density" label="Density" value="0.8" min="0.1" max="2" step="0.05" suffix="g/cm³" />
        </div>
    </div>

    <x-calc.result label="Paper thickness (caliper)" />

    <x-calc.options :examples="[
        'Ream 50 mm' => ['mode' => 'stack', 'stack' => 50, 'stack-unit' => 'mm', 'sheets' => 500, 'gsm' => '', 'density' => ''],
        '100 cards, 1.2 in' => ['mode' => 'stack', 'stack' => 1.2, 'stack-unit' => 'in', 'sheets' => 100, 'gsm' => '', 'density' => ''],
        '120 GSM' => ['mode' => 'gsm', 'stack' => '', 'stack-unit' => 'mm', 'sheets' => '', 'gsm' => 120, 'density' => 0.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mils' => ['label' => 'In mils'],
            'ream' => ['label' => 'A ream'],
            'note' => ['label' => 'Typical'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>thickness = stack ÷ sheets</li>
            <li>µm = GSM ÷ density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
