<x-calc.page
    title="Christmas Tree Footprint Calculator - SolveKit"
    description="Free Christmas tree footprint calculator: carbon footprint of a real tree by how it is disposed of, against an artificial tree over the years you keep it."
    lede="Compare the carbon footprint of a real and an artificial Christmas tree."
    about="Carbon Trust figures for a 2 m tree: about 3.5 kg CO₂e for a real tree that is chipped, burned or replanted, 16 kg if it goes to landfill (it rots and gives off methane), and about 40 kg for an artificial tree, two thirds of it from the plastic. An artificial tree has to be kept for many years to come out ahead."
    :calc="['engine' => 'eco-footprint', 'tool' => 'christmas_tree', 'fields' => ['tree', 'disposal', 'years'], 'data' => ['trees' => config('ecology_data.trees')]]"
    :how-to="[
        ['name' => 'Choose real or artificial', 'text' => 'And how a real tree is disposed of.'],
        ['name' => 'Enter the years', 'text' => 'You would keep an artificial tree.'],
    ]"
    :faqs="[
        ['question' => 'Is a real or artificial tree better?', 'answer' => 'A real tree that is chipped has about a tenth of the footprint of an artificial tree used for one year.'],
        ['question' => 'How long must I keep an artificial tree?', 'answer' => 'About 12 years to beat a chipped real tree, about 3 to beat a landfilled one.'],
        ['question' => 'What about a potted tree?', 'answer' => 'Replanting and reusing a potted tree is the lowest-carbon choice.'],
    ]"
>
    <x-calc.segmented name="tree" legend="Tree" :options="['real' => 'Real', 'artificial' => 'Artificial']" selected="real" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="disposal" label="Real tree after Christmas" :options="['chipped' => 'Chipped or replanted', 'burned' => 'Burned', 'landfill' => 'Landfill']" selected="chipped" />
        <x-calc.field name="years" label="Years you keep an artificial tree" value="10" min="1" step="1" />
    </div>

    <x-calc.result label="Real tree" />

    <x-calc.options :examples="[
        'Real tree, chipped' => ['tree' => 'real', 'disposal' => 'chipped', 'years' => 10],
        'Real tree, landfill' => ['tree' => 'real', 'disposal' => 'landfill', 'years' => 10],
        'Artificial, 6 years' => ['tree' => 'artificial', 'disposal' => 'chipped', 'years' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'real' => ['label' => 'Real tree'],
            'artificial' => ['label' => 'Artificial tree'],
            'break_even' => ['label' => 'Break-even'],
            'landfill' => ['label' => 'Landfill'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>real: 3.5 kg (chipped or burned), 16 kg (landfill)</li>
            <li>artificial: 40 kg ÷ years kept</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
