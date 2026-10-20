<x-calc.page
    title="Hilbert's Hotel Paradox Calculator - SolveKit"
    description="Hilbert's hotel calculator: how a full hotel with infinitely many rooms fits more guests, a bus load or infinitely many buses."
    lede="Find a room in Hilbert's hotel."
    about="Every room is taken, yet new guests fit: move each guest from room n to n + 1 for one newcomer, to 2n for an infinite bus (freeing the odd rooms), and to 2ⁿ for infinitely many buses, giving bus b's passengers the powers of the (b + 1)-th prime."
    :calc="['engine' => 'mt-other', 'tool' => 'hilbert', 'fields' => ['scenario', 'room', 'k']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'Two guests arrive. Where does the guest in room 3 go?', 'answer' => 'Room 5.'],
    ]"
>
    <x-calc.select name="scenario" label="Arrivals" :options="['finite' => 'A few new guests', 'bus' => 'One infinite bus', 'buses' => 'Infinitely many infinite buses']" selected="finite" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="room" label="Track the guest in room" value="3" min="1" step="1" />
        <div data-show-when="scenario:finite,buses" hidden>
            <x-calc.field name="k" label="New guests (or seat number)" value="2" min="1" step="1" />
        </div>
    </div>

    <x-calc.result label="New room" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['scenario' => 'finite', 'room' => 3, 'k' => 2],
        'Bus' => ['scenario' => 'bus', 'room' => 3, 'k' => 2],
        'Buses' => ['scenario' => 'buses', 'room' => 3, 'k' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rule' => ['label' => 'Rule'],
            'newGuests' => ['label' => 'New guests'],
            'examples' => ['label' => 'Examples'],
            'lesson' => ['label' => 'Why it works'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n → n + k, n → 2n, n → 2ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
