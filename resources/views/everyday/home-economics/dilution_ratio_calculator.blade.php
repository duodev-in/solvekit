<x-calc.page
    title="Dilution Ratio Calculator - SolveKit"
    description="Free dilution ratio calculator: how much concentrate and water to mix for a 1:10, 1:32 or any dilution ratio, for cleaners, sprays and garden products."
    lede="Mix a cleaner or concentrate at the right ratio."
    about="A ratio of 1:10 here means 1 part concentrate to 10 parts water, 11 parts in all, so concentrate = total ÷ 11. Some labels instead write the total parts (1 in 10); check yours. For chemistry dilutions by concentration, use the Chemistry section's dilution calculators."
    :calc="['engine' => 'ev-home', 'tool' => 'dilution', 'fields' => ['ratio', 'mode', 'total', 'concentrate'], 'unitFields' => ['total' => collect(config('units.volume'))->only(['floz_us', 'ml', 'l'])->all(), 'concentrate' => collect(config('units.volume'))->only(['floz_us', 'ml', 'l'])->all()]]"
    :how-to="[
        ['name' => 'Enter the ratio', 'text' => '1 : parts of water.'],
        ['name' => 'Enter the total or the concentrate', 'text' => 'In your units.'],
    ]"
    :faqs="[
        ['question' => 'How much concentrate for a 32 oz bottle at 1:10?', 'answer' => '2.91 fl oz (86 mL) with 29.1 fl oz of water.'],
        ['question' => 'What does 1:32 mean?', 'answer' => '1 part concentrate to 32 parts water, about 3% concentrate.'],
        ['question' => 'Is 1:10 the same as 10%?', 'answer' => 'No: 1:10 is 1 part in 11, about 9.1%.'],
    ]"
>
    <x-calc.field name="ratio" label="Ratio 1 :" value="10" min="0.01" step="0.5" suffix="parts water" />

    <x-calc.segmented name="mode" legend="I know" :options="['total' => 'Total mix wanted', 'concentrate' => 'Amount of concentrate']" selected="total" />

    <div data-show-when="mode:total">
        <x-calc.field name="total" label="Total mix" value="32" min="0" placeholder="Total mix">
            <label for="calc-total-unit" class="sr-only">Total mix unit</label>
            <select id="calc-total-unit" name="total-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['floz_us', 'ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'floz_us')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:concentrate" hidden>
        <x-calc.field name="concentrate" label="Concentrate" value="100" min="0" placeholder="Concentrate">
            <label for="calc-concentrate-unit" class="sr-only">Concentrate unit</label>
            <select id="calc-concentrate-unit" name="concentrate-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['floz_us', 'ml', 'l']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Concentrate" />

    <x-calc.options :examples="[
        '32 oz spray, 1:10' => ['ratio' => 10, 'mode' => 'total', 'total' => 32, 'total-unit' => 'floz_us', 'concentrate' => '', 'concentrate-unit' => 'ml'],
        '1 gallon at 1:64' => ['ratio' => 64, 'mode' => 'total', 'total' => 3.785, 'total-unit' => 'l', 'concentrate' => '', 'concentrate-unit' => 'ml'],
        '100 mL concentrate at 1:20' => ['ratio' => 20, 'mode' => 'concentrate', 'total' => '', 'total-unit' => 'floz_us', 'concentrate' => 100, 'concentrate-unit' => 'ml'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water'],
            'concentrate' => ['label' => 'Concentrate in fl oz'],
            'total' => ['label' => 'Total'],
            'percent' => ['label' => 'Strength'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>concentrate = total ÷ (1 + parts water)</li>
            <li>water = concentrate × parts water</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
