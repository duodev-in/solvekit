<x-tool-page-layout
    title="m/s to km/h Converter - SolveKit"
    description="Professional velocity converter between meters per second and kilometers per hour. Convert speed units for physics, engineering, and transportation calculations with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">m/s to km/h Converter</h1>
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
                                                                                    Enter Velocity Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter velocity (e.g., 25)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
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
                                                                                    <optgroup label="Metric Velocity Units">
                                                                                        <option value="ms" selected>m/s (meters per second)</option>
                                                                                        <option value="kmh">km/h (kilometers per hour)</option>
                                                                                        <option value="kms">km/s (kilometers per second)</option>
                                                                                        <option value="cms">cm/s (centimeters per second)</option>
                                                                                        <option value="mms">mm/s (millimeters per second)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial Velocity Units">
                                                                                        <option value="mph">mph (miles per hour)</option>
                                                                                        <option value="fps">ft/s (feet per second)</option>
                                                                                        <option value="ips">in/s (inches per second)</option>
                                                                                        <option value="mps">mi/s (miles per second)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Specialized Units">
                                                                                        <option value="knots">knots (nautical miles per hour)</option>
                                                                                        <option value="mach">Mach (speed of sound)</option>
                                                                                        <option value="c">c (speed of light)</option>
                                                                                        <option value="yard_s">yd/s (yards per second)</option>
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
                                                                                    <optgroup label="Metric Velocity Units">
                                                                                        <option value="ms">m/s (meters per second)</option>
                                                                                        <option value="kmh" selected>km/h (kilometers per hour)</option>
                                                                                        <option value="kms">km/s (kilometers per second)</option>
                                                                                        <option value="cms">cm/s (centimeters per second)</option>
                                                                                        <option value="mms">mm/s (millimeters per second)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial Velocity Units">
                                                                                        <option value="mph">mph (miles per hour)</option>
                                                                                        <option value="fps">ft/s (feet per second)</option>
                                                                                        <option value="ips">in/s (inches per second)</option>
                                                                                        <option value="mps">mi/s (miles per second)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Specialized Units">
                                                                                        <option value="knots">knots (nautical miles per hour)</option>
                                                                                        <option value="mach">Mach (speed of sound)</option>
                                                                                        <option value="c">c (speed of light)</option>
                                                                                        <option value="yard_s">yd/s (yards per second)</option>
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
                                                                                    class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Velocity Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Velocity</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Velocity Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Metric Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Metric Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">m/s</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="msDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI velocity unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/h</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="kmhDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Common speed unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">cm/s</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="cmsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Small scale velocity</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/s</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="kmsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">High speed unit</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Imperial & Special Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Imperial & Special</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">mph</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="mphDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">ft/s</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="fpsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Feet per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">knots</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="knotsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Nautical speed</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mach</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="machDisplay">--</div>
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
                <!-- Quick Velocity Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Velocity Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="velocity-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="10" data-from="ms" data-to="kmh">10 m/s</button>
                                                            <button type="button" class="velocity-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="60" data-from="kmh" data-to="ms">60 km/h</button>
                                                            <button type="button" class="velocity-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="100" data-from="kmh" data-to="ms">100 km/h</button>
                                                            <button type="button" class="velocity-example px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="30" data-from="mph" data-to="kmh">30 mph</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Velocity Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Velocity Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 m/s</strong> = 3.6 km/h</div>
                                                        <div><strong>1 km/h</strong> = 0.278 m/s</div>
                                                        <div><strong>1 mph</strong> = 1.609 km/h</div>
                                                        <div><strong>1 knot</strong> = 1.852 km/h</div>
                                                        <div><strong>1 ft/s</strong> = 0.305 m/s</div>
                                                        <div><strong>Sound speed</strong> = 343 m/s</div>
                                                        <div><strong>Light speed</strong> = 3×10⁸ m/s</div>
                                                        <div><strong>Earth escape</strong> = 11.2 km/s</div>
                                                        <div><strong>Walking</strong> ≈ 1.4 m/s</div>
                                                        <div><strong>Running</strong> ≈ 5 m/s</div>
                                                        <div><strong>Cycling</strong> ≈ 6 m/s</div>
                                                        <div><strong>Car highway</strong> ≈ 30 m/s</div>
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
                        const msDisplay = document.getElementById('msDisplay');
                        const kmhDisplay = document.getElementById('kmhDisplay');
                        const cmsDisplay = document.getElementById('cmsDisplay');
                        const kmsDisplay = document.getElementById('kmsDisplay');
                        const mphDisplay = document.getElementById('mphDisplay');
                        const fpsDisplay = document.getElementById('fpsDisplay');
                        const knotsDisplay = document.getElementById('knotsDisplay');
                        const machDisplay = document.getElementById('machDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Velocity conversion multipliers (to m/s as base)
                        const velocityMultipliers = {
                            ms: 1,
                            kmh: 1/3.6,
                            kms: 1000,
                            cms: 0.01,
                            mms: 0.001,
                            mph: 0.44704,
                            fps: 0.3048,
                            ips: 0.0254,
                            mps: 1609.344,
                            knots: 0.514444,
                            mach: 343,
                            c: 299792458,
                            yard_s: 0.9144
                        };

                        const unitLabels = {
                            ms: 'm/s',
                            kmh: 'km/h',
                            kms: 'km/s',
                            cms: 'cm/s',
                            mms: 'mm/s',
                            mph: 'mph',
                            fps: 'ft/s',
                            ips: 'in/s',
                            mps: 'mi/s',
                            knots: 'knots',
                            mach: 'Mach',
                            c: 'c',
                            yard_s: 'yd/s'
                        };

                        const unitNames = {
                            ms: 'Meters per Second (m/s)',
                            kmh: 'Kilometers per Hour (km/h)',
                            kms: 'Kilometers per Second (km/s)',
                            cms: 'Centimeters per Second (cm/s)',
                            mms: 'Millimeters per Second (mm/s)',
                            mph: 'Miles per Hour (mph)',
                            fps: 'Feet per Second (ft/s)',
                            ips: 'Inches per Second (in/s)',
                            mps: 'Miles per Second (mi/s)',
                            knots: 'Knots (kn)',
                            mach: 'Mach Number',
                            c: 'Speed of Light (c)',
                            yard_s: 'Yards per Second (yd/s)'
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
                                const inputInMS = inputVal * velocityMultipliers[from];
                                
                                // Convert m/s to target unit
                                const result = inputInMS / velocityMultipliers[to];
                                
                                // Update primary output
                                output.textContent = withUnit(formatNumber(result), to);
                                resultTitle.textContent = unitNames[to];
                                resultDescription.textContent = `${withUnit(formatNumber(inputVal), from)} = ${withUnit(formatNumber(result), to)}`;

                                // Convert to all common units and display
                                const ms = inputInMS;
                                msDisplay.textContent = formatNumber(ms / velocityMultipliers.ms);
                                kmhDisplay.textContent = formatNumber(ms / velocityMultipliers.kmh);
                                cmsDisplay.textContent = formatNumber(ms / velocityMultipliers.cms);
                                kmsDisplay.textContent = formatNumber(ms / velocityMultipliers.kms);
                                mphDisplay.textContent = formatNumber(ms / velocityMultipliers.mph);
                                fpsDisplay.textContent = formatNumber(ms / velocityMultipliers.fps);
                                knotsDisplay.textContent = formatNumber(ms / velocityMultipliers.knots);
                                machDisplay.textContent = formatNumber(ms / velocityMultipliers.mach);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Velocity';
                            resultDescription.textContent = 'Converted result';
                            msDisplay.textContent = '--';
                            kmhDisplay.textContent = '--';
                            cmsDisplay.textContent = '--';
                            kmsDisplay.textContent = '--';
                            mphDisplay.textContent = '--';
                            fpsDisplay.textContent = '--';
                            knotsDisplay.textContent = '--';
                            machDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'ms';
                            toUnit.value = 'kmh';
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
                        const velocityExamples = document.querySelectorAll('.velocity-example');
                        velocityExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                velocityExamples.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                velocityExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
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
