<x-calc.page
    title="Impostor Odds Calculator – Among Us - SolveKit"
    description="Free Among Us impostor odds calculator: chance a player is the impostor and that a vote hits one."
    lede="Find the impostor odds."
    about="Without clues, every player you have not cleared is equally likely to be an impostor."
    :calc="['engine' => 'ot-play', 'tool' => 'impostor', 'fields' => ['alive', 'impostors', 'cleared', 'youCrew'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What are the odds with 7 alive and 2 impostors?', 'answer' => '40% per suspect.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="alive" label="Players still alive (including you)" value="7" min="2" step="any" />
        <x-calc.field name="impostors" label="Impostors left" value="2" min="1" step="any" />
        <x-calc.field name="cleared" label="Players you are sure are innocent (not you)" value="1" min="0" step="any" />
        <x-calc.select name="youCrew" label="You are" :options="['crew' => 'A crewmate', 'impostor' => 'An impostor']" selected="crew" />
    </div>

    <x-calc.result label="Chance a suspect is an impostor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['alive' => 7, 'impostors' => 2, 'cleared' => 1, 'youCrew' => 'crew'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'suspects' => ['label' => 'Suspects'],
            'randomVote' => ['label' => 'Chance a random ejection hits an impostor'],
            'allFound' => ['label' => 'Chance a random pick of the impostors gets all of them'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
