<x-calc.page
    title="Injury Severity Score Calculator - SolveKit"
    description="Free Injury Severity Score calculator: ISS from the Abbreviated Injury Scale (AIS) in six body regions, with the major trauma threshold."
    lede="Calculate the Injury Severity Score."
    about="ISS (Baker et al. 1974) takes the highest AIS grade (1–6) in each of six body regions, squares the three highest and adds them. Range 0–75; any AIS 6 sets ISS to 75. Over 15 is major trauma. The AIS grades come from the injury coding manual. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'iss', 'fields' => ['head', 'face', 'chest', 'abdomen', 'extremity', 'external']]"
    :how-to="[
        ['name' => 'Enter the highest AIS for each region', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ISS with head 3, chest 4 and limbs 3?', 'answer' => '34: Major trauma (ISS over 15).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="head" label="Head or neck" :options="['0' => '0 – none', '1' => '1 – minor', '2' => '2 – moderate', '3' => '3 – serious', '4' => '4 – severe', '5' => '5 – critical', '6' => '6 – unsurvivable']" selected="3" />
        <x-calc.select name="face" label="Face" :options="['0' => '0 – none', '1' => '1 – minor', '2' => '2 – moderate', '3' => '3 – serious', '4' => '4 – severe', '5' => '5 – critical', '6' => '6 – unsurvivable']" selected="1" />
        <x-calc.select name="chest" label="Chest" :options="['0' => '0 – none', '1' => '1 – minor', '2' => '2 – moderate', '3' => '3 – serious', '4' => '4 – severe', '5' => '5 – critical', '6' => '6 – unsurvivable']" selected="4" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="abdomen" label="Abdomen" :options="['0' => '0 – none', '1' => '1 – minor', '2' => '2 – moderate', '3' => '3 – serious', '4' => '4 – severe', '5' => '5 – critical', '6' => '6 – unsurvivable']" selected="2" />
        <x-calc.select name="extremity" label="Extremities or pelvis" :options="['0' => '0 – none', '1' => '1 – minor', '2' => '2 – moderate', '3' => '3 – serious', '4' => '4 – severe', '5' => '5 – critical', '6' => '6 – unsurvivable']" selected="3" />
        <x-calc.select name="external" label="External (skin)" :options="['0' => '0 – none', '1' => '1 – minor', '2' => '2 – moderate', '3' => '3 – serious', '4' => '4 – severe', '5' => '5 – critical', '6' => '6 – unsurvivable']" selected="1" />
    </div>

    <x-calc.result label="Injury Severity Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['head' => '3', 'face' => '1', 'chest' => '4', 'abdomen' => '2', 'extremity' => '3', 'external' => '1'],
        'Minor' => ['head' => '1', 'face' => '1', 'chest' => '0', 'abdomen' => '0', 'extremity' => '2', 'external' => '1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Severity'],
            'formula' => ['label' => 'Working'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ISS = a² + b² + c²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
