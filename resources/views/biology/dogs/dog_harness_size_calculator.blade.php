<x-calc.page
    title="Dog Harness Size Calculator - SolveKit"
    description="Free dog harness size calculator: generic harness size from chest girth, with a size chart."
    lede="Find your dog's harness size from chest girth."
    about="Chest girth, measured around the widest part of the rib cage just behind the front legs, is the key harness measurement. This chart is a generic guide: brands size differently, so always check the maker's chart and leave room for two fingers under the straps."
    :calc="['engine' => 'pets', 'tool' => 'harness', 'fields' => ['chest'], 'unitFields' => ['chest' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the chest', 'text' => 'Around the widest part behind the front legs.'],
        ['name' => 'Check the brand', 'text' => 'Compare with the maker\'s chart.'],
    ]"
    :faqs="[
        ['question' => 'How do I measure for a harness?', 'answer' => 'Wrap a soft tape around the widest part of the chest, behind the front legs.'],
        ['question' => 'What if my dog is between sizes?', 'answer' => 'Pick the larger size if the harness adjusts, especially for growing puppies.'],
        ['question' => 'How tight should a harness be?', 'answer' => 'Snug, with room for two fingers under every strap.'],
    ]"
>
    <x-calc.field name="chest" label="Chest girth" value="24" min="0" placeholder="Chest girth">
        <label for="calc-chest-unit" class="sr-only">Chest girth unit</label>
        <select id="calc-chest-unit" name="chest-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Harness size" />

    <x-calc.options :examples="[
        '24 in chest' => ['chest' => 24, 'chest-unit' => 'in'],
        '45 cm chest' => ['chest' => 45, 'chest-unit' => 'cm'],
        '34 in chest' => ['chest' => 34, 'chest-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'chest' => ['label' => 'Chest girth'],
        ]" />
        <x-calc.quick-ref heading="Generic size chart" name="sizes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size from chest girth (generic chart)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
