<x-calc.page
    title="Tie Length Calculator - SolveKit"
    description="Free tie length calculator: the necktie length for your height, neck size and knot, from regular to extra long."
    lede="Find the right tie length for your height."
    about="A tie should end with its tip at the belt buckle. Standard ties are about 57–58 in (145–147 cm) and suit most men up to about 6′1″; taller men, larger necks and fuller knots such as the Windsor need long (61 in) or extra-long (63 in+) ties. These are guidelines; brands vary."
    :calc="['engine' => 'ev-clothing', 'tool' => 'tie', 'fields' => ['height', 'neck', 'knot'], 'unitFields' => ['height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'neck' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and collar size', 'text' => 'And the knot you tie.'],
    ]"
    :faqs="[
        ['question' => 'What tie length for 6 ft?', 'answer' => 'A regular 58 in tie usually works.'],
        ['question' => 'When do I need a long tie?', 'answer' => 'Above about 6′2″, or with a large neck or Windsor knot.'],
        ['question' => 'Where should a tie end?', 'answer' => 'With the tip at the belt buckle.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="height" label="Height" value="70" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="neck" label="Neck (collar) size" value="16" min="0" placeholder="Neck (collar) size">
            <label for="calc-neck-unit" class="sr-only">Neck (collar) size unit</label>
            <select id="calc-neck-unit" name="neck-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="knot" label="Knot" :options="['four' => 'Four-in-hand', 'half' => 'Half Windsor', 'full' => 'Full Windsor']" selected="four" />
    </div>

    <x-calc.result label="Tie length" />

    <x-calc.options :decimals="false" :examples="[
        '5′10″, four-in-hand' => ['height' => 70, 'height-unit' => 'in', 'neck' => 16, 'neck-unit' => 'in', 'knot' => 'four'],
        '6′3″, Windsor' => ['height' => 75, 'height-unit' => 'in', 'neck' => 17, 'neck-unit' => 'in', 'knot' => 'full'],
        '196 cm, 46 cm neck' => ['height' => 196, 'height-unit' => 'cm', 'neck' => 46, 'neck-unit' => 'cm', 'knot' => 'half'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'type' => ['label' => 'Type'],
            'knot' => ['label' => 'Knot'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>regular 57–58 in; long 61 in; extra long 63 in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
