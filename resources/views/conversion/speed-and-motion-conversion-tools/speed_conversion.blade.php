<x-tool-page-layout
    title="Speed Conversion Calculator - ConvertPro"
    description="Universal speed conversion calculator for all velocity units. Convert between km/h, mph, m/s, knots, Mach, and other speed measurements with precision and comprehensive analysis."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Speed Conversion</h1>
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
                                                                                        placeholder="Enter speed (e.g., 100)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Speed</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter velocity value for conversion</p>
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
                                                                                    <optgroup label="Common Speed Units">
                                                                                        <option value="kmh" selected>km/h - Kilometers per Hour</option>
                                                                                        <option value="mph">mph - Miles per Hour</option>
                                                                                        <option value="ms">m/s - Meters per Second</option>
                                                                                        <option value="fps">ft/s - Feet per Second</option>
                                                                                        <option value="knots">Knots - Nautical Miles per Hour</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Scientific Units">
                                                                                        <option value="cms">cm/s - Centimeters per Second</option>
                                                                                        <option value="mms">mm/s - Millimeters per Second</option>
                                                                                        <option value="kms">km/s - Kilometers per Second</option>
                                                                                        <option value="ips">in/s - Inches per Second</option>
                                                                                        <option value="yard_s">yd/s - Yards per Second</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="High-Speed Units">
                                                                                        <option value="mach">Mach - Speed of Sound</option>
                                                                                        <option value="c">c - Speed of Light (fraction)</option>
                                                                                        <option value="kmh_light">km/h (Light Speed)</option>
                                                                                        <option value="escape_velocity">Earth Escape Velocity</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="furlongs_fortnight">Furlongs per Fortnight</option>
                                                                                        <option value="leagues_hour">Leagues per Hour</option>
                                                                                        <option value="miles_minute">Miles per Minute</option>
                                                                                        <option value="km_minute">Kilometers per Minute</option>
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
                                                                                    <optgroup label="Common Speed Units">
                                                                                        <option value="kmh">km/h - Kilometers per Hour</option>
                                                                                        <option value="mph" selected>mph - Miles per Hour</option>
                                                                                        <option value="ms">m/s - Meters per Second</option>
                                                                                        <option value="fps">ft/s - Feet per Second</option>
                                                                                        <option value="knots">Knots - Nautical Miles per Hour</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Scientific Units">
                                                                                        <option value="cms">cm/s - Centimeters per Second</option>
                                                                                        <option value="mms">mm/s - Millimeters per Second</option>
                                                                                        <option value="kms">km/s - Kilometers per Second</option>
                                                                                        <option value="ips">in/s - Inches per Second</option>
                                                                                        <option value="yard_s">yd/s - Yards per Second</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="High-Speed Units">
                                                                                        <option value="mach">Mach - Speed of Sound</option>
                                                                                        <option value="c">c - Speed of Light (fraction)</option>
                                                                                        <option value="kmh_light">km/h (Light Speed)</option>
                                                                                        <option value="escape_velocity">Earth Escape Velocity</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="furlongs_fortnight">Furlongs per Fortnight</option>
                                                                                        <option value="leagues_hour">Leagues per Hour</option>
                                                                                        <option value="miles_minute">Miles per Minute</option>
                                                                                        <option value="km_minute">Kilometers per Minute</option>
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
                                                                                        max="8" 
                                                                                        value="3" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">3 digits</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Adjust decimal places for results</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl border-l-4 border-indigo-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Speed</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-indigo-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-indigo-600 hover:text-indigo-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Speed Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Common Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Common Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/h</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="kmhDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Metric speed</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">mph</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="mphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Imperial speed</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">m/s</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="msDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI velocity</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">knots</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="knotsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Nautical speed</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scientific Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Scientific Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">ft/s</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="fpsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Feet per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">cm/s</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="cmsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Small scale speed</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/s</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="kmsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Space velocity</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">yd/s</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="yardsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Yards per second</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- High-Speed Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">High-Speed Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mach</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="machDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Speed of sound</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-violet-50 to-purple-50 rounded-lg border-l-4 border-violet-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">c (fraction)</h5>
                                                                                            <div class="text-lg font-bold text-violet-600 font-mono" id="lightSpeedDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Light speed fraction</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg border-l-4 border-rose-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Escape Velocity</h5>
                                                                                            <div class="text-lg font-bold text-rose-600 font-mono" id="escapeVelDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Earth escape (fraction)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Furlongs/Fortnight</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="furlongsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Humorous unit</div>
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
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="100" data-from="kmh" data-to="mph">100 km/h</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="60" data-from="mph" data-to="kmh">60 mph</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="10" data-from="ms" data-to="kmh">10 m/s</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1" data-from="mach" data-to="kmh">Mach 1</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Speed Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Speed Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 m/s</strong> = 3.6 km/h</div>
                                                        <div><strong>1 km/h</strong> = 0.278 m/s</div>
                                                        <div><strong>1 mph</strong> = 1.609 km/h</div>
                                                        <div><strong>1 knot</strong> = 1.852 km/h</div>
                                                        <div><strong>Sound speed</strong> = 343 m/s</div>
                                                        <div><strong>Light speed</strong> = 299,792,458 m/s</div>
                                                        <div><strong>Escape velocity</strong> = 11.2 km/s</div>
                                                        <div><strong>Orbital velocity</strong> = 7.9 km/s</div>
                                                        <div><strong>Mach 1</strong> = 343 m/s (sea level)</div>
                                                        <div><strong>Supersonic</strong> > Mach 1</div>
                                                        <div><strong>Hypersonic</strong> > Mach 5</div>
                                                        <div><strong>Walking</strong> ≈ 1.4 m/s</div>
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
                        const kmhDisplay = document.getElementById('kmhDisplay');
                        const mphDisplay = document.getElementById('mphDisplay');
                        const msDisplay = document.getElementById('msDisplay');
                        const knotsDisplay = document.getElementById('knotsDisplay');
                        const fpsDisplay = document.getElementById('fpsDisplay');
                        const cmsDisplay = document.getElementById('cmsDisplay');
                        const kmsDisplay = document.getElementById('kmsDisplay');
                        const yardsDisplay = document.getElementById('yardsDisplay');
                        const machDisplay = document.getElementById('machDisplay');
                        const lightSpeedDisplay = document.getElementById('lightSpeedDisplay');
                        const escapeVelDisplay = document.getElementById('escapeVelDisplay');
                        const furlongsDisplay = document.getElementById('furlongsDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Speed conversion multipliers (to m/s as base)
                        const speedMultipliers = {
                            kmh: 1/3.6,
                            mph: 0.44704,
                            ms: 1,
                            fps: 0.3048,
                            knots: 0.514444,
                            cms: 0.01,
                            mms: 0.001,
                            kms: 1000,
                            ips: 0.0254,
                            yard_s: 0.9144,
                            mach: 343, // At sea level
                            c: 299792458, // Speed of light
                            kmh_light: 299792458/3.6, // Light speed in km/h
                            escape_velocity: 11200, // Earth escape velocity
                            furlongs_fortnight: 0.000166309, // Humorous unit
                            leagues_hour: 1.389, // Leagues per hour
                            miles_minute: 26.8224, // Miles per minute
                            km_minute: 16.6667 // Kilometers per minute
                        };

                        const unitLabels = {
                            kmh: 'km/h',
                            mph: 'mph',
                            ms: 'm/s',
                            fps: 'ft/s',
                            knots: 'knots',
                            cms: 'cm/s',
                            mms: 'mm/s',
                            kms: 'km/s',
                            ips: 'in/s',
                            yard_s: 'yd/s',
                            mach: 'Mach',
                            c: 'c',
                            kmh_light: 'km/h (light)',
                            escape_velocity: '× Earth escape velocity',
                            furlongs_fortnight: 'furlongs/fortnight',
                            leagues_hour: 'leagues/h',
                            miles_minute: 'mi/min',
                            km_minute: 'km/min'
                        };

                        const unitNames = {
                            kmh: 'Kilometers per Hour (km/h)',
                            mph: 'Miles per Hour (mph)',
                            ms: 'Meters per Second (m/s)',
                            fps: 'Feet per Second (ft/s)',
                            knots: 'Knots (kn)',
                            cms: 'Centimeters per Second (cm/s)',
                            mms: 'Millimeters per Second (mm/s)',
                            kms: 'Kilometers per Second (km/s)',
                            ips: 'Inches per Second (in/s)',
                            yard_s: 'Yards per Second (yd/s)',
                            mach: 'Mach Number',
                            c: 'Speed of Light (c)',
                            kmh_light: 'Light Speed (km/h based)',
                            escape_velocity: 'Earth Escape Velocity',
                            furlongs_fortnight: 'Furlongs per Fortnight',
                            leagues_hour: 'Leagues per Hour',
                            miles_minute: 'Miles per Minute (mi/min)',
                            km_minute: 'Kilometers per Minute (km/min)'
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
                                // Convert input to m/s first
                                const inputInMS = inputVal * speedMultipliers[from];
                                
                                // Convert m/s to target unit
                                const result = inputInMS / speedMultipliers[to];
                                
                                // Update primary output
                                output.textContent = withUnit(formatNumber(result), to);
                                resultTitle.textContent = unitNames[to];
                                resultDescription.textContent = `${withUnit(formatNumber(inputVal), from)} = ${withUnit(formatNumber(result), to)}`;

                                // Convert to all common units and display
                                const ms = inputInMS;
                                kmhDisplay.textContent = formatNumber(ms / speedMultipliers.kmh);
                                mphDisplay.textContent = formatNumber(ms / speedMultipliers.mph);
                                msDisplay.textContent = formatNumber(ms);
                                knotsDisplay.textContent = formatNumber(ms / speedMultipliers.knots);
                                fpsDisplay.textContent = formatNumber(ms / speedMultipliers.fps);
                                cmsDisplay.textContent = formatNumber(ms / speedMultipliers.cms);
                                kmsDisplay.textContent = formatNumber(ms / speedMultipliers.kms);
                                yardsDisplay.textContent = formatNumber(ms / speedMultipliers.yard_s);
                                machDisplay.textContent = formatNumber(ms / speedMultipliers.mach);
                                lightSpeedDisplay.textContent = formatNumber(ms / speedMultipliers.c);
                                escapeVelDisplay.textContent = formatNumber(ms / speedMultipliers.escape_velocity);
                                furlongsDisplay.textContent = formatNumber(ms / speedMultipliers.furlongs_fortnight);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Speed';
                            resultDescription.textContent = 'Converted result';
                            kmhDisplay.textContent = '--';
                            mphDisplay.textContent = '--';
                            msDisplay.textContent = '--';
                            knotsDisplay.textContent = '--';
                            fpsDisplay.textContent = '--';
                            cmsDisplay.textContent = '--';
                            kmsDisplay.textContent = '--';
                            yardsDisplay.textContent = '--';
                            machDisplay.textContent = '--';
                            lightSpeedDisplay.textContent = '--';
                            escapeVelDisplay.textContent = '--';
                            furlongsDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'kmh';
                            toUnit.value = 'mph';
                            precision.value = 3;
                            precisionValue.textContent = '3 digits';
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
                                speedExamples.forEach(btn => btn.classList.remove('bg-indigo-100', 'text-indigo-700'));
                                speedExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-indigo-100', 'text-indigo-700');
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
