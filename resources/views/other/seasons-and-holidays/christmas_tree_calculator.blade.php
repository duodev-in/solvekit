<x-calc.page
    title="Christmas Tree Calculator - SolveKit"
    description="Free Christmas tree calculator: lights, garland and ornaments for your tree’s height."
    lede="Decorate your Christmas tree."
    about="Decorating guides size lights, garland and ornaments to the height of the tree."
    :calc="['engine' => 'ot-misc', 'tool' => 'christmas_tree', 'fields' => ['height', 'style'], 'unitFields' => ['height' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many lights for a 1.8 m tree?', 'answer' => 'About 600 lights.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Tree height" value="1.8" placeholder="Tree height">
            <label for="calc-height-unit" class="sr-only">Tree height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="style" label="Look" :options="['light' => 'Light decoration', 'standard' => 'Standard', 'full' => 'Full and bright']" selected="standard" />
    </div>

    <x-calc.result label="Lights needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 1.8, 'height-unit' => 'm', 'style' => 'standard'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'garland' => ['label' => 'Garland or tinsel'],
            'ornaments' => ['label' => 'Ornaments'],
            'topper' => ['label' => 'Topper size'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
