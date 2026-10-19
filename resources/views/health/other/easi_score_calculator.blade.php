<x-calc.page
    title="EASI Score Calculator - SolveKit"
    description="Free EASI calculator: Eczema Area and Severity Index from redness, thickness, scratching and lichenification and the area affected in four body regions."
    lede="Score eczema severity (EASI)."
    about="EASI (Hanifin et al. 2001) scores four signs (0–3) and the area affected (0–6) in head and neck, arms, trunk and legs. Each region score = sum of signs × area score × a multiplier (0.1, 0.2, 0.3 and 0.4 from age 8; 0.2, 0.2, 0.3, 0.3 for younger children). Leshem et al. (2015) bands: 1.1–7 mild, 7.1–21 moderate, 21.1–50 severe and over 50 very severe. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'easi', 'fields' => ['age_group', 'head_ery', 'head_ind', 'head_exc', 'head_lic', 'head_area', 'upper_ery', 'upper_ind', 'upper_exc', 'upper_lic', 'upper_area', 'trunk_ery', 'trunk_ind', 'trunk_exc', 'trunk_lic', 'trunk_area', 'lower_ery', 'lower_ind', 'lower_exc', 'lower_lic', 'lower_area']]"
    :how-to="[
        ['name' => 'Choose the age group', 'text' => ''],
        ['name' => 'Grade each region', 'text' => 'Signs and area.'],
    ]"
    :faqs="[
        ['question' => 'What is the EASI for the sample grading?', 'answer' => '12.0 of 72: Moderate (7.1–21.0).'],
    ]"
>
    <x-calc.segmented name="age_group" legend="Age" :options="['adult' => '8 years and over', 'child' => '0–7 years']" selected="adult" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="head_ery" label="Head and neck: redness" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="head_ind" label="Head and neck: thickness or papules" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="head_exc" label="Head and neck: scratching" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="head_lic" label="Head and neck: lichenification" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="0" />
        <x-calc.select name="head_area" label="Head and neck: area affected" :options="['0' => '0 – none', '1' => '1 – under 10%', '2' => '2 – 10–29%', '3' => '3 – 30–49%', '4' => '4 – 50–69%', '5' => '5 – 70–89%', '6' => '6 – 90–100%']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="upper_ery" label="Arms: redness" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="2" />
        <x-calc.select name="upper_ind" label="Arms: thickness or papules" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="upper_exc" label="Arms: scratching" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="upper_lic" label="Arms: lichenification" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="upper_area" label="Arms: area affected" :options="['0' => '0 – none', '1' => '1 – under 10%', '2' => '2 – 10–29%', '3' => '3 – 30–49%', '4' => '4 – 50–69%', '5' => '5 – 70–89%', '6' => '6 – 90–100%']" selected="3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="trunk_ery" label="Trunk: redness" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="trunk_ind" label="Trunk: thickness or papules" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="trunk_exc" label="Trunk: scratching" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="trunk_lic" label="Trunk: lichenification" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="0" />
        <x-calc.select name="trunk_area" label="Trunk: area affected" :options="['0' => '0 – none', '1' => '1 – under 10%', '2' => '2 – 10–29%', '3' => '3 – 30–49%', '4' => '4 – 50–69%', '5' => '5 – 70–89%', '6' => '6 – 90–100%']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="lower_ery" label="Legs: redness" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="2" />
        <x-calc.select name="lower_ind" label="Legs: thickness or papules" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="2" />
        <x-calc.select name="lower_exc" label="Legs: scratching" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="lower_lic" label="Legs: lichenification" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="lower_area" label="Legs: area affected" :options="['0' => '0 – none', '1' => '1 – under 10%', '2' => '2 – 10–29%', '3' => '3 – 30–49%', '4' => '4 – 50–69%', '5' => '5 – 70–89%', '6' => '6 – 90–100%']" selected="3" />
    </div>

    <x-calc.result label="EASI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age_group' => 'adult', 'head_ery' => '1', 'head_ind' => '1', 'head_exc' => '1', 'head_lic' => '0', 'head_area' => '2', 'upper_ery' => '2', 'upper_ind' => '1', 'upper_exc' => '1', 'upper_lic' => '1', 'upper_area' => '3', 'trunk_ery' => '1', 'trunk_ind' => '1', 'trunk_exc' => '0', 'trunk_lic' => '0', 'trunk_area' => '2', 'lower_ery' => '2', 'lower_ind' => '2', 'lower_exc' => '1', 'lower_lic' => '1', 'lower_area' => '3'],
        'Child' => ['age_group' => 'child', 'head_ery' => '1', 'head_ind' => '1', 'head_exc' => '1', 'head_lic' => '0', 'head_area' => '2', 'upper_ery' => '2', 'upper_ind' => '1', 'upper_exc' => '1', 'upper_lic' => '1', 'upper_area' => '3', 'trunk_ery' => '1', 'trunk_ind' => '1', 'trunk_exc' => '0', 'trunk_lic' => '0', 'trunk_area' => '2', 'lower_ery' => '2', 'lower_ind' => '2', 'lower_exc' => '1', 'lower_lic' => '1', 'lower_area' => '3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Severity'],
            'multipliers' => ['label' => 'Multipliers'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Regions" name="regions" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EASI = Σ (signs × area × multiplier)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
