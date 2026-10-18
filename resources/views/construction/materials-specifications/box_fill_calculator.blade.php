<x-calc.page
    title="Box Fill Calculator - SolveKit"
    description="Free box fill calculator: electrical box volume needed by NEC 314.16 for conductors, devices, clamps and grounds, with the smallest standard box that fits."
    lede="Work out the box volume your wiring needs (NEC 314.16)."
    about="NEC 314.16(B) gives each conductor a volume by size (2.00 in³ for 14 AWG, 2.25 for 12, 2.50 for 10). Each device yoke counts twice the largest conductor on it, internal clamps once, each type of support fitting once, and up to four equipment grounding conductors once, plus a quarter for each beyond four. Box volumes are from Table 314.16(A). For simplicity, device, clamp and ground allowances use the largest conductor size."
    :calc="['engine' => 'con-elec', 'tool' => 'box_fill', 'fields' => ['n14', 'n12', 'n10', 'n8', 'n6', 'devices', 'grounds', 'clamps', 'fittings', 'box'], 'data' => collect(config('construction_data'))->only(['wires', 'box_fill', 'conduits'])->all()]"
    :how-to="[
        ['name' => 'Count the insulated conductors', 'text' => 'Each entering the box, by size.'],
        ['name' => 'Add devices, clamps and grounds', 'text' => 'Then check a box.'],
    ]"
    :faqs="[
        ['question' => 'How many 14 AWG wires in an 18 in³ box?', 'answer' => 'Up to 9 allowances of 2.00 in³ in total, counting devices, clamps and grounds.'],
        ['question' => 'Do grounds count?', 'answer' => 'All equipment grounds together count as one conductor, plus ¼ for each beyond four.'],
        ['question' => 'Does a pigtail count?', 'answer' => 'No: a conductor that starts and ends inside the box is not counted.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="n14" label="14 AWG" value="4" min="0" step="1" />
        <x-calc.field name="n12" label="12 AWG" value="0" min="0" step="1" />
        <x-calc.field name="n10" label="10 AWG" value="0" min="0" step="1" />
        <x-calc.field name="n8" label="8 AWG" value="0" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="n6" label="6 AWG" value="0" min="0" step="1" />
        <x-calc.field name="devices" label="Devices (yokes)" value="1" min="0" step="1" />
        <x-calc.field name="grounds" label="Grounding conductors" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="clamps" label="Internal clamps" :options="['no' => 'No', 'yes' => 'Yes']" selected="yes" />
        <x-calc.field name="fittings" label="Support fitting types" value="0" min="0" step="1" />
        <x-calc.select name="box" label="Box to check" :options="['none' => 'Do not check'] + collect(config('construction_data.box_fill.boxes'))->map(fn ($b) => $b[0].' ('.$b[1].' in³)')->all()" selected="device_3_2_312" />
    </div>

    <x-calc.result label="Box volume required" />

    <x-calc.options :examples="[
        'Switch: 2 cables, 14 AWG' => ['n14' => 4, 'n12' => 0, 'n10' => 0, 'n8' => 0, 'n6' => 0, 'devices' => 1, 'grounds' => 2, 'clamps' => 'yes', 'fittings' => 0, 'box' => 'device_3_2_312'],
        'Receptacle: 3 cables, 12 AWG' => ['n14' => 0, 'n12' => 6, 'n10' => 0, 'n8' => 0, 'n6' => 0, 'devices' => 1, 'grounds' => 3, 'clamps' => 'no', 'fittings' => 0, 'box' => 'square_4_112'],
        'Junction box 12 conductors' => ['n14' => 8, 'n12' => 4, 'n10' => 0, 'n8' => 0, 'n6' => 0, 'devices' => 0, 'grounds' => 6, 'clamps' => 'yes', 'fittings' => 0, 'box' => 'square_4_218'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'check' => ['label' => 'Your box'],
            'smallest' => ['label' => 'Smallest box that fits'],
            'cm3' => ['label' => 'Cubic centimeters'],
        ]" />
        <x-calc.quick-ref heading="Allowances" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = Σ conductors × allowance + 2 × largest per yoke + clamps + fittings + grounds</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
