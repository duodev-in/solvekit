<x-calc.page
    title="Fetal Weight Percentile Calculator - SolveKit"
    description="Free fetal weight percentile calculator: estimated fetal weight percentile by gestational age (Hadlock), from an ultrasound weight or a guided entry of the four measurements."
    lede="Find the percentile of an estimated fetal weight."
    about="The percentile compares the estimated fetal weight with the Hadlock (1991) in-utero standard: ln(median weight) = 0.578 + 0.332 × weeks − 0.00354 × weeks², with a standard deviation of 12.7%. The guided mode first estimates weight from head and abdominal circumference, femur length and biparietal diameter (Hadlock 1985). Below the 10th percentile is small for gestational age and above the 90th large. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'fetal_weight', 'fields' => ['mode', 'weeks', 'days', 'efw', 'hc', 'ac', 'fl', 'bpd'], 'unitFields' => ['hc' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'ac' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'fl' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'bpd' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Enter gestational age', 'text' => ''],
        ['name' => 'Enter the estimated weight, or the four measurements', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What percentile is 1,900 g at 32 weeks?', 'answer' => '42nd percentile.'],
        ['question' => 'And from HC 29.5, AC 28, FL 6.2 and BPD 8.2 cm?', 'answer' => '1925 g at 32 weeks 0 days; median 1953 g (Hadlock 1991).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Start from" :options="['efw' => 'Estimated weight', 'biometry' => 'Guide me (ultrasound measurements)']" selected="efw" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weeks" label="Gestational age (weeks)" value="32" min="10" max="41" step="1" />
        <x-calc.field name="days" label="and days" value="0" min="0" max="6" step="1" />
    </div>

    <div data-show-when="mode:efw">
        <x-calc.field name="efw" label="Estimated fetal weight" value="1900" min="0" step="any" suffix="g" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div data-show-when="mode:biometry" hidden>
            <x-calc.field name="hc" label="Head (HC)" value="29.5" min="0" placeholder="Head (HC)">
                <label for="calc-hc-unit" class="sr-only">Head (HC) unit</label>
                <select id="calc-hc-unit" name="hc-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:biometry" hidden>
            <x-calc.field name="ac" label="Abdomen (AC)" value="28" min="0" placeholder="Abdomen (AC)">
                <label for="calc-ac-unit" class="sr-only">Abdomen (AC) unit</label>
                <select id="calc-ac-unit" name="ac-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:biometry" hidden>
            <x-calc.field name="fl" label="Femur (FL)" value="6.2" min="0" placeholder="Femur (FL)">
                <label for="calc-fl-unit" class="sr-only">Femur (FL) unit</label>
                <select id="calc-fl-unit" name="fl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:biometry" hidden>
            <x-calc.field name="bpd" label="BPD" value="8.2" min="0" placeholder="BPD">
                <label for="calc-bpd-unit" class="sr-only">BPD unit</label>
                <select id="calc-bpd-unit" name="bpd-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Estimated fetal weight" />

    <x-calc.options :decimals="false" :examples="[
        '32 weeks' => ['mode' => 'efw', 'weeks' => 32, 'days' => 0, 'efw' => 1900, 'hc' => 29.5, 'hc-unit' => 'cm', 'ac' => 28, 'ac-unit' => 'cm', 'fl' => 6.2, 'fl-unit' => 'cm', 'bpd' => 8.2, 'bpd-unit' => 'cm'],
        'Small' => ['mode' => 'efw', 'weeks' => 36, 'days' => 0, 'efw' => 2200, 'hc' => 29.5, 'hc-unit' => 'cm', 'ac' => 28, 'ac-unit' => 'cm', 'fl' => 6.2, 'fl-unit' => 'cm', 'bpd' => 8.2, 'bpd-unit' => 'cm'],
        'Biometry' => ['mode' => 'biometry', 'weeks' => 32, 'days' => 0, 'efw' => 1900, 'hc' => 29.5, 'hc-unit' => 'cm', 'ac' => 28, 'ac-unit' => 'cm', 'fl' => 6.2, 'fl-unit' => 'cm', 'bpd' => 8.2, 'bpd-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'efw' => ['label' => 'Weight'],
            'median' => ['label' => 'Median for age'],
            'size' => ['label' => 'Size'],
            'note' => ['label' => 'Accuracy'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ln(median) = 0.578 + 0.332 GA − 0.00354 GA²</li>
            <li>SD = 12.7% of median</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
