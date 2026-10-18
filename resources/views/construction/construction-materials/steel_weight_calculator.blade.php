<x-calc.page
    title="Steel Weight Calculator - SolveKit"
    description="Free steel weight calculator: weight of steel bar, plate, tube, angle, channel and W-beams, carbon or stainless, per foot and in total."
    lede="Work out the weight of steel bar, plate, tube, angle, channel or a W-beam."
    about="Carbon steel is 7.85 g/cm³ (490 lb/ft³, ASTM A6); stainless 304 is 7.9 and 316 is 8.0 (EN 10088-1). A W-shape's weight is in its name: a W8×31 weighs 31 lb per foot (AISC designation). Calculated shapes assume sharp corners and uniform thickness."
    :calc="['engine' => 'con-weight', 'tool' => 'metal_weight', 'fields' => ['profile', 'plate_width', 'plate_thickness', 'round_d', 'square_side', 'hex_af', 'flat_width', 'flat_thickness', 'tube_od', 'tube_wall', 'rt_width', 'rt_height', 'rt_wall', 'angle_a', 'angle_b', 'angle_t', 'ch_depth', 'ch_flange', 'ch_t', 'tee_flange', 'tee_depth', 'tee_t', 'designation', 'length', 'count', 'metal', 'density', 'price'], 'unitFields' => ['plate_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'plate_thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'round_d' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'square_side' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'hex_af' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'flat_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'flat_thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tube_od' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tube_wall' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'rt_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rt_height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rt_wall' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'angle_a' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'angle_b' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'angle_t' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'ch_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'ch_flange' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'ch_t' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tee_flange' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tee_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tee_t' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()], 'data' => ['metals' => config('construction_data.metals')]]"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'Plate, bar, tube or a structural section.'],
        ['name' => 'Enter the sizes and length', 'text' => 'In inches, millimeters or any unit.'],
        ['name' => 'Choose the metal', 'text' => 'Or enter a density.'],
    ]"
    :faqs="[
        ['question' => 'How much does a W8×31 beam weigh?', 'answer' => '31 lb per foot, so 620 lb for 20 ft.'],
        ['question' => 'How much does steel plate weigh per square foot?', 'answer' => '40.8 lb per inch of thickness (10.2 lb for ¼ in).'],
    ]"
>
    <x-calc.select name="profile" label="Shape" :options="['plate' => 'Sheet or plate', 'round' => 'Round bar', 'square' => 'Square bar', 'hex' => 'Hex bar', 'flat' => 'Flat bar', 'tube' => 'Round tube', 'rect_tube' => 'Square or rectangular tube', 'angle' => 'Angle', 'channel' => 'Channel', 'tee' => 'Tee', 'w_shape' => 'W-shape (wide flange beam)']" selected="angle" />

    <div data-show-when="profile:plate" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="plate_width" label="Width" value="24" min="0" placeholder="Width">
                <label for="calc-plate_width-unit" class="sr-only">Width unit</label>
                <select id="calc-plate_width-unit" name="plate_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="plate_thickness" label="Thickness" value="0.25" min="0" placeholder="Thickness">
                <label for="calc-plate_thickness-unit" class="sr-only">Thickness unit</label>
                <select id="calc-plate_thickness-unit" name="plate_thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:round" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="round_d" label="Diameter" value="1" min="0" placeholder="Diameter">
                <label for="calc-round_d-unit" class="sr-only">Diameter unit</label>
                <select id="calc-round_d-unit" name="round_d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:square" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="square_side" label="Side" value="1" min="0" placeholder="Side">
                <label for="calc-square_side-unit" class="sr-only">Side unit</label>
                <select id="calc-square_side-unit" name="square_side-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:hex" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hex_af" label="Across flats" value="1" min="0" placeholder="Across flats">
                <label for="calc-hex_af-unit" class="sr-only">Across flats unit</label>
                <select id="calc-hex_af-unit" name="hex_af-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:flat" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="flat_width" label="Width" value="2" min="0" placeholder="Width">
                <label for="calc-flat_width-unit" class="sr-only">Width unit</label>
                <select id="calc-flat_width-unit" name="flat_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="flat_thickness" label="Thickness" value="0.25" min="0" placeholder="Thickness">
                <label for="calc-flat_thickness-unit" class="sr-only">Thickness unit</label>
                <select id="calc-flat_thickness-unit" name="flat_thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:tube" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="tube_od" label="Outside diameter" value="2" min="0" placeholder="Outside diameter">
                <label for="calc-tube_od-unit" class="sr-only">Outside diameter unit</label>
                <select id="calc-tube_od-unit" name="tube_od-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="tube_wall" label="Wall thickness" value="0.12" min="0" placeholder="Wall thickness">
                <label for="calc-tube_wall-unit" class="sr-only">Wall thickness unit</label>
                <select id="calc-tube_wall-unit" name="tube_wall-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:rect_tube" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="rt_width" label="Width" value="2" min="0" placeholder="Width">
                <label for="calc-rt_width-unit" class="sr-only">Width unit</label>
                <select id="calc-rt_width-unit" name="rt_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="rt_height" label="Height" value="3" min="0" placeholder="Height">
                <label for="calc-rt_height-unit" class="sr-only">Height unit</label>
                <select id="calc-rt_height-unit" name="rt_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="rt_wall" label="Wall thickness" value="0.12" min="0" placeholder="Wall thickness">
                <label for="calc-rt_wall-unit" class="sr-only">Wall thickness unit</label>
                <select id="calc-rt_wall-unit" name="rt_wall-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:angle">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="angle_a" label="Leg A" value="2" min="0" placeholder="Leg A">
                <label for="calc-angle_a-unit" class="sr-only">Leg A unit</label>
                <select id="calc-angle_a-unit" name="angle_a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="angle_b" label="Leg B" value="2" min="0" placeholder="Leg B">
                <label for="calc-angle_b-unit" class="sr-only">Leg B unit</label>
                <select id="calc-angle_b-unit" name="angle_b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="angle_t" label="Thickness" value="0.25" min="0" placeholder="Thickness">
                <label for="calc-angle_t-unit" class="sr-only">Thickness unit</label>
                <select id="calc-angle_t-unit" name="angle_t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:channel" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="ch_depth" label="Depth (web)" value="4" min="0" placeholder="Depth (web)">
                <label for="calc-ch_depth-unit" class="sr-only">Depth (web) unit</label>
                <select id="calc-ch_depth-unit" name="ch_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="ch_flange" label="Flange width" value="1.5" min="0" placeholder="Flange width">
                <label for="calc-ch_flange-unit" class="sr-only">Flange width unit</label>
                <select id="calc-ch_flange-unit" name="ch_flange-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="ch_t" label="Thickness" value="0.25" min="0" placeholder="Thickness">
                <label for="calc-ch_t-unit" class="sr-only">Thickness unit</label>
                <select id="calc-ch_t-unit" name="ch_t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:tee" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="tee_flange" label="Flange width" value="3" min="0" placeholder="Flange width">
                <label for="calc-tee_flange-unit" class="sr-only">Flange width unit</label>
                <select id="calc-tee_flange-unit" name="tee_flange-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="tee_depth" label="Overall depth" value="3" min="0" placeholder="Overall depth">
                <label for="calc-tee_depth-unit" class="sr-only">Overall depth unit</label>
                <select id="calc-tee_depth-unit" name="tee_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="tee_t" label="Thickness" value="0.25" min="0" placeholder="Thickness">
                <label for="calc-tee_t-unit" class="sr-only">Thickness unit</label>
                <select id="calc-tee_t-unit" name="tee_t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="profile:w_shape" hidden>
        <x-calc.textarea name="designation" label="W-shape designation" value="W8x31" help="Nominal depth (in) × weight (lb/ft), as in the AISC Steel Construction Manual" rows="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length" value="8" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="count" label="Pieces" value="1" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="metal" label="Metal" :options="collect(config('construction_data.metals'))->filter(fn ($m, $k) => $k === 'steel' || str_starts_with($k, 'stainless'))->map(fn ($m) => $m['name'])->all()" selected="steel" />
        <x-calc.field name="density" label="Your density (optional)" value="" min="0" placeholder="Your density (optional)">
            <label for="calc-density-unit" class="sr-only">Your density (optional) unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="price" label="Price per lb (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Weight" />

    <x-calc.options :examples="[
        'W8×31, 20 ft' => ['profile' => 'w_shape', 'designation' => 'W8x31', 'length' => 20, 'length-unit' => 'ft', 'count' => 1, 'metal' => 'steel'],
        'Square tube 2 × 2 × ⅛ in' => ['profile' => 'rect_tube', 'rt_width' => 2, 'rt_width-unit' => 'in', 'rt_height' => 2, 'rt_height-unit' => 'in', 'rt_wall' => 0.125, 'rt_wall-unit' => 'in', 'length' => 20, 'length-unit' => 'ft', 'count' => 1, 'metal' => 'steel'],
        'Stainless channel' => ['profile' => 'channel', 'ch_depth' => 100, 'ch_depth-unit' => 'mm', 'ch_flange' => 50, 'ch_flange-unit' => 'mm', 'ch_t' => 5, 'ch_t-unit' => 'mm', 'length' => 6, 'length-unit' => 'm', 'count' => 1, 'metal' => 'stainless_304'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total weight'],
            'piece' => ['label' => 'Each piece'],
            'per_length' => ['label' => 'Per length'],
            'area' => ['label' => 'Cross-section'],
            'density' => ['label' => 'Density'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = cross-section area × length × density × pieces</li>
            <li>sharp corners and uniform thickness; rolled sections with fillets differ slightly</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
