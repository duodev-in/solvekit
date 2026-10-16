<x-calc.page
    title="Michaelis-Menten Equation Calculator - SolveKit"
    description="Free Michaelis-Menten calculator: reaction rate from Vmax and Km, or fit Vmax, Km and kcat to substrate and rate data."
    lede="Work out an enzyme rate, or fit Vmax and Km to your data."
    about="The Michaelis–Menten equation v = Vmax[S] ÷ (Km + [S]) describes how enzyme rate rises with substrate. In fit mode Vmax and Km are found by non-linear least squares on the original data, which is more accurate than a Lineweaver–Burk plot (its values are listed for reference). With the enzyme concentration, kcat and kcat/Km follow."
    :calc="['engine' => 'chem-biochem', 'tool' => 'michaelis_menten', 'fields' => ['mode', 'vmax', 'km', 'substrate', 'data', 'enzyme']]"
    :how-to="[
        ['name' => 'Fit mode', 'text' => 'Paste [S] and rate data.'],
        ['name' => 'Rate mode', 'text' => 'Enter Vmax, Km and [S].'],
    ]"
    :faqs="[
        ['question' => 'What does Km mean?', 'answer' => 'The substrate concentration giving half the maximum rate.'],
        ['question' => 'Why not use Lineweaver–Burk?', 'answer' => 'Taking reciprocals magnifies errors at low [S]; non-linear fitting avoids this.'],
        ['question' => 'What is kcat ÷ Km?', 'answer' => 'The catalytic efficiency, how well the enzyme works at low substrate.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Mode" :options="['rate' => 'Rate from constants', 'fit' => 'Fit data']" selected="fit" />

    <div data-show-when="mode:rate" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="vmax" label="Vmax" value="10" min="0" />
            <x-calc.field name="km" label="Km" value="2" min="0" />
            <x-calc.field name="substrate" label="[S]" value="2" min="0" />
        </div>
    </div>

    <div data-show-when="mode:fit">
        <x-calc.textarea name="data" label="Substrate and rate, one pair per line" value="0.2 0.88
0.4 1.6
0.8 2.4
1.6 3.2
3.2 3.8
6.4 4.2" rows="6" />
    </div>

    <x-calc.field name="enzyme" label="Enzyme concentration (optional)" value="" min="0" placeholder="Same unit as [S], for kcat" />

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Fit enzyme data' => ['mode' => 'fit', 'data' => '0.2 0.88
0.4 1.6
0.8 2.4
1.6 3.2
3.2 3.8
6.4 4.2', 'enzyme' => ''],
        'Rate at [S] = Km' => ['mode' => 'rate', 'vmax' => 10, 'km' => 2, 'substrate' => 2, 'enzyme' => ''],
        'Fit with kcat' => ['mode' => 'fit', 'data' => '0.5 3.33
1 5
2 6.67
4 8
8 8.89', 'enzyme' => 0.001],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Rate against substrate" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'vmax' => ['label' => 'Vmax'],
            'km' => ['label' => 'Km'],
            'kcat' => ['label' => 'kcat'],
            'efficiency' => ['label' => 'kcat ÷ Km'],
        ]" />
        <x-calc.quick-ref heading="Lineweaver–Burk values" name="lineweaver" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>v = Vmax [S] ÷ (Km + [S])</li>
            <li>kcat = Vmax ÷ [E]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
