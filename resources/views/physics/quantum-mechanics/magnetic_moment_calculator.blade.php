<x-calc.page
    title="Magnetic Moment Calculator - SolveKit"
    description="Free magnetic moment calculator: spin-only moment from unpaired electrons, or g_J√(J(J+1)) from L, S and J."
    lede="Find an ion’s magnetic moment."
    about="Transition-metal ions often follow the spin-only formula √(n(n+2)) μ_B; rare earths need the full Landé g-factor."
    :calc="['engine' => 'ph-quantum', 'tool' => 'magnetic_moment_qm', 'fields' => ['mode', 'n', 'L', 'S', 'J'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the moment with five unpaired electrons?', 'answer' => '5.9161 μ_B.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Method" :options="['spin' => 'Spin only (unpaired electrons)', 'lsj' => 'From L, S and J (Landé g)']" selected="spin" />
        <div data-show-when="mode:spin">
            <x-calc.field name="n" label="Unpaired electrons" value="5" min="0" step="any" />
        </div>
        <div data-show-when="mode:lsj">
            <x-calc.field name="L" label="Orbital L" value="3" min="0" step="any" />
        </div>
        <div data-show-when="mode:lsj">
            <x-calc.field name="S" label="Spin S" value="3.5" min="0" step="any" />
        </div>
        <div data-show-when="mode:lsj">
            <x-calc.field name="J" label="Total J" value="3.5" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Effective magnetic moment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'spin', 'n' => 5, 'L' => 3, 'S' => 3.5, 'J' => 3.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g' => ['label' => 'g-factor'],
            'si' => ['label' => 'In SI units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
