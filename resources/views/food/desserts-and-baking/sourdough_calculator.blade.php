<x-calc.page
    title="Sourdough Calculator - SolveKit"
    description="Free sourdough calculator: water, starter and salt for a sourdough loaf from flour or dough weight, the true hydration including the starter, and the levain build."
    lede="Plan a sourdough bake."
    about="Percentages are of the flour you add: 75% hydration and 20% starter on 500 g flour is 375 g water and 100 g starter. The starter contains flour and water too (a 100% hydration starter is half each), so the true hydration counts them. The levain build mixes a little ripe starter with fresh flour and water (1:5:5 is common) a few hours before mixing."
    :calc="['engine' => 'fd-bake', 'tool' => 'sourdough', 'fields' => ['mode', 'flour', 'loaves', 'loaf', 'hydration', 'starter', 'starter_hydration', 'salt', 'build']]"
    :how-to="[
        ['name' => 'Enter flour, or loaves and their weight', 'text' => ''],
        ['name' => 'Set hydration, starter and salt', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much water for 500 g flour at 75% hydration?', 'answer' => '375 g; 500 g flour, 100 g starter, 10 g salt; total 985 g.'],
        ['question' => 'What is the true hydration?', 'answer' => '77.3% (counting the starter\'s 50 g flour and 50 g water).'],
        ['question' => 'What do two 900 g loaves need?', 'answer' => '928 g flour, 668 g water.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Start from" :options="['flour' => 'Flour weight', 'dough' => 'Loaves']" selected="flour" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:flour">
            <x-calc.field name="flour" label="Flour" value="500" min="0" step="any" suffix="g" />
        </div>
        <div data-show-when="mode:dough" hidden>
            <x-calc.field name="loaves" label="Loaves" value="2" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:dough" hidden>
        <x-calc.field name="loaf" label="Dough per loaf" value="900" min="0" step="any" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hydration" label="Hydration" value="75" min="0" step="any" suffix="%" />
        <x-calc.field name="starter" label="Starter" value="20" min="0" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="starter_hydration" label="Starter hydration" value="100" min="0" step="any" suffix="%" />
        <x-calc.field name="salt" label="Salt" value="2" min="0" step="any" suffix="%" />
    </div>

    <x-calc.field name="build" label="Levain build (starter : flour : water)" value="1:5:5" type="text" />

    <x-calc.result label="Water to add" />

    <x-calc.options :decimals="false" :examples="[
        'Basic loaf' => ['mode' => 'flour', 'flour' => 500, 'loaves' => 2, 'loaf' => 900, 'hydration' => 75, 'starter' => 20, 'starter_hydration' => 100, 'salt' => 2, 'build' => '1:5:5'],
        'Two loaves' => ['mode' => 'dough', 'flour' => 500, 'loaves' => 2, 'loaf' => 900, 'hydration' => 72, 'starter' => 20, 'starter_hydration' => 100, 'salt' => 2, 'build' => '1:5:5'],
        'Stiff starter' => ['mode' => 'flour', 'flour' => 1000, 'loaves' => 2, 'loaf' => 900, 'hydration' => 70, 'starter' => 25, 'starter_hydration' => 50, 'salt' => 2.2, 'build' => '1:2:1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'flour' => ['label' => 'Flour'],
            'starter' => ['label' => 'Starter'],
            'salt' => ['label' => 'Salt'],
            'trueHydration' => ['label' => 'True hydration'],
            'total' => ['label' => 'Total dough'],
            'levain' => ['label' => 'Levain build'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water = flour × hydration</li>
            <li>true hydration = (water + starter water) ÷ (flour + starter flour)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
