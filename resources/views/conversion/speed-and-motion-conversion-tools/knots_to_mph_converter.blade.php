<x-tool-page-layout
    title="Knots to MPH Converter - SolveKit"
    description="Professional nautical to imperial speed converter between knots and miles per hour. Convert marine and aviation speeds for international navigation and transportation."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Knots to mph Converter</h1>
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
                                                                                        placeholder="Enter speed (e.g., 30)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Speed</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter nautical or imperial speed value</p>
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
                                                                                        <option value="cable_length_hour">Cable Lengths per Hour</option>
                                                                                        <option value="fathom_minute">Fathoms per Minute</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial Speed Units">
                                                                                        <option value="mph">Miles per Hour (mph)</option>
                                                                                        <option value="fps">Feet per Second (ft/s)</option>
                                                                                        <option value="yard_second">Yards per Second</option>
                                                                                        <option value="furlong_minute">Furlongs per Minute</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="International Units">
                                                                                        <option value="kph">Kilometers per Hour (km/h)</option>
                                                                                        <option value="mps">Meters per Second (m/s)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Aviation Units">
                                                                                        <option value="mach">Mach Number</option>
                                                                                        <option value="airspeed_knots">Airspeed (knots)</option>
                                                                                        <option value="ground_speed_mph">Ground Speed (mph)</option>
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
                                                                                        <option value="cable_length_hour">Cable Lengths per Hour</option>
                                                                                        <option value="fathom_minute">Fathoms per Minute</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial Speed Units">
                                                                                        <option value="mph" selected>Miles per Hour (mph)</option>
                                                                                        <option value="fps">Feet per Second (ft/s)</option>
                                                                                        <option value="yard_second">Yards per Second</option>
                                                                                        <option value="furlong_minute">Furlongs per Minute</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="International Units">
                                                                                        <option value="kph">Kilometers per Hour (km/h)</option>
                                                                                        <option value="mps">Meters per Second (m/s)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Aviation Units">
                                                                                        <option value="mach">Mach Number</option>
                                                                                        <option value="airspeed_knots">Airspeed (knots)</option>
                                                                                        <option value="ground_speed_mph">Ground Speed (mph)</option>
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
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Speed Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Speed</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-purple-600 hover:text-purple-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Speed Comparison Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Nautical & Imperial -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Nautical & Imperial</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Knots</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="knotsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Nautical miles/hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">MPH</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="mphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">ft/s</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="fpsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Feet per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cable Lengths/hr</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="cableLengthDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Maritime unit</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- International & Aviation -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">International & Aviation</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/h</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="kphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilometers/hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">m/s</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="mpsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Meters per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mach</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="machDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Speed of sound</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Airspeed</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="airspeedDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Aviation speed</div>
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
                <!-- Quick Speed Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Speed Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="20" data-from="knots" data-to="mph">20 knots</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="60" data-from="mph" data-to="knots">60 mph</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="100" data-from="knots" data-to="mph">100 knots</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="500" data-from="mph" data-to="knots">500 mph</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Speed Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Knots to MPH Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 knot</strong> = 1.151 mph</div>
                                                        <div><strong>1 mph</strong> = 0.869 knots</div>
                                                        <div><strong>10 knots</strong> = 11.51 mph</div>
                                                        <div><strong>20 knots</strong> = 23.02 mph</div>
                                                        <div><strong>Nautical mile</strong> = 1.151 statute miles</div>
                                                        <div><strong>Speed difference</strong> ≈ 15% (knots > mph)</div>
                                                        <div><strong>Sailing yacht</strong> = 5-15 knots</div>
                                                        <div><strong>Power boat</strong> = 25-50 knots</div>
                                                        <div><strong>Highway speed</strong> = 60-80 mph</div>
                                                        <div><strong>Light aircraft</strong> = 100-200 knots</div>
                                                        <div><strong>Commercial jet</strong> = 450-550 knots</div>
                                                        <div><strong>Sound speed</strong> = 661.5 knots</div>
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
                        const mphDisplay = document.getElementById('mphDisplay');
                        const fpsDisplay = document.getElementById('fpsDisplay');
                        const cableLengthDisplay = document.getElementById('cableLengthDisplay');
                        const kphDisplay = document.getElementById('kphDisplay');
                        const mpsDisplay = document.getElementById('mpsDisplay');
                        const machDisplay = document.getElementById('machDisplay');
                        const airspeedDisplay = document.getElementById('airspeedDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Speed conversion multipliers (to knots as base)
                        const speedMultipliers = {
                            knots: 1,
                            nautical_mph: 1, // Same as knots
                            cable_length_hour: 0.1, // 1 cable length = 0.1 nautical mile
                            fathom_minute: 0.059248, // 1 fathom = 6 feet; 360 ft/h ÷ 6076.12 ft/nmi
                            mph: 1/1.15078,
                            fps: 1/1.68781,
                            yard_second: 1/1.84570,
                            furlong_minute: 6.5174, // 1 furlong = 660 feet; 39,600 ft/h ÷ 6076.12 ft/nmi
                            kph: 1/1.852,
                            mps: 1/0.514444,
                            mach: 1/661.5, // At sea level
                            airspeed_knots: 1, // Same as knots for airspeed
                            ground_speed_mph: 1/1.15078 // Same as mph
                        };

                        const unitLabels = {
                            knots: 'knots',
                            nautical_mph: 'nmi/h',
                            cable_length_hour: 'cables/h',
                            fathom_minute: 'fathoms/min',
                            mph: 'mph',
                            fps: 'ft/s',
                            yard_second: 'yd/s',
                            furlong_minute: 'furlongs/min',
                            kph: 'km/h',
                            mps: 'm/s',
                            mach: 'Mach',
                            airspeed_knots: 'knots (air)',
                            ground_speed_mph: 'mph (ground)'
                        };

                        const unitNames = {
                            knots: 'Knots (kn)',
                            nautical_mph: 'Nautical Miles per Hour (nmi/h)',
                            cable_length_hour: 'Cable Lengths per Hour',
                            fathom_minute: 'Fathoms per Minute',
                            mph: 'Miles per Hour (mph)',
                            fps: 'Feet per Second (ft/s)',
                            yard_second: 'Yards per Second (yd/s)',
                            furlong_minute: 'Furlongs per Minute',
                            kph: 'Kilometers per Hour (km/h)',
                            mps: 'Meters per Second (m/s)',
                            mach: 'Mach Number',
                            airspeed_knots: 'Airspeed (knots)',
                            ground_speed_mph: 'Ground Speed (mph)'
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

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                // Convert input to knots first
                                const inputInKnots = inputVal * speedMultipliers[from];
                                
                                // Convert knots to target unit
                                const result = inputInKnots / speedMultipliers[to];
                                
                                // Update primary output
                                output.textContent = withUnit(formatNumber(result), to);
                                resultTitle.textContent = unitNames[to];
                                resultDescription.textContent = `${withUnit(formatNumber(inputVal), from)} = ${withUnit(formatNumber(result), to)}`;

                                // Convert to all common units and display
                                const knots = inputInKnots;
                                knotsDisplay.textContent = formatNumber(knots);
                                mphDisplay.textContent = formatNumber(knots * 1.15078);
                                fpsDisplay.textContent = formatNumber(knots * 1.68781);
                                cableLengthDisplay.textContent = formatNumber(knots * 10);
                                kphDisplay.textContent = formatNumber(knots * 1.852);
                                mpsDisplay.textContent = formatNumber(knots * 0.514444);
                                machDisplay.textContent = formatNumber(knots / 661.5);
                                airspeedDisplay.textContent = formatNumber(knots) + ' kn';

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Speed';
                            resultDescription.textContent = 'Converted result';
                            knotsDisplay.textContent = '--';
                            mphDisplay.textContent = '--';
                            fpsDisplay.textContent = '--';
                            cableLengthDisplay.textContent = '--';
                            kphDisplay.textContent = '--';
                            mpsDisplay.textContent = '--';
                            machDisplay.textContent = '--';
                            airspeedDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'knots';
                            toUnit.value = 'mph';
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
                        const speedExamples = document.querySelectorAll('.speed-example');
                        speedExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                speedExamples.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                speedExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
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
