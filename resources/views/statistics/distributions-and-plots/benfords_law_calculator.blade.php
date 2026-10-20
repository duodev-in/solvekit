<x-calc.page
    title="Benford's Law Calculator - SolveKit"
    description="Free Benford's law calculator: compare the first digits of your data with Benford's distribution, with MAD conformity and χ²."
    lede="Test data against Benford's law."
    about="In many real data sets the first digit is 1 about 30% of the time and 9 under 5%. Big departures can flag errors or fabricated numbers."
    :calc="['engine' => 'st-dist', 'tool' => 'benford', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'statistics' => collect(config('statistics_data'))->only(['benford_mad'])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Does steady growth follow Benford’s law?', 'answer' => 'Yes. The example is a balance of 100 growing 7% a year for 100 years: Close conformity (fewer than 300 values: treat with caution) (MAD 0.005712).'],
        ['question' => 'How many values does a Benford test need?', 'answer' => 'Several hundred for a reliable verdict; with fewer, chance alone can push the MAD past the bands.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (amounts, populations, counts…)" value="100, 107, 114, 123, 131, 140, 150, 161, 172, 184, 197, 210, 225, 241, 258, 276, 295, 316, 338, 362, 387, 414, 443, 474, 507, 543, 581, 621, 665, 711, 761, 815, 872, 933, 998, 1068, 1142, 1222, 1308, 1399, 1497, 1602, 1714, 1834, 1963, 2100, 2247, 2405, 2573, 2753, 2946, 3152, 3373, 3609, 3861, 4132, 4421, 4730, 5061, 5416, 5795, 6200, 6634, 7099, 7596, 8127, 8696, 9305, 9956, 10653, 11399, 12197, 13051, 13964, 14942, 15988, 17107, 18304, 19585, 20956, 22423, 23993, 25673, 27470, 29393, 31450, 33652, 36007, 38528, 41225, 44110, 47198, 50502, 54037, 57820, 61867, 66198, 70831, 75790, 81095" rows="3" />

    <x-calc.result label="Mean absolute deviation (MAD)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '100, 107, 114, 123, 131, 140, 150, 161, 172, 184, 197, 210, 225, 241, 258, 276, 295, 316, 338, 362, 387, 414, 443, 474, 507, 543, 581, 621, 665, 711, 761, 815, 872, 933, 998, 1068, 1142, 1222, 1308, 1399, 1497, 1602, 1714, 1834, 1963, 2100, 2247, 2405, 2573, 2753, 2946, 3152, 3373, 3609, 3861, 4132, 4421, 4730, 5061, 5416, 5795, 6200, 6634, 7099, 7596, 8127, 8696, 9305, 9956, 10653, 11399, 12197, 13051, 13964, 14942, 15988, 17107, 18304, 19585, 20956, 22423, 23993, 25673, 27470, 29393, 31450, 33652, 36007, 38528, 41225, 44110, 47198, 50502, 54037, 57820, 61867, 66198, 70831, 75790, 81095'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="First digits: observed (bars) vs Benford (line)" name="digits" />
        <x-calc.rows heading="Details" :rows="[
            'verdict' => ['label' => 'Conformity (Nigrini)'],
            'chi' => ['label' => 'χ² (8 df) and p-value'],
            'n' => ['label' => 'Values used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="First-digit frequencies" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
