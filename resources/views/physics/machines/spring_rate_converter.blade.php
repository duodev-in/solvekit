<x-calc.page
    title="Spring Rate Converter - SolveKit"
    description="Free spring rate converter: convert between N/mm, N/m, lbf/in, kgf/mm and more."
    lede="Convert spring rates."
    about="Car and bike suspension makers quote spring rates in lbf/in or kgf/mm; engineers use N/mm. This converts between them."
    :calc="['engine' => 'ph-mach', 'tool' => 'spring_convert', 'fields' => ['k', 'out'], 'unitFields' => ['k' => collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'stiffness'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 500 lbf/in in N/mm?', 'answer' => '87.5634 N/mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="k" label="Spring rate" value="500" min="0" placeholder="Spring rate">
            <label for="calc-k-unit" class="sr-only">Spring rate unit</label>
            <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lbfpin')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['npm' => 'N/m', 'npmm' => 'N/mm', 'knpm' => 'kN/m', 'npcm' => 'N/cm', 'lbfpin' => 'lbf/in', 'lbfpft' => 'lbf/ft', 'kgfpmm' => 'kgf/mm']" selected="npmm" />
    </div>

    <x-calc.result label="Converted spring rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'npmm', 'k' => 500, 'k-unit' => 'lbfpin'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'npm' => ['label' => 'In N/m'],
            'all' => ['label' => 'Every unit'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
