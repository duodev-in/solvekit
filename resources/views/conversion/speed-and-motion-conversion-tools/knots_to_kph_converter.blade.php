<x-tool-page-layout
    title="Knots to KPH Converter - SolveKit"
    description="Professional nautical speed converter between knots and kilometers per hour. Convert marine and aviation speeds with precision for navigation and transportation calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Knots to kph Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Speed Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter speed (e.g., 20)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Speed</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter nautical or land speed value</p>
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    From Unit (Source)
                                                                                </label>
                                                                                <select 
                                                                                    id="fromUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Nautical Speed Units">
                                                                                        <option value="knots" selected>Knots (kn) - Nautical miles per hour</option>
                                                                                        <option value="nautical_mph">Nautical Miles per Hour</option>
                                                                                        <option value="nautical_mps">Nautical Miles per Second</option>
                                                                                        <option value="nautical_mpd">Nautical Miles per Day</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Standard Speed Units">
                                                                                        <option value="kph">Kilometers per Hour (km/h)</option>
                                                                                        <option value="mph">Miles per Hour (mph)</option>
                                                                                        <option value="mps">Meters per Second (m/s)</option>
                                                                                        <option value="fps">Feet per Second (ft/s)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Aviation Speed Units">
                                                                                        <option value="mach">Mach Number</option>
                                                                                        <option value="true_airspeed">True Airspeed (TAS)</option>
                                                                                        <option value="indicated_airspeed">Indicated Airspeed (IAS)</option>
                                                                                        <option value="ground_speed">Ground Speed</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Marine Speed Units">
                                                                                        <option value="beaufort">Beaufort Scale</option>
                                                                                        <option value="ship_bells">Ship's Bells Speed</option>
                                                                                        <option value="cable_length_min">Cable Lengths per Minute</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    To Unit (Target)
                                                                                </label>
                                                                                <select 
                                                                                    id="toUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Nautical Speed Units">
                                                                                        <option value="knots">Knots (kn) - Nautical miles per hour</option>
                                                                                        <option value="nautical_mph">Nautical Miles per Hour</option>
                                                                                        <option value="nautical_mps">Nautical Miles per Second</option>
                                                                                        <option value="nautical_mpd">Nautical Miles per Day</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Standard Speed Units">
                                                                                        <option value="kph" selected>Kilometers per Hour (km/h)</option>
                                                                                        <option value="mph">Miles per Hour (mph)</option>
                                                                                        <option value="mps">Meters per Second (m/s)</option>
                                                                                        <option value="fps">Feet per Second (ft/s)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Aviation Speed Units">
                                                                                        <option value="mach">Mach Number</option>
                                                                                        <option value="true_airspeed">True Airspeed (TAS)</option>
                                                                                        <option value="indicated_airspeed">Indicated Airspeed (IAS)</option>
                                                                                        <option value="ground_speed">Ground Speed</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Marine Speed Units">
                                                                                        <option value="beaufort">Beaufort Scale</option>
                                                                                        <option value="ship_bells">Ship's Bells Speed</option>
                                                                                        <option value="cable_length_min">Cable Lengths per Minute</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            </div>

                                                                            <!-- Precision Control -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Display Precision
                                                                                </label>
                                                                                <div class="flex items-center space-x-4">
                                                                                    <input 
                                                                                        type="range" 
                                                                                        id="precision" 
                                                                                        min="0" 
                                                                                        max="6" 
                                                                                        value="2" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">2 digits</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Adjust decimal places for results</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Nautical Speed Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl border-l-4 border-green-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Speed</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-green-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-green-600 hover:text-green-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Speed Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Nautical Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Nautical Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Knots</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="knotsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Nautical miles/hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Nautical MPH</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="nauticalMphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Same as knots</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-green-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Nautical MPD</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="nauticalMpdDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per day</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Beaufort Scale</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="beaufortDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Wind scale 0-12</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Standard Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Standard Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/h</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="kphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilometers/hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">mph</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="mphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">m/s</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="mpsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Meters per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mach</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="machDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Speed of sound</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Nautical Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Nautical Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="nautical-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="10" data-from="knots" data-to="kph">10 knots</button>
                                                            <button type="button" class="nautical-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="25" data-from="knots" data-to="kph">25 knots</button>
                                                            <button type="button" class="nautical-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="100" data-from="kph" data-to="knots">100 km/h</button>
                                                            <button type="button" class="nautical-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="500" data-from="knots" data-to="kph">500 knots</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Nautical Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Nautical Speed Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 knot</strong> = 1.852 km/h</div>
                                                        <div><strong>1 knot</strong> = 1.151 mph</div>
                                                        <div><strong>1 knot</strong> = 0.514 m/s</div>
                                                        <div><strong>1 nautical mile</strong> = 1.852 km</div>
                                                        <div><strong>Sailing yacht</strong> = 5-15 knots</div>
                                                        <div><strong>Motor yacht</strong> = 15-30 knots</div>
                                                        <div><strong>Ferry</strong> = 20-40 knots</div>
                                                        <div><strong>Cruise ship</strong> = 20-25 knots</div>
                                                        <div><strong>Cargo ship</strong> = 15-25 knots</div>
                                                        <div><strong>Naval destroyer</strong> = 30+ knots</div>
                                                        <div><strong>Light aircraft</strong> = 100-200 knots</div>
                                                        <div><strong>Airliner</strong> = 450-550 knots</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const precision = document.getElementById('precision');
                        const precisionValue = document.getElementById('precisionValue');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const knotsDisplay = document.getElementById('knotsDisplay');
                        const nauticalMphDisplay = document.getElementById('nauticalMphDisplay');
                        const nauticalMpdDisplay = document.getElementById('nauticalMpdDisplay');
                        const beaufortDisplay = document.getElementById('beaufortDisplay');
                        const kphDisplay = document.getElementById('kphDisplay');
                        const mphDisplay = document.getElementById('mphDisplay');
                        const mpsDisplay = document.getElementById('mpsDisplay');
                        const machDisplay = document.getElementById('machDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Speed conversion multipliers (to knots as base)
                        const speedMultipliers = {
                            knots: 1,
                            nautical_mph: 1, // Same as knots
                            nautical_mps: 3600, // nautical miles per second
                            nautical_mpd: 1/24, // nautical miles per day
                            kph: 1/1.852,
                            mph: 1/1.15078,
                            mps: 1/0.514444,
                            fps: 1/1.68781,
                            mach: 1/661.5, // Approximate at sea level
                            true_airspeed: 1, // Context dependent
                            indicated_airspeed: 1, // Context dependent
                            ground_speed: 1, // Same as true airspeed
                            beaufort: 1, // Special calculation
                            ship_bells: 1, // Maritime tradition
                            cable_length_min: 6 // 1 cable length = 0.1 nautical mile, so 1 cable/min = 6 knots
                        };

                        const unitLabels = {
                            knots: 'knots',
                            nautical_mph: 'nmi/h',
                            nautical_mps: 'nmi/s',
                            nautical_mpd: 'nmi/day',
                            kph: 'km/h',
                            mph: 'mph',
                            mps: 'm/s',
                            fps: 'ft/s',
                            mach: 'Mach',
                            true_airspeed: 'TAS',
                            indicated_airspeed: 'IAS',
                            ground_speed: 'GS',
                            beaufort: 'Beaufort',
                            ship_bells: 'bells',
                            cable_length_min: 'cables/min'
                        };

                        const unitNames = {
                            knots: 'Knots (kn)',
                            nautical_mph: 'Nautical Miles per Hour (nmi/h)',
                            nautical_mps: 'Nautical Miles per Second (nmi/s)',
                            nautical_mpd: 'Nautical Miles per Day (nmi/day)',
                            kph: 'Kilometers per Hour (km/h)',
                            mph: 'Miles per Hour (mph)',
                            mps: 'Meters per Second (m/s)',
                            fps: 'Feet per Second (ft/s)',
                            mach: 'Mach Number',
                            true_airspeed: 'True Airspeed (TAS)',
                            indicated_airspeed: 'Indicated Airspeed (IAS)',
                            ground_speed: 'Ground Speed (GS)',
                            beaufort: 'Beaufort Scale',
                            ship_bells: "Ship's Bells Speed",
                            cable_length_min: 'Cable Lengths per Minute'
                        };

                        function getPrecision() {
                            return parseInt(precision.value);
                        }

                        function formatNumber(num) {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }
                            if (num === 0) {
                                return '0';
                            }
                            const abs = Math.abs(num);
                            if (abs >= 1e12 || abs < 1e-6) {
                                return parseFloat(num.toPrecision(5)).toExponential();
                            }
                            if (abs >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: getPrecision() });
                            }
                            return num.toLocaleString(undefined, { maximumSignificantDigits: 5 });
                        }

                        function withUnit(value, unit) {
                            return unit === 'mach' ? `Mach ${value}` : `${value} ${unitLabels[unit]}`;
                        }

                        function beaufortFromKnots(knots) {
                            if (knots < 1) return 0;
                            if (knots < 4) return 1;
                            if (knots < 7) return 2;
                            if (knots < 11) return 3;
                            if (knots < 16) return 4;
                            if (knots < 22) return 5;
                            if (knots < 28) return 6;
                            if (knots < 34) return 7;
                            if (knots < 41) return 8;
                            if (knots < 48) return 9;
                            if (knots < 56) return 10;
                            if (knots < 64) return 11;
                            return 12;
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                // Convert input to knots first
                                let inputInKnots;
                                if (from === 'beaufort') {
                                    // Convert Beaufort to knots (approximate midpoint)
                                    const beaufortToKnots = [0.5, 2, 5.5, 9, 13.5, 19, 25, 31, 37.5, 44.5, 52, 60, 68];
                                    inputInKnots = beaufortToKnots[Math.min(Math.floor(inputVal), 12)] || 0;
                                } else {
                                    inputInKnots = inputVal * speedMultipliers[from];
                                }
                                
                                // Convert knots to target unit
                                let result;
                                if (to === 'beaufort') {
                                    result = beaufortFromKnots(inputInKnots);
                                } else {
                                    result = inputInKnots / speedMultipliers[to];
                                }
                                
                                // Update primary output
                                output.textContent = withUnit(formatNumber(result), to);
                                resultTitle.textContent = unitNames[to];
                                resultDescription.textContent = `${withUnit(formatNumber(inputVal), from)} = ${withUnit(formatNumber(result), to)}`;

                                // Convert to all common units and display
                                const knots = inputInKnots;
                                knotsDisplay.textContent = formatNumber(knots);
                                nauticalMphDisplay.textContent = formatNumber(knots); // Same as knots
                                nauticalMpdDisplay.textContent = formatNumber(knots * 24);
                                beaufortDisplay.textContent = beaufortFromKnots(knots);
                                kphDisplay.textContent = formatNumber(knots * 1.852);
                                mphDisplay.textContent = formatNumber(knots * 1.15078);
                                mpsDisplay.textContent = formatNumber(knots * 0.514444);
                                machDisplay.textContent = formatNumber(knots / 661.5);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Speed';
                            resultDescription.textContent = 'Converted result';
                            knotsDisplay.textContent = '--';
                            nauticalMphDisplay.textContent = '--';
                            nauticalMpdDisplay.textContent = '--';
                            beaufortDisplay.textContent = '--';
                            kphDisplay.textContent = '--';
                            mphDisplay.textContent = '--';
                            mpsDisplay.textContent = '--';
                            machDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'knots';
                            toUnit.value = 'kph';
                            precision.value = 2;
                            precisionValue.textContent = '2 digits';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);

                        precision.addEventListener('input', function() {
                            precisionValue.textContent = this.value + ' digits';
                            convert();
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const nauticalExamples = document.querySelectorAll('.nautical-example');
                        nauticalExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                nauticalExamples.forEach(btn => btn.classList.remove('bg-green-100', 'text-green-700'));
                                nauticalExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-green-100', 'text-green-700');
                            });
                        });

                        // Initialize
                        precisionValue.textContent = precision.value + ' digits';
                        inputValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
