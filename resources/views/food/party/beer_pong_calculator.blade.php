<x-calc.page
    title="Beer Pong Calculator - SolveKit"
    description="Free beer pong calculator: how much beer and how many cups a beer pong game or tournament needs, from games, cups per side and fill level."
    lede="Work out the beer and cups for beer pong."
    about="A standard game uses two racks of 10 cups (6 in a short game). Beer needed = games × 2 racks × cups × fill. Players often fill each cup with 2–4 fl oz rather than to the brim; one 12 oz can fills three or four cups. Drink responsibly: have water and food on hand and plan rides home. For adults of legal drinking age only."
    :calc="['engine' => 'fd-party', 'tool' => 'beer_pong', 'fields' => ['games', 'cups', 'fill']]"
    :how-to="[
        ['name' => 'Enter the games', 'text' => ''],
        ['name' => 'Set cups and fill', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much beer for an 8-game tournament?', 'answer' => '40 cans cans (2 cases of 24).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="games" label="Games" value="8" min="0" step="1" />
        <x-calc.select name="cups" label="Cups per side" :options="['10' => '10 (standard)', '6' => '6 (short game)']" selected="10" />
        <x-calc.field name="fill" label="Beer per cup" value="3" min="0" step="any" suffix="fl oz" />
    </div>

    <x-calc.result label="12 oz cans of beer" />

    <x-calc.options :decimals="false" :examples="[
        '8 games' => ['games' => 8, 'cups' => '10', 'fill' => 3],
        'Short games' => ['games' => 12, 'cups' => '6', 'fill' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cases' => ['label' => 'Cases'],
            'cups' => ['label' => 'Cups'],
            'table' => ['label' => 'Table'],
            'responsibly' => ['label' => 'Safety'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>beer = games × 2 × cups × fill</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
