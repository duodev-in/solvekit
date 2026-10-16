<x-calc.page
    title="Cattle Weight Calculator - SolveKit"
    description="Free cattle weight calculator: estimate live weight from heart girth and body length with a tape formula."
    lede="Estimate a cow's weight from heart girth and body length."
    about="A common tape formula is weight (lb) = heart girth² × body length ÷ 300, both in inches. Measure the girth just behind the front legs and the length from the point of the shoulder to the pin bone."
    :calc="['engine' => 'livestock', 'tool' => 'cattle_weight', 'fields' => ['girth', 'length'], 'unitFields' => ['girth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the girth', 'text' => 'Around the chest behind the front legs.'],
        ['name' => 'Measure the length', 'text' => 'Point of shoulder to pin bone.'],
    ]"
    :faqs="[
        ['question' => 'How accurate is it?', 'answer' => 'Usually within 5 to 10%; a scale is best for sales and dosing.'],
        ['question' => 'Does breed matter?', 'answer' => 'Yes, dairy and beef frames differ; compare with a scale weight to calibrate.'],
        ['question' => 'What is an animal unit?', 'answer' => 'A 1,000 lb cow, used for grazing calculations.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="girth" label="Heart girth" value="75" min="0" placeholder="Heart girth">
            <label for="calc-girth-unit" class="sr-only">Heart girth unit</label>
            <select id="calc-girth-unit" name="girth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="length" label="Body length" value="65" min="0" placeholder="Body length">
            <label for="calc-length-unit" class="sr-only">Body length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Estimated weight" />

    <x-calc.options :examples="[
        'Beef cow' => ['girth' => 75, 'girth-unit' => 'in', 'length' => 65, 'length-unit' => 'in'],
        'Yearling steer' => ['girth' => 64, 'girth-unit' => 'in', 'length' => 56, 'length-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'In kilograms'],
            'au' => ['label' => 'Animal units'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lb = girth² × length ÷ 300 (inches)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
