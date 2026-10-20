<x-calc.page
    title="Z-Table (Standard Normal Table) - SolveKit"
    description="Free z-table: standard normal probabilities for any z, the z for any probability, and the full printable table."
    lede="Look up the standard normal table."
    about="The z-table gives the area under the standard normal curve to the left of z."
    :calc="['engine' => 'st-inf', 'tool' => 'z_table', 'fields' => ['mode', 'z', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is Φ(1.96)?', 'answer' => '0.9750021.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Look up" :options="['z' => 'Probability for a z-score', 'p' => 'z-score for a probability']" selected="z" />
        <div data-show-when="mode:z">
            <x-calc.field name="z" label="z" value="1.96" step="any" />
        </div>
        <div data-show-when="mode:p">
            <x-calc.field name="p" label="Probability (left area)" value="0.975" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Left area Φ(z) = P(Z < z)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'z', 'z' => 1.96, 'p' => 0.975],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'right' => ['label' => 'Right area P(Z > z)'],
            'centre' => ['label' => 'Between 0 and z'],
            'two' => ['label' => 'Between −z and z'],
            'z' => ['label' => 'z'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Standard normal table: P(Z < z) for z = row + column" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
