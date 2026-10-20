<x-calc.page
    title="Password Combination Calculator - SolveKit"
    description="Free password combination calculator: how many passwords of a length and character set exist, the entropy in bits and the brute-force time."
    lede="Count password combinations."
    about="The number of possible passwords is the number of characters raised to the length. Entropy in bits is length × log₂(characters)."
    :calc="['engine' => 'st-prob', 'tool' => 'password', 'fields' => ['by', 'length', 'chars', 'sample', 'rate'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many 12-character passwords use letters and digits?', 'answer' => '3.22626 × 10²¹ (71.45 bits).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="by" label="Describe the password by" :options="['sets' => 'Length and characters', 'sample' => 'A sample password (not sent anywhere)']" selected="sets" />
        <div data-show-when="by:sets">
            <x-calc.field name="length" label="Length" value="12" min="1" step="any" />
        </div>
        <div data-show-when="by:sets">
            <x-calc.select name="chars" label="Characters used" :options="['10' => 'Digits only (10)', '26' => 'Lowercase letters (26)', '36' => 'Lowercase and digits (36)', '52' => 'Upper and lowercase (52)', '62' => 'Letters and digits (62)', '94' => 'Letters, digits and symbols (94)']" selected="62" />
        </div>
        <div data-show-when="by:sample">
            <x-calc.field name="sample" label="Sample password" value="Tr0ub4dor&3" type="text" inputmode="text" />
        </div>
        <x-calc.field name="rate" label="Guesses per second" value="10000000000" min="1" step="any" />
    </div>

    <x-calc.result label="Possible passwords" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['by' => 'sets', 'length' => 12, 'chars' => '62', 'sample' => 'Tr0ub4dor&3', 'rate' => 10000000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'entropy' => ['label' => 'Entropy'],
            'half' => ['label' => 'Time to search half'],
            'all' => ['label' => 'Time to search all'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
