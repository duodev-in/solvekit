<x-calc.page
    title="Critical Damping Calculator - SolveKit"
    description="Free critical damping calculator: c_c = 2√(km) for a mass–spring system."
    lede="Find the critical damping coefficient."
    about="Critical damping is the smallest damping that stops a system oscillating; it returns to rest fastest. Car suspensions are tuned below it, door closers near it."
    :calc="['engine' => 'ph-wave', 'tool' => 'critical_damping', 'fields' => ['solve', 'cc', 'k', 'm', 'out_k', 'out_m'], 'unitFields' => ['k' => collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['cc', 'energy', 'force', 'length', 'mass', 'speed', 'stiffness'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is c_c for 1 kg on a 100 N/m spring?', 'answer' => '20 N·s/m.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['cc' => 'Critical damping coefficient (N·s/m)', 'k' => 'Spring constant', 'm' => 'Mass']" selected="cc" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:k,m" hidden>
            <x-calc.field name="cc" label="Critical damping coefficient (N·s/m)" value="20" step="any" />
        </div>
        <div data-show-when="solve:cc,m">
            <x-calc.field name="k" label="Spring constant" value="100" min="0" placeholder="Spring constant">
                <label for="calc-k-unit" class="sr-only">Spring constant unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'npm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:cc,k">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:k" hidden>
            <x-calc.select name="out_k" label="Show the result in" :options="['npm' => 'N/m', 'npmm' => 'N/mm', 'knpm' => 'kN/m', 'npcm' => 'N/cm', 'lbfpin' => 'lbf/in', 'lbfpft' => 'lbf/ft', 'kgfpmm' => 'kgf/mm']" selected="npm" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
    </div>

    <x-calc.result label="Critical damping coefficient (N·s/m)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'cc', 'cc' => 20, 'k' => 100, 'k-unit' => 'npm', 'out_k' => 'npm', 'm' => 1, 'm-unit' => 'kg', 'out_m' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'wn' => ['label' => 'Natural frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>c_c = 2 √(k m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
