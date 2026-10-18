<x-calc.page
    title="Conduit Fill Calculator - SolveKit"
    description="Free conduit fill calculator: percent fill of EMT, rigid or PVC conduit from conductor sizes and insulation, by NEC Chapter 9 Tables 1, 4 and 5."
    lede="Work out how full a conduit is and whether it passes."
    about="Fill = total conductor area (NEC Chapter 9 Table 5, by size and insulation) ÷ the conduit's internal area (Table 4). Table 1 allows 53% for one conductor, 31% for two and 40% for three or more. Annex C gives the same answer as counts for single-size fills."
    :calc="['engine' => 'con-elec', 'tool' => 'conduit_fill', 'fields' => ['conduit', 'trade', 'size1', 'type1', 'count1', 'size2', 'type2', 'count2', 'size3', 'type3', 'count3'], 'data' => collect(config('construction_data'))->only(['wires', 'box_fill', 'conduits'])->all()]"
    :how-to="[
        ['name' => 'Choose the conduit', 'text' => 'Type and trade size.'],
        ['name' => 'Add the conductors', 'text' => 'Up to three groups of size, insulation and count.'],
    ]"
    :faqs="[
        ['question' => 'How many 12 AWG THHN in ¾ in EMT?', 'answer' => '16 (16 × 0.0133 = 0.213 in², within 40% of 0.533 in²).'],
        ['question' => 'Why only 40%?', 'answer' => 'Room to pull the wires without damage and to shed heat.'],
        ['question' => 'Do grounds count?', 'answer' => 'Yes, equipment grounding conductors count toward fill.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="conduit" label="Conduit" :options="collect(config('construction_data.conduits'))->map(fn ($c) => $c['name'])->all()" selected="emt" />
        <x-calc.select name="trade" label="Trade size" :options="['1/2' => '½ in', '3/4' => '¾ in', '1' => '1 in', '1-1/4' => '1¼ in', '1-1/2' => '1½ in', '2' => '2 in', '2-1/2' => '2½ in', '3' => '3 in', '3-1/2' => '3½ in', '4' => '4 in', '5' => '5 in', '6' => '6 in']" selected="3/4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="size1" label="Group 1 size" :options="collect(config('construction_data.wires'))->map(fn ($w) => $w['label'])->all()" selected="12" />
        <x-calc.select name="type1" label="Insulation" :options="['thhn' => 'THHN/THWN-2', 'xhhw' => 'XHHW', 'thw' => 'THW']" selected="thhn" />
        <x-calc.field name="count1" label="Count" value="6" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="size2" label="Group 2 size" :options="collect(config('construction_data.wires'))->map(fn ($w) => $w['label'])->all()" selected="10" />
        <x-calc.select name="type2" label="Insulation" :options="['thhn' => 'THHN/THWN-2', 'xhhw' => 'XHHW', 'thw' => 'THW']" selected="thhn" />
        <x-calc.field name="count2" label="Count" value="1" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="size3" label="Group 3 size" :options="collect(config('construction_data.wires'))->map(fn ($w) => $w['label'])->all()" selected="8" />
        <x-calc.select name="type3" label="Insulation" :options="['thhn' => 'THHN/THWN-2', 'xhhw' => 'XHHW', 'thw' => 'THW']" selected="thhn" />
        <x-calc.field name="count3" label="Count" value="0" min="0" step="1" />
    </div>

    <x-calc.result label="Conduit fill" />

    <x-calc.options :examples="[
        '¾ in EMT, six 12 + one 10' => ['conduit' => 'emt', 'trade' => '3/4', 'size1' => '12', 'type1' => 'thhn', 'count1' => 6, 'size2' => '10', 'type2' => 'thhn', 'count2' => 1, 'size3' => '8', 'type3' => 'thhn', 'count3' => 0],
        '1 in PVC 40, four 6 AWG' => ['conduit' => 'pvc40', 'trade' => '1', 'size1' => '6', 'type1' => 'thhn', 'count1' => 4, 'size2' => '10', 'type2' => 'thhn', 'count2' => 0, 'size3' => '8', 'type3' => 'thhn', 'count3' => 0],
        '2 in RMC feeder' => ['conduit' => 'rmc', 'trade' => '2', 'size1' => '3/0', 'type1' => 'xhhw', 'count1' => 3, 'size2' => '1/0', 'type2' => 'xhhw', 'count2' => 1, 'size3' => '6', 'type3' => 'thw', 'count3' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'smallest' => ['label' => 'Smallest that passes'],
            'wires' => ['label' => 'Conductors'],
            'allowed' => ['label' => 'Usable area'],
        ]" />
        <x-calc.quick-ref heading="Conductors" name="groups" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fill = Σ conductor areas ÷ conduit area</li>
            <li>limits: 53% (1), 31% (2), 40% (3 or more)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
